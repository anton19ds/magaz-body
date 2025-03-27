<?php

namespace app\controllers;

use app\models\AccessInfoProduct;
use app\models\Cart;
use app\models\Category;
use app\models\CategoryLang;
use app\models\MailMessage;
use app\models\Orders;
use app\models\OrderStatus;
use app\models\SettingData;
use app\models\TelegramChatList;
use app\models\UserBalance;
use app\models\UserReport;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Product;
use app\models\PromoUser;
use app\models\User;
use app\models\UserActivePromo;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use yii\bootstrap5\BootstrapAsset;
use yii\helpers\ArrayHelper;

class QaringController extends Controller
{
    /**
     * {@inheritdoc}
     */

    //  public function beforeAction($action)
    // {
    //     if ($action->id == 'gbpay' || $action->id == 'product-info') {
    //         Yii::$app->request->enableCsrfValidation = false;
    //     }

    //     return parent::beforeAction($action);
    // }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                ],
            ],
        ];
    }

    public function actionTestYandex()
    {
        $model = OrderStatus::find()
            ->innerJoin('orders_meta', 'order_status.order_id = orders_meta.order_id')
            ->where(['order_status.status' => 'new'])
            ->andWhere(['orders_meta.payment_type' => 'yandex'])
            ->asArray()
            ->all();
        foreach ($model as $element) {
            if ($this->sendCheck($element['order_id'])) {
                //OrderStatus::UpdateStatus($element['order_id']);
                $this->UpdateStatus($element['order_id'], OrderStatus::STATUS_PAY);
            }
        }
    }

    private function sendCheck($order_id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pay.yandex.ru/api/merchant/v1/orders/{$order_id}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Api-Key fef97f1f7b12445c9edee7e0547c8662.UauLU3UVW00OQR_n9-2WEw7B6J4we-RK',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        if (isset($data['data']['order']['paymentStatus']) && $data['data']['order']['paymentStatus'] == "CAPTURED") {
            return true;
        }
        return false;
    }





    private function UpdateStatus($order_id, $status_value)
    {
        $models = $this->findModel($order_id);
        $modelsMeta = $models->ordersMeta;
        $statusOrders = $models->orderStatus;
        $statusOrders->status = $status_value;

        if ($status_value == OrderStatus::STATUS_PAY) {
            $user = User::find()->where(['id' => $models->user_id])->one();
            $messageSendOrder = MailMessage::UpdateStatus($order_id, 4);
            $lang = $models->cyrrency;
            $this->AddAccess($models->data_order, $models->user_id, $models->uuid, $lang, $user);
            MailMessage::SendPaySuccess($order_id);
            MailMessage::NewPromo($order_id);
        }
        if ($statusOrders->save()) {
            if (OrderStatus::STATUS_PAY == $status_value) {
                if (!empty($modelsMeta->promocode)) {
                    $orderList = unserialize($models->data_order);
                    $product = Product::find()->where(['id' => array_keys(unserialize($models->data_order))])->all();
                    $summCashBack = Cart::PromocodeSizeSale(['data' => $orderList], $product, $models->cyrrency, $modelsMeta->promocode, true);
                    if (!UserBalance::find()->where(['order_id' => $models->id])->exists()) {
                        $userBalance = new UserBalance([
                            'user_id' => $modelsMeta->promoUser->user_id,
                            'summ' => $models->Reward(),
                            'type' => UserBalance::STATUS_REFILL,
                            'order_id' => $models->id
                        ]);
                        $userBalance->save();
                    }
                } else {
                    return '123';
                }
            }
        } else {
            debug($statusOrders->getErrors);
        }
    }

    public function AddAccess($data_order, $user_id, $uuid, $lang, $user)
    {
        $data = unserialize($data_order);
        foreach ($data as $key => $value) {
            if (Product::getTypeInProduct($key) == 'made') {
                $dataSet = Product::getProductInProduct($key);
                if ($dataSet) {
                    foreach ($dataSet as $el => $item) {
                        if (Product::getTypeInProduct($item) == 'info') {
                            $addAccess = AccessInfoProduct::addAccess($user_id, $item, $uuid);
                            $product = Product::findOne($item);
                            MailMessage::OpenInfo($lang, $user->email, $attr = [
                                'username' => $user->email,
                                'password' => $user->password,
                                'name' => $user->email,
                                'infoproduct-name' => $product->getParam('productName', $lang),
                                'infoproduct-link' => 'https://anticandida.com/' . $lang . '/user/info-product/' . $product->getParam('link', $lang)
                            ]);
                        }
                        ;
                    }
                }
            } else {
                if (Product::getTypeInProduct($key) == 'info') {
                    $addAccess = AccessInfoProduct::addAccess($user_id, $key, $uuid);
                    $product = Product::findOne($key);
                    MailMessage::OpenInfo($lang, $user->email, $attr = [
                        'username' => $user->email,
                        'password' => $user->password,
                        'name' => $user->email,
                        'infoproduct-name' => $product->getParam('productName', $lang),
                        'infoproduct-link' => 'https://anticandida.com/' . $lang . '/user/info-product/' . $product->getParam('link', $lang)
                    ]);
                }
                ;
            }
        }
    }

    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGbpay()
    {
        $orderId = rand(0, 99) . rand(0, 99);
        $price = 10000;
        $currency = 203;
        $flag = 1;
        $merchantId = Yii::$app->params['gpbwebpay-merchat'];
        $opeation = "CREATE_ORDER";
        $url = "https://frame.anticandida.com/cs/sets-data";
        $signCode = $merchantId . "|" . $opeation . "|" . $orderId . "|" . $price . "|" . $currency . "|" . $flag . "|".$url;
        $paymuzo = "https://3dsecure.gpwebpay.com/pgw/order.do";
        $get = "";
        $get .= "&CURRENCY=$currency";
        $get = "MERCHANTNUMBER=" . urlencode(trim($merchantId)) . "&OPERATION=$opeation&ORDERNUMBER=" . urlencode($orderId)
            . "&AMOUNT=" . trim($price) . "&DEPOSITFLAG=$flag";
        if (isset($currency) && trim($currency) != "") {
            $get .= "&CURRENCY=$currency";
        }
        
        $get .= "&URL=" . urlencode($url);
        $split = explode("|", $paymuzo, 2);
        if (sizeof($split) >= 1) {
            $paymuzo = $split[0];
        }
        $get .= "&DIGEST=" . urlencode($this->setData($signCode));
        $path = $paymuzo . "?" . $get;
        return $this->render(
            'view',
            [
                'path' => $path
            ]
        );
    }

    public function setData($text)
    {
        $privateKey = __DIR__ . '/../web/sert/gpwebpay-pvk.key';

        $privateKeyPassword = 'Ac777apa.';
        $fp = fopen($privateKey, "r");
        $privateKeyd = fread($fp, filesize($privateKey));
        fclose($fp);
        $pkeyid = openssl_get_privatekey($privateKeyd, $privateKeyPassword);
        openssl_sign($text, $signature, $pkeyid);
        $signature = base64_encode($signature);
        return $signature;
    }
}