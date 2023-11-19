<?php

namespace app\controllers;

use app\models\AuthAssignment;
use Yii;
use yii\bootstrap5\BootstrapAsset;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\User;

class LoginController extends MainController
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            // 'verbs' => [
            //     'class' => VerbFilter::class,
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionIndex()
    {

        $request = Yii::$app->request->get();
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();

        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            
            if (isset($data['LoginForm']) && !empty($data['LoginForm'])) {
                if ($model->load($data) && $model->login()) {
                    return $this->redirect('/' . $request['lang'] . '/user');
                }
            }
            if(isset($data['Register']) && !empty($data['Register'])){
                $register = $this->RegistrationAndLogin($data['Register']['register']);
                if($register){
                    return $this->redirect('/' . $request['lang'] . '/user');
                }
            }
        }

        $model->password = '';
        $this->getView()->registerCssFile("@web/css/ser.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerCssFile("@web/asset/media.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    private function RegistrationAndLogin($username){
        // if()
        $password = Yii::$app->getSecurity()->generateRandomString(10);
        $user = new User([
            'username' => $username,
            'password' => $password,
            'email' => $username,
            'rePass' => $password
        ]);
        if($user->save()){
            $AuthAssignment = new AuthAssignment([
                'item_name' => 'user',
                'user_id' => strval($user->id),
            ]);
            if($AuthAssignment->save()){
                $login = new LoginForm([
                    'username' => $user->username,
                    'password' => $user->password,
                    'rememberMe' => true
                ]);
                if ($login->login()) {
                    return true;
                } else {
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
        
            
               
    }

    public function actionRegistration()
    {
        $model = new User();
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            $data['User']['password'] = $data['User']['rePass'] = Yii::$app->getSecurity()->generateRandomString(10);
            if ($model->load($data) && $model->validate()) {
                if ($data['User']['password'] === $data['User']['rePass']) {
                    if (!$model->save()) {
                        return var_dump($model->getErrors());
                    } else {
                        $login = new LoginForm([
                            'username' => $model->username,
                            'password' => $model->password,
                            'rememberMe' => $data['User']['rememberMe']
                        ]);
                        if ($login->login()) {
                            return var_dump('login');
                        } else {
                            return var_dump('no login');
                        }
                    }
                } else {
                    return var_dump('no-pass');
                }

            } else {
                return var_dump($model->getErrors());
            }
            //return $this->refresh();
        }
        return 'ok';
        // return $this->render('registration', [
        //     'model' => $model
        // ]);
    }
}