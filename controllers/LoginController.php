<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\MailMessage;
use app\models\Orders;
use app\models\OrdersMeta;
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
use yii\helpers\ArrayHelper;

class LoginController extends Controller
{
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionIndex()
    {
        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            if (isset($data['Register']) && !empty($data['Register'])) {
                $register = $this->RegistrationAndLogin($data['Register']['register'], $request['lang']);
                if ($register) {
                    if(isset($request['page']) && !empty($request['page']) && $request['page'] == 'order'){
                        //echo '123';
                        return $this->redirect('/' . $request['lang'] . '/order');
                    }elseif(isset($request['page']) && !empty($request['page']) && $request['page'] != 'order'){
                        //echo '222';
                        return $this->redirect('/' . $request['page']);
                    }else{
                        return $this->redirect('/' . $request['lang'] . '/user?newuser=true');
                    }
                    
                }
            }
            return $this->refresh();
        }

        $model->password = '';
        $this->getView()->registerCssFile("@web/css/ser.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerCssFile("@web/asset/css/media.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerCssFile("@web/asset/css/fonts.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerCssFile("@web/css/main-page.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        return $this->render('login', [
            'model' => $model,
            'lang' => $request['lang'],
            'request' => $request
        ]);
    }


    public function actionLogout()
    {
        if(Yii::$app->request->isAjax){
            if(!Yii::$app->user->isGuest){
                Yii::$app->user->logout();
                return true;
            }
        }
        return false;
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

    public function actionRegisterValidate()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (User::find()->where(['username' => $data['email']])->orWhere(['email' => $data['email']])->exists()) {
                return '1';
            }
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return '2';
            }
            return '3';
        }
    }

    public function actionRecoverPass()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $email = $data['email'];
            $lang = $data['lang'];
            if(User::find()->where(['email' => $email])->exists()){
                $newPassword = Yii::$app->getSecurity()->generateRandomString(10);
                $user = User::find()->where(['email'=> $email])->one();
                $user->password = $newPassword;
                if($user->save()){
                    $message = MailMessage::SendRecoverPass($lang,$email,$newPassword);
                }
            }
            return $message;
        }
    } 

    public function actionValidate()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $data = ArrayHelper::map($data['form'], 'name', 'value');

            $model = new LoginForm();
            if (!empty($data['username'] && !empty($data['password']))) {
                $model->username = $data['username'];
                $model->password = $data['password'];
                if ($model->login()) {
                    return true;
                }
            }
            return false;
        }
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

    private function RegistrationAndLogin($username, $lang)
    {
        // if()
        $password = Yii::$app->getSecurity()->generateRandomString(10);
        $user = new User([
            'username' => $username,
            'password' => $password,
            'email' => $username,
            'rePass' => $password,
            'lang' => $lang
        ]);
        if ($user->save()) {
            $login = new LoginForm([
                'username' => $user->username,
                'password' => $user->password,
                'rememberMe' => true
            ]);
            if ($login->login()) {
                $email = $username;
                $message = MailMessage::SendRegistration($lang, $email, $password);
                return true;
            } else {
                return false;
            }
        } else {
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