<?php

namespace app\modules\user\controllers;

use app\models\Orders;
use app\models\OrdersMeta;
use app\models\User;
use app\models\UserAdress;
use Yii;
use yii\bootstrap5\BootstrapAsset;
use yii\filters\AccessControl;
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
                        'actions' => ['index', 'modal-show', 'order'],
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request->get();
        if (!Yii::$app->user->isGuest) {
            $user = User::findOne(Yii::$app->user->identity->id);
        }
        $this->getView()->registerCssFile("@web/css/user.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerJsFile("@web/js/user_order.js", [
            'depends' => [\yii\web\YiiAsset::class],
        ]);
        return $this->render('index', [
            'user' => $user,
            'lang' => $request['lang']
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
        
        $order = Orders::find()->where(['id' => $request['order']])->asArray()->one();
        $orderMeta = OrdersMeta::find()->where(['order_id' => $request['order']])->asArray()->one();
        $adress = UserAdress::find()->where(['id' => $orderMeta['adress_shipig']])->asArray()->one();
        $user = User::find()->where(['id' => $order['user_id']])->asArray()->one();
        return $this->render('view_order', [
            'lang' => $request['lang'],
            'order' => $order,
            'adress' => $adress,
            'orderMeta' => $orderMeta,
            'user' => $user
        ]);
        
    }
}