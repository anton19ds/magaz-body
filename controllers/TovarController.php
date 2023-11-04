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
use app\models\User;

class TovarController extends Controller
{
  public function actionIndex($id){
    $model = Product::findOne($id);
    $url = "http://body-dev.na4u.ru/api/v1/content";
    $result = $this->CrosReqyest($model->getParam('content'), $url);
    var_dump($result);
    // return $this->render('index',[
    //   'model' => $model,
    //   'result' => $result
    // ]);
  }

  private function CrosReqyest($id, $url)
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      
      CURLOPT_URL => $url,
      // CURLOPT_URL => 'http://body-dev.na4u.ru/api/v1/content',
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