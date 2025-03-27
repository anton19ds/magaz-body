<?php

namespace app\modules\user\controllers;

use app\models\AccessInfoProduct;
use app\models\CategoryInfoproduct;
use app\models\InfoStep;
use app\models\InfoStepLang;
use app\models\Orders;
use app\models\Product;
use app\models\ProductMeta;
use app\models\ProductMetaLang;
use app\models\StepDescUser;
use app\models\StepUserChek;
use app\models\User;
use app\models\ViewProduct;
use Codeception\Step\Meta;
use Yii;
use yii\bootstrap5\BootstrapAsset;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `user` module
 */
class InfoProductController extends Controller
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        $request = Yii::$app->request->get();
                        return $action->controller->redirect('/' . $request['lang'] . '/login');
                    } else {
                        return $action->controller->goHome();
                    }
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'list', 'step', 'pre-view', 'update-step'],
                        'roles' => ['user', 'administrator'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        if ($request['lang'] == 'ru') {
            $metaInfoProduct = ProductMeta::find()->where(['meta' => 'type'])->andWhere(['value' => 'info'])->all();
            $access = AccessInfoProduct::find()->where(['user_id' => Yii::$app->user->identity->id])->asArray()->all();
            $listArray = ArrayHelper::map($access, 'id', 'product_id');
            $query = Product::find()
                ->leftJoin('product_meta', 'product_meta.product_id = product.id')
                ->where(['product_meta.value' => 'info'])
                ->all();
        } else {
            $metaInfoProduct = ProductMeta::find()->where(['meta' => 'type'])->andWhere(['value' => 'info'])->all();
            $access = AccessInfoProduct::find()->where(['user_id' => Yii::$app->user->identity->id])->asArray()->all();
            $listArray = ArrayHelper::map($access, 'id', 'product_id');
            $query = Product::find()
                ->leftJoin('product_meta', 'product_meta.product_id = product.id')
                ->where(['product_meta.value' => 'info'])
                ->all();
        }


        return $this->render('index', [
            'lang' => $request['lang'],
            'listArray' => $listArray,
            'metaInfoProduct' => $metaInfoProduct,
            'query' => $query
        ]);
    }

    public function actionView()
    {
        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        $acsseInfoproduct = AccessInfoProduct::find()
            ->where(['user_id' => Yii::$app->user->identity->id])
            ->indexBy('product_id')
            ->asArray()
            ->all();
        if ($request['lang'] == 'ru') {
            $product_meta = ProductMeta::find()->where(['meta' => 'link'])->andWhere(['value' => $request['product']])->one();
        } else {
            if (
                ProductMetaLang::find()
                    ->where(['meta' => 'link'])
                    ->andWhere(['value' => $request['product']])
                    ->andWhere(['tag' => $request['lang']])->exists()
            ) {
                $product_meta = ProductMetaLang::find()
                    ->where(['meta' => 'link'])
                    ->andWhere(['value' => $request['product']])
                    ->andWhere(['tag' => $request['lang']])
                    ->one();
            } else {
                if(ProductMeta::find()->where(['meta' => 'link'])->andWhere(['value' => $request['product']])->exists()){
                    $product_meta = ProductMeta::find()->where(['meta' => 'link'])->andWhere(['value' => $request['product']])->one();
                }
            }
        }

        try {
            $product = Product::find()->where(['id' => $product_meta->product_id])->one();
        } catch (\Exception $e) {
            return $this->redirect('/'.$request['lang'].'/user/info-product');
        }
        //debug($product->id);
        if(ViewProduct::find()
            ->where(['product_id' => $product->id])
            ->andWhere(['tag' => $request['lang']])
            ->andWhere(['status' => 0])
            ->exists()){
            return $this->redirect('/'.$request['lang'].'/user/info-product');
        }
        $order = Orders::find()->where(['uuid' => $acsseInfoproduct[$product->id]['uuid']])->asArray()->one();
        $dataActive = $product->getParam('date-info', null);
        if (!empty($order) && isset($order['date'])) {
            $timestamp = $order['date'];
        } else {
            if ($acsseInfoproduct[$product->id]['date']) {
                $timestamp = $acsseInfoproduct[$product->id]['date'];
            } else {
                $timestamp = time();
            }
        }
        $date_end = date("d.m.Y", strtotime('+' . $dataActive . ' day', $timestamp));
        $infoCategory = CategoryInfoproduct::find()->where(['infoproduct_id' => $product->id])->andWhere(['tag' => $request['lang']])->orderBy(['sort' => SORT_ASC])->all();
        if (isset($acsseInfoproduct[$product->id])) {
            $imageProduct = null;
            return $this->render('view', [
                'infoCategory' => $infoCategory,
                'imageProduct' => $imageProduct,
                'lang' => $request['lang'],
                'product_link' => $request['product'],
                'product' => $product,
                'date_end' => $date_end,
                'acsseInfoproduct' => $acsseInfoproduct
            ]);
        }
    }

    public function actionList()
    {

        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        $category = CategoryInfoproduct::findOne($request['product']);
        if(strcasecmp($category->tag, $request['lang']) != 0){
            return $this->redirect('/'.$request['lang'].'/user/info-product');
        }
        if ($request['lang'] == 'ru') {
            $product_meta = ProductMeta::find()->where(['meta' => 'link'])->andWhere(['value' => $category->infoproduct_id])->one();
        } else {
            $product_meta = ProductMetaLang::find()
                ->where(['meta' => 'link'])
                ->andWhere(['value' => $category->infoproduct_id])
                ->andWhere(['tag' => $request['lang']])
                ->one();
        }
        $product = Product::find()
            ->where(['id' => $category->infoproduct_id])
            ->one();
        if(ViewProduct::find()
            ->where(['product_id' => $product->id])
            ->andWhere(['tag' => $request['lang']])
            ->andWhere(['status' => 0])
            ->exists()){
            return $this->redirect('/'.$request['lang'].'/user/info-product');
        }
        $dataProduct = AccessInfoProduct::find()->where(['product_id' => $product->id])->andWhere(['user_id' => Yii::$app->user->identity->id])->asArray()->one();
        //var_dump($dataProduct);
        $infoStep = InfoStep::find()->where(['category_id' => $category->id])->orderBy(['sort' => SORT_ASC])->all();
        try {
            $order = $dataProduct->orders->statusDate; 
        } catch (\Exception $e) {
            $order = time();
        }
        return $this->render('list', [
            'dataProduct' => $dataProduct,
            'lang' => $request['lang'],
            'product' => $product,
            'product_link' => $request['product'],
            'order' => $order,
            'infoStep' => $infoStep,
            'category' => $category
        ]);
    }

    public function actionStep()
    {
        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        $stepParent = null;

        $step = InfoStep::findOne($request['step']);

        if(!StepUserChek::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['step_id' => $step->id])->exists()){
            $stepSaveData = new StepUserChek([
                'user_id' => Yii::$app->user->identity->id,
                'step_id' => $step->id
            ]);
            $stepSaveData->save();
        }
       //debug($step->category->tag);
        if (strcasecmp($step->category->tag, $request['lang']) != 0) {
            return $this->redirect('/'.$request['lang'].'/user/info-product');
        }
        
        $product = Product::find()->where(['id' => $step->info_id])->one();
        if(ViewProduct::find()
            ->where(['product_id' => $product->id])
            ->andWhere(['tag' => $request['lang']])
            ->andWhere(['status' => 0])
            ->exists()){
            return $this->redirect('/'.$request['lang'].'/user/info-product');
        }


        if ($request['lang'] == 'ru') {
            $product_meta = ProductMeta::find()->where(['meta' => 'link'])->andWhere(['value' => $request['product']])->one();
        } else {
            $product_meta = ProductMetaLang::find()
                ->where(['meta' => 'link'])
                ->andWhere(['value' => $request['product']])
                ->andWhere(['tag' => $request['lang']])
                ->one();
        }
        if ($product_meta && Product::find()->where(['id' => $product_meta->product_id])->exists()) {
            $product = Product::find()
                ->where(['id' => $product_meta->product_id])
                ->one();
        }
        //$stepInfo = InfoStep::find()->where(['info_id' => $product['id']])->orderBy(['sort' => SORT_ASC])->asArray()->all();
        //debug($product_meta);


        $nexStep = InfoStep::find()->where(['info_id' => $request['product']])->having(['>', 'sort', $step->sort])->asArray()->one();
        $content = $this->getArticles($step->content, $step->lang);

        return $this->render('step', [
            'lang' => $request['lang'],
            'product_link' => $request['product'],
            'step' => $step,
            'content' => $content,
            'nexStep' => $nexStep,
            'product' => $product
        ]);
    }

    public function actionPreView()
    {

        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        if ($request['lang'] == 'ru') {
            $product_meta = ProductMeta::find()->where(['meta' => 'link'])->andWhere(['value' => $request['product']])->asArray()->one();
        } else {
            $product_meta = ProductMetaLang::find()->where(['meta' => 'link'])->andWhere(['value' => $request['product']])->andWhere(['tag' => $request['lang']])->asArray()->one();
        }
        try {
            $model = Product::find()
            ->where(['id' => $product_meta['product_id']])
            ->with('infoStep')
            ->one();
        } catch (\Exception $e) {
            return $this->redirect('/'.$request['lang'].'/user/info-product');
        }
        
        $dataActive = $model->getParam('date-info', null);
        $date_end = null;
        $timestamp = time();
        if ($dataActive) {
            $date_end = date("d.m.Y", strtotime('+' . $dataActive . ' day', $timestamp));
        }
        $infoCategory = CategoryInfoproduct::find()->where(['infoproduct_id' => $model->id])->andWhere(['tag' => $request['lang']])->orderBy(['sort' => SORT_ASC])->all();

        return $this->render('pre-view', [
            'model' => $model,
            'lang' => $request['lang'],
            'date_end' => $date_end,
            'infoCategory' => $infoCategory
        ]);

    }

    protected function getArticles($id, $lang = null)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://anticandida.com/api/content',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('post_id' => $id, 'lang' => $lang),
                CURLOPT_HTTPHEADER => array(
                    'Apikey: yii2-magaz-hash'
                ),
            )
        );
        $response = curl_exec($curl);
        return json_decode($response, true);
    }

    public function actionUpdateStep(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            if(!StepDescUser::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['step_id'=> $data['id']])->exists()){
                $model = new StepDescUser([
                    'user_id' => Yii::$app->user->identity->id,
                    'step_id'=> $data['id'],
                    'status' => 1
                ]);
                if($model->save()){
                    return true;
                }else{
                    var_dump($model->getErrors());
                }
            }
        }
    }
}
