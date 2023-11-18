<?php

namespace app\modules\user\controllers;

use app\models\AccessInfoProduct;
use app\models\InfoStep;
use app\models\Orders;
use app\models\Product;
use app\models\ProductMeta;
use app\models\StepUserChek;
use app\models\User;
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
                    return $action->controller->goHome();
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'list', 'step', 'pre-view'],
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request->get();
        $metaInfoProduct = ProductMeta::find()->where(['meta' => 'type'])->andWhere(['value' => 'info'])->all();

        $access = AccessInfoProduct::find()->where(['user_id' => Yii::$app->user->identity->id])->asArray()->all();
        $listArray = ArrayHelper::map($access, 'id', 'product_id');

        // $this->getView()->registerCssFile("@web/css/user.css", [
        //     'depends' => [BootstrapAsset::class],
        // ]);
        // $this->getView()->registerJsFile("@web/js/user_order.js", [
        //     'depends' => [\yii\web\YiiAsset::class],
        // ]);

        return $this->render('index', [
            'lang' => $request['lang'],
            'listArray' => $listArray,
            'metaInfoProduct' => $metaInfoProduct
        ]);
    }

    public function actionView()
    {
        $reuest = Yii::$app->request->get();
        $product_meta = ProductMeta::find()->where(['meta' => 'link'])->andWhere(['value' => $reuest['product']])->one();
        $product = $product_meta->getProduct();
        $meta = $product->arrayMeta($reuest['lang']);
        $imageProduct = null;
        if(isset($meta['image']) && !empty($meta['image'])){
            $imageArray = json_decode($meta['image'], true);
            // debug($imageArray);
            $imageProduct = $imageArray['array'][1]['value'];
        }
        $steps = $product->getStep();
        return $this->render('view', [
            'steps' => $steps,
            'imageProduct' => $imageProduct,
            'meta' => $meta,
            'lang' => $reuest['lang'],
            'product_link' => $reuest['product'],
            'product' => $product
        ]);
    }

    public function actionList()
    {
        $reuest = Yii::$app->request->get();
        $product_meta = ProductMeta::find()->where(['meta' => 'link'])->andWhere(['value' => $reuest['product']])->one();
        
        $product = $product_meta->getProduct();

        $meta = $product->arrayMeta();
        $stepInfo = InfoStep::find()->where(['info_id' => $product->id])->all();
        
        
        return $this->render('list', [
            'meta' => $meta,
            'lang' => $reuest['lang'],
            'product_link' => $reuest['product'],
            'product' => $product,
            'stepInfo' => $stepInfo
        ]);
    }

    public function actionStep()
    {
        try {
            $reuest = Yii::$app->request->get();
            if (!StepUserChek::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['step_id' => $reuest['step']])->exists()) {
                $model = new StepUserChek([
                    'user_id' => Yii::$app->user->identity->id,
                    'step_id' => $reuest['step']
                ]);
                $model->save();
            }

            $product_meta = ProductMeta::find()->where(['meta' => 'link'])->andWhere(['value' => $reuest['product']])->one();
            $product = $product_meta->getProduct();

            $meta = $product->arrayMeta();
            $stepInfo = InfoStep::find()->where(['info_id' => $product->id])->orderBy(['sort' => SORT_ASC])->asArray()->all();

            $step = InfoStep::findOne($reuest['step']);
            $nexStep = InfoStep::find()->where(['info_id' => $product->id])->having(['>', 'sort', $step->sort])->asArray()->one();

            $content = $this->getArticles($step->content);

            
            return $this->render('step', [
                'lang' => $reuest['lang'],
                'product_link' => $reuest['product'],
                'step' => $step,
                'content' => $content,
                'nexStep' => $nexStep
            ]);
        } catch (\Exception $e) {
            Yii::info($e->getMessage());
            return $this->redirect(['index']);
        }
    }

    public function actionPreView()
    {
        $request = Yii::$app->request->get();

        $model = Product::findOne($request['product']);
        $meta = $model->arrayMeta($request['lang']);
        if(isset($meta['image']) && !empty($meta['image'])){
            $imageArray = json_decode($meta['image'], true);
            // debug($imageArray);
            $imageProduct = $imageArray['array'][1]['value'];
        }
        $steps = $model->getStep();
        return $this->render('pre-view', [
            'meta' => $meta,
            'imageProduct' => $imageProduct,
            'model' => $model,
            'lang' => $request['lang'],
            'steps' => $steps
        ]);

    }

    protected function getArticles($id)
    {

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(

                //CURLOPT_URL => $url,
                CURLOPT_URL => 'http://body-dev.na4u.ru/api/v1/content',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('post_id' => $id),
                CURLOPT_HTTPHEADER => array(
                    'Apikey: yii2-magaz-hash'
                ),
            )
        );
        $response = curl_exec($curl);
        return json_decode($response, true);
    }
}