<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\MailMessage;
use app\models\Orders;
use app\models\OrderStatus;
use app\models\PaymentData;
use Yii;
use yii\bootstrap5\BootstrapAsset;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\User;

class ParserDataController extends Controller
{
    public function __construct()
    {

    }

    public function actionIndex()
    {
        $model = OrderStatus::find()->where(['id' => '111'])->asArray()->all();
        debug($model);
        //return '123';
    }
}