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

class BonusController extends Controller
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
        return $this->render('index',[
            'lang' => $request['lang']
        ]);

    }

}