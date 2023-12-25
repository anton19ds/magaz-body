<?php

namespace app\modules\user\controllers;

use app\models\Orders;
use app\models\OrdersMeta;
use app\models\PromoUser;
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

class AffiliateProgramController extends Controller
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
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $userPromo = PromoUser::find()->where(['user_id' => $user->id])->all();
        $request = Yii::$app->request->get();
        return $this->render('index', [
            'lang' => $request['lang'],
            'user' => $user,
            'userPromo' => $userPromo,
            
        ]);

    }
}