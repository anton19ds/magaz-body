<?php
namespace app\controllers;

use app\models\AccessInfoProduct;
use app\models\Cart;
use app\models\Orders;
use app\models\OrdersMeta;
use app\models\OrderStatus;
use Yii;
use app\models\LoginForm;
use app\models\PaymentType;
use app\models\Product;
use app\models\ProductMeta;
use app\models\Promocod;
use app\models\PromoUser;
use app\models\User;
use app\models\UserActivePromo;
use app\models\UserAdress;
use Exception;
use yii\bootstrap5\BootstrapAsset;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\web\Controller;

class InsuranceController extends Controller
{

    public function actionAddInsurance()
    {
        if (Yii::$app->request->isAjax) {
            try {
                $session = Yii::$app->session;
                $cart = $session->get('cart');
                $cart['insurance'] = true;
                $cart = $session->set('cart', $cart);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public function actionDeleteInsurance()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            Yii::$app->language = mb_strtolower($data['lang']) . "-" . mb_strtoupper($data['lang']);
            try {
                $session = Yii::$app->session;
                $cart = $session->get('cart');
                if (isset ($cart['insurance'])) {
                    unset($cart['insurance']);
                }
                $session->set('cart', $cart);

                $response = Yii::$app->response;
                $response->format = \yii\web\Response::FORMAT_JSON;
                $response->data = [
                    'data' => true,
                    'message' => Yii::t('app', 'rem-insure')
                ];
            } catch (Exception $e) {
                $response = Yii::$app->response;
                $response->format = \yii\web\Response::FORMAT_JSON;
                $response->data = [
                    'data' => false,
                    'message' => 'Error'
                ];
            }
        }
    }
}