<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\User;
use Yii;
use yii\web\Controller;


class AjaxController extends Controller
{
    public function actionRegistration()
    {
        $model = new User();
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            $data['User']['password'] = $data['User']['rePass'] = Yii::$app->getSecurity()->generateRandomString(10);
            $data['User']['email'] = $data['User']['username'] = $data['email'];
            $data['User']['rememberMe'] = true;
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