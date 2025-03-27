<?php

namespace app\controllers;

use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\ProductMeta;
use app\models\ProductMetaLang;
use app\models\Reviews;
use app\models\User;
use yii\bootstrap5\BootstrapAsset;
use yii\httpclient\Client;

class ProductController extends Controller
{

    public function actionIndex($index)
    {
        $request = Yii::$app->request->get();
        $currency = $request['lang'];
        Yii::$app->language = mb_strtolower($currency) . "-" . mb_strtoupper($currency);
        $parentArray = [];
        if ($currency == 'ru') {
            $metaProduct = ProductMeta::find()->where(['value' => $index])->andWhere(['meta' => 'link'])->one();
        } else {
            $metaProduct = ProductMetaLang::find()->where(['value' => $index])->andWhere(['meta' => 'link'])->one();
            try{
                $parent = $metaProduct->parent;
                $parentArray = ArrayHelper::map($parent, 'meta', 'value');
            }catch(Exception $e){

            }
        }
        try {
            $model = Product::findOne($metaProduct->product_id);
        } catch (\Exception $e) {
            return $this->goHome();
        }
        $metaArray = $model->arrayMeta($currency);
        
        $url = Yii::$app->params['requestHost']."api/content";
        $result = $this->CrosReqyest($model->getParam('content', $currency), $url, $currency);
        $this->getView()->registerCssFile("@web/css/products.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $reviews = Reviews::find()
            ->select(['reviews.*', 'uid' => 'user.id', 'user.firstName', 'user.LastName', 'user.secondName'])
            ->leftJoin('user', 'reviews.user_id=user.id')
            ->where(['reviews.product_id' => $model->id])
            ->andWhere(['reviews.status' => 2])
            ->groupBy('reviews.id')
            ->all();
        $this->getView()->registerCssFile("@web/css/main-page.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $reviewsForm = new Reviews();
        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();
            $reviewsForm->user_id = Yii::$app->user->identity->id;
            $reviewsForm->product_id = $metaProduct->product_id;
            $reviewsForm->text = $data['comment'];
            $reviewsForm->star = $data['count_rate_review'];

            if ($reviewsForm->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app','review-success'));
                return $this->refresh();
            } else {
                debug($reviewsForm->getErrors());
            }

        }
        
        if(isset($metaArray['with-this-product']) && !empty($metaArray['with-this-product'])){
            $upsale = Product::find()
            ->where(['id' => json_decode($metaArray['with-this-product'], true)])
            ->all();
        }else{
            $upsale = Product::find()
            ->where(['upsale' => '1'])
            ->andWhere(['active' => '1'])
            ->andWhere(['not in', 'id', $model->id])
            ->all();
        }
        $user_id = null;

        if(!Yii::$app->user->isGuest){
            $user_id = Yii::$app->user->identity->id;
        }
        return $this->render('index', [
            'reviewsForm' => $reviewsForm,
            'model' => $model,
            'result' => $result,
            'currency' => $currency,
            'metaArray' => $metaArray,
            'reviews' => $reviews,
            'upsale' => $upsale,
            'user_id' => $user_id,
            'parentArray' => $parentArray
        ]);
    }

    private function CrosReqyest($id, $url, $currency)
    {
        $client = new Client(['baseUrl' => $url]);
        $response = $client->createRequest()
            ->setMethod('POST')
            ->addHeaders(['content-type' => 'application/json'])
            ->addHeaders(['apikey' => 'yii2-magaz-hash'])
            ->setData(['post_id' => $id, 'lang' => $currency])
            ->send();

        return $response->data;
    }

    public function actionLoadReviews(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $newData = ArrayHelper::map($data['data'], 'name', 'value');
            $reviewsForm = new Reviews([
                'user_id' => $newData['user_id'],
                'product_id' => $newData['product_id'],
                'star' => $newData['count_rate_review'],
                'text' => $newData['comment'],
                'username' => $newData['username']
            ]);
            if($reviewsForm->save()){
                return true;
            }
        }
    }


    
}