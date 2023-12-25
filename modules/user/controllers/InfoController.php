<?php

namespace app\modules\user\controllers;

use app\models\Orders;
use app\models\User;
use app\models\UserAdress;
use Yii;
use yii\bootstrap5\BootstrapAsset;
use yii\web\Controller;

/**
 * Default controller for the `user` module
 */
class InfoController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $request = Yii::$app->request->get();
        $userId = Yii::$app->user->identity->id;
        $user = User::findOne($userId);
        $userAdress = UserAdress::find()->where(['user_id' => $userId])->all();


        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            debug($data);
            // if($data['User']['password'] == $data['User']['rePass']){
            //     $user->password = $data['User']['password'];
            //     if($user->save()){
            //         Yii::$app->session->setFlash('success', "Новый пароль сохранен");
            //         return $this->refresh();
            //     }else{
            //         var_dump($user->getErrors());
            //     }
            // }
        }

        
        $this->getView()->registerCssFile("@web/css/user.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerJsFile("@web/js/user_order.js", [
            'depends' => [\yii\web\YiiAsset::class],
        ]);
        return $this->render('index',[
            'user' => $user,
            'lang' => $request['lang'],
            'userAdress' => $userAdress
        ]);

    }
}