<?php

namespace app\modules\user\controllers;

use app\models\Currencies;
use app\models\Orders;
use app\models\OrdersMeta;
use app\models\OrderStatus;
use app\models\Product;
use app\models\SettingData;
use app\models\User;
use app\models\UserAdress;
use Yii;
use yii\bootstrap5\BootstrapAsset;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
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
                        'actions' => ['index', 'modal-show', 'order', 'close-order'],
                        'roles' => ['user','administrator'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        if (!Yii::$app->user->isGuest) {
            $user = User::find()->where(['id' => Yii::$app->user->identity->id])->with('orders')->one();
        }
        $userOrders = Orders::find()
            ->where(['user_id' => Yii::$app->user->identity->id])
            ->orderBy(['id' => SORT_DESC])
            ->all();
        $this->getView()->registerCssFile("@web/css/user.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerJsFile("@web/js/user_order.js", [
            'depends' => [\yii\web\YiiAsset::class],
        ]);
        return $this->render('index', [
            'user' => $user,
            'lang' => $request['lang'],
            'userOrders' => $userOrders
        ]);
    }
    public function actionModalShow()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $orders = Orders::find()->where(['uuid' => $data['uuid']])->one();
            return $this->renderAjax('view_order', [
                'orders' => $orders,
                'lang' => $data['lang']
            ]);
        }
    }

    public function actionOrder(){
        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        $order = Orders::find()->where(['id' => $request['order']])->one();
        $orderMeta = OrdersMeta::find()->where(['order_id' => $request['order']])->asArray()->one();
        $adress = UserAdress::find()->where(['id' => $orderMeta['adress_shipig']])->asArray()->one();
        $user = User::find()->where(['id' => $order->user_id])->asArray()->one();
        $orderStatys = OrderStatus::findOne(['order_id' => $order->id]);
        $dataOrder = unserialize($order['data_order']);
        $product = Product::find()->where(['id' => array_keys($dataOrder)])->all();
        $icon = '₽';
        $curensy = Currencies::find()->where(['tag' => $order->cyrrency])->asArray()->one();
        //debug($curensy);
        if($order->cyrrency != 'ru'){
            $icon = $curensy['icon'];
        }
        
        $dell = null;
        if($orderMeta['shiping_summ']){
            $dell = $orderMeta['shiping_summ'];
        }else{
            $serty = SettingData::find()->where(['meta' => $orderMeta['shiping_type']])->one();
            $dell = $serty->value;
        }
        return $this->render('view_order', [
            'orderStatys' => $orderStatys,
            'lang' => $order->cyrrency,
            'order' => $order,
            'adress' => $adress,
            'orderMeta' => $orderMeta,
            'user' => $user,
            'dataOrder' => $dataOrder,
            'product' => $product,
            'icon' => $icon,
            'dell' => $dell
        ]);
        
    }

    public function actionCloseOrder(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            if(Orders::find()->where(['id' => $data['id']])->exists() && OrderStatus::find()->where(['order_id' => $data['id']])->exists()){
                $model = OrderStatus::find()->where(['order_id' => $data['id']])->one();
                $model->status = OrderStatus::STATUS_FAILED;
                if($model->save()){
                    return true;
                }
                return false;
            }
        }
    }
}