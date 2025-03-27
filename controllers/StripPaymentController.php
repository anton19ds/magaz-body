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

class StripPaymentController extends Controller
{
    public function actionIndex(){
        if(isset(Yii::$app->params['spriteKey'])){
            
            return $this->render('index', [
                'stripeSecretKey' => Yii::$app->params['spriteKey']
            ]);
        }
        // $stripe = new \Stripe\StripeClient('sk_test_BQokikJOvBiI2HlWgH4olfQ2');
        // $customer = $stripe->customers->create([
        // 'description' => 'example customer',
        // 'email' => 'email@example.com',
        // 'payment_method' => 'pm_card_visa',
        // ]);
        // echo $customer;







        
    }
}