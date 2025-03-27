<?php

namespace app\modules\user\controllers;

use app\models\Orders;
use app\models\OrdersMeta;
use app\models\User;
use app\models\UserAdress;
use app\models\UserRequest;
use Yii;
use yii\bootstrap5\BootstrapAsset;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `user` module
 */

class FeedbackController extends Controller
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
        if(Yii::$app->request->post()){
            $data = Yii::$app->request->post();
            $model = new UserRequest([
                'user_id' => Yii::$app->user->identity->id,
                'text' => $data['Feedback']['feedback_message'],
                'type' => UserRequest::FEEDBACK,
                'subject' => $data['Feedback']['feedback_theme']
            ]);         
            if($model->save()){
                Yii::$app->session->setFlash('success', Yii::t('app', 'message-has-sent'));
                return $this->refresh();
            }else{
                return var_dump($model->getErrors());
            }
        }
        return $this->render('index',[
            'lang' => $request['lang']
        ]);

    }

}


 
 