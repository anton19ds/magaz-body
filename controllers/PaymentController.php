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

class PaymentController extends Controller
{


public function beforeAction($action)
{
    if (in_array($action->id, ['success', 'result', 'fail', 'payment-callback'])) {
        $this->enableCsrfValidation = false;
    }
    return parent::beforeAction($action);
}


    public function actionSuccess(){
        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);

        $this->getView()->registerCssFile("@web/css/page-success.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        return $this->render('payment');
    }

    public function actionResult(){
        
        if($_POST){
            $model = new PaymentData([
                'data' => serialize($_POST),
                'order_id' => $_POST['orderId'],
                'statys' => $_POST['paymentStatus'],
                'paymentId' => $_POST['paymentId']
                
            ]);
            $model->save();
            if(isset($_POST['orderId']) &&
                isset($_POST['paymentStatus']) &&
                $_POST['paymentStatus'] == 5 &&
                OrderStatus::find()
                    ->where(['order_id' => $_POST['orderId']])
                    ->andWhere(['status' => OrderStatus::STATUS_NEW])
                    ->exists()
            ){
                $OrderStatus = OrderStatus::find()
                ->where(['order_id' => $_POST['orderId']])
                ->andWhere(['status' => OrderStatus::STATUS_NEW])
                ->one();
                $OrderStatus->status = OrderStatus::STATUS_PAY;
                if($OrderStatus->save()){
                    MailMessage::SendPaySuccess($_POST['orderId']);
                    return 'Ok';
                };
            } 
        }
        return 'Not save';
        
    }

    public function actionFail(){
        if($_POST){
            debug($_POST);
        }
    }

    public function actionError(){
        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);

        $this->getView()->registerCssFile("@web/css/page-success.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        return $this->render('error');
    }
 
    public function actionPaymentCallback(){
        $request = Yii::$app->request;

        Yii::debug(json_encode($request));
        Yii::debug(json_encode($_POST));
        debug('123');
        return true;
    }
    
}