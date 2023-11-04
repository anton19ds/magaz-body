<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\ProductMeta;
use app\models\ProductMetaLang;
use app\models\User;
use yii\bootstrap5\BootstrapAsset;

class ProductController extends Controller
{
    public function actionIndex($index)
    {
        
        $request = Yii::$app->request->get();
        $currency = $request['lang'];
        Yii::$app->language = mb_strtolower($currency)."-".mb_strtoupper($currency);
        if($currency == 'ru'){
            $metaProduct = ProductMeta::find()->where(['value' => $index])->andWhere(['meta' => 'link'])->one();
        }else{
            $metaProduct = ProductMetaLang::find()->where(['value' => $index])->andWhere(['meta' => 'link'])->andWhere(['tag' => $currency])->one();
        }
        try{
            $model = Product::findOne($metaProduct->product_id);
        }catch(\Exception $e){
            return $this->goHome();
        }
        $metaArray = $model->arrayMeta($currency);
        $url = "http://body-dev.na4u.ru/api/v1/content";
        $result = $this->CrosReqyest($model->getParam('content', $currency), $url);
        $this->getView()->registerCssFile("@web/css/products.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        return $this->render('index', [
            'model' => $model,
            'result' => $result,
            'currency' => $currency,
            'metaArray' => $metaArray
        ]);
    }

    private function CrosReqyest($id, $url)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(

                CURLOPT_URL => $url,
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