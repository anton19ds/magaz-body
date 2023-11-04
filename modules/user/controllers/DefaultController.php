<?php

namespace app\modules\user\controllers;

use app\models\Orders;
use app\models\User;
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
                        'actions' => ['index', 'modal-show'],
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
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
}