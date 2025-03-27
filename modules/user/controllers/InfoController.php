<?php

namespace app\modules\user\controllers;

use app\models\Orders;
use app\models\User;
use app\models\UserAdress;
use app\models\UserCosial;
use Yii;
use yii\bootstrap5\BootstrapAsset;
use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * Default controller for the `user` module
 */
class InfoController extends Controller
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
                        'actions' => ['index', 'remove-user-adress', 'check-password'],
                        'roles' => ['user','administrator'],
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
        $userId = Yii::$app->user->identity->id;
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        $user = User::findOne($userId);
        $userAdress = UserAdress::find()->where(['user_id' => $userId])->all();

        $userSocial = UserCosial::find()->where(['user_id' => $userId])->one();
        if(empty($userSocial)){
            $userSocial = new UserCosial();
        }

        if (Yii::$app->request->isPost) {
            $userSave = false;
            $passSave = false;
            $data = Yii::$app->request->post();
            //debug($data);
            if (isset($data['User']['email']) && !empty($data['User']['email'])) {
                if(User::find()->where(['email' => $data['User']['email']])->exists()){
                    Yii::$app->session->setFlash('success', "Е-Mail ".$data['User']['email']." ".Yii::t('app', 'email-error-set'));
                    return $this->refresh();
                }else{
                    $user->email = $data['User']['email'];
                    $userSave = true;    
                }
                
            }
            if (isset($data['User']['username']) && !empty($data['User']['username'])) {
                $user->username = $data['User']['username'];
                $userSave = true;
            }
            if (isset($data['User']['phone']) && !empty($data['User']['phone'])) {
                $user->phone = $data['User']['phone'];
                $userSave = true;
            }
            if (isset($data['resetPass']['old-pass']) && $data['resetPass']['new-pass'] == $data['resetPass']['rep-pass']) {
                $user->password = $data['resetPass']['new-pass'];
                $userSave = true;
                $passSave = true;
            }

            if (isset($data['update'])) {
                $userAdress = UserAdress::findOne($data['update']['update_id']);
                $userAdress->country = $data['update']['country'];
                $userAdress->postcode = $data['update']['postcode'];
                $userAdress->area = $data['update']['area'];
                $userAdress->city = $data['update']['city'];
                $userAdress->street = $data['update']['street'];
                $userAdress->flat = $data['update']['flat'];
                $userAdress->name = $data['update']['name'];
                $userAdress->surname = $data['update']['surname'];
                $userAdress->lastname = $data['update']['fname'];
                
                
                if ($userAdress->save()) {
                    return $this->refresh();
                }
            }
            if (isset($data['new'])) {
                $userAdress = new UserAdress([
                    'country' => $data['new']['country'],
                    'postcode' => $data['new']['postcode'],
                    'area' => $data['new']['area'],
                    'city' => $data['new']['city'],
                    'street' => $data['new']['street'],
                    'flat' => $data['new']['flat'],
                    'user_id' => $userId,
                    'name'=>$data['new']['name'],
                    'surname'=>$data['new']['surname'],
                    'lastname'=>$data['new']['fname']
                ]);
                if (!$userAdress->save()) {
                    var_dump($userAdress->getErrors());
                } else {
                    return $this->refresh();
                }
            }

            if(isset($data['social'])){

                $userSocial->user_id = $userId;
                $userSocial->inst = $data['social']['inst'];
                $userSocial->vk = $data['social']['vk'];
                $userSocial->fb = $data['social']['fb'];
                $userSocial->wa = $data['social']['wa'];
                $userSocial->tg = $data['social']['tg'];
                if($userSocial->save()){
                    return $this->refresh();
                }
            }

            if ($userSave) {
                if ($user->save()) {
                    if($passSave){
                        Yii::$app->session->setFlash('success', Yii::t('app', 'password-update-set'));
                    }
                    return $this->refresh();
                } else {
                    var_dump($user->getErrors());
                }
            }
        }


        $this->getView()->registerCssFile("@web/css/user.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerJsFile("@web/js/user_order.js", [
            'depends' => [\yii\web\YiiAsset::class],
        ]);
        return $this->render('index', [
            'user' => $user,
            'lang' => $request['lang'],
            'userAdress' => $userAdress,
            'userSocial' => $userSocial
        ]);

    }

    public function actionRemoveUserAdress()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $model = UserAdress::findOne($data['id']);
            if ($model->delete()) {
                return true;
            }

        }
    }

    public function actionCheckPassword(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $model = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
            if($model->password != $data['pass']){
                return false;
            }else{
                return true;
            }
        }
    }
}