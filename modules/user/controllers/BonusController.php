<?php

namespace app\modules\user\controllers;

use app\models\MailMessage;
use app\models\Tasks;
use app\models\TasksLang;
use app\models\User;
use app\models\UserTasks;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                        'actions' => ['index', 'modal-show', 'order', 'form-bonus'],
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
        if($request['lang'] == 'ru'){
            $model = Tasks::find()->all();    
        }else{
            $model = TasksLang::find()->where(['tag' => $request['lang']])->all();
        }
        $activeUserTasks = UserTasks::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['status' => 1])->all();
        $viewUserTasks = UserTasks::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['status' => 0])->all();
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            debug($data);
        }
        $columnData = ArrayHelper::getColumn($activeUserTasks, 'tasks_id');
        $columnView = ArrayHelper::getColumn($viewUserTasks, 'tasks_id');
        if (!empty($model)) {
            return $this->render('view', [
                'activeUserTasks' => $activeUserTasks,
                'user' => $this->findModel(),
                'model' => $model,
                'lang' => $request['lang'],
                'columnData' => $columnData,
                'columnView' => $columnView
            ]);
        } else {
            return $this->render('index', [
                'activeUserTasks' => $activeUserTasks,
                'user' => $this->findModel(),
                'columnData' => $columnData,
                'lang' => $request['lang']
            ]);
        }
    }


    public function actionFormBonus()
    {
        if (Yii::$app->request->isAjax) {
            $allow = array();
            $deny = array(
                'phtml',
                'php',
                'php3',
                'php4',
                'php5',
                'php6',
                'php7',
                'phps',
                'cgi',
                'pl',
                'asp',
                'aspx',
                'shtml',
                'shtm',
                'htaccess',
                'htpasswd',
                'ini',
                'log',
                'sh',
                'js',
                'html',
                'htm',
                'css',
                'sql',
                'spl',
                'scgi',
                'fcgi',
                'exe'
            );

            $path = Yii::getAlias('@webroot/uploads/');
            $data = array();

            foreach ($_FILES as $file) {
                $statys = '';
                if (empty($file['tmp_name'])) {
                    $statys = false;
                } elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
                    $statys = false;
                } else {
                    $pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
                    $name = mb_eregi_replace($pattern, '-', $file['name']);
                    $name = mb_ereg_replace('[-]+', '-', $name);
                    $parts = pathinfo($name);
                    if (empty($name) || empty($parts['extension'])) {
                        $statys = false;
                    } elseif (!empty($allow) && !in_array(strtolower($parts['extension']), $allow)) {
                        $statys = false;
                    } elseif (!empty($deny) && in_array(strtolower($parts['extension']), $deny)) {
                        $statys = false;
                    } else {
                        $nameFile = time() . '-' . $name;
                        if (move_uploaded_file($file['tmp_name'], $path . $nameFile)) {
                            $statys = true;
                        } else {
                            $statys = false;
                        }
                    }
                }
                if ($statys) {
                    $data[] = $nameFile;
                }
            }
            $post = Yii::$app->request->post();
            $userTask = new UserTasks([
                'user_id' => Yii::$app->user->identity->id,
                'tasks_id' => $post['type_exercise'],
                'file' => serialize($data),
                'text' => $post['comment_exercise'],
                'lang' => $post['lang']
            ]);
            if (!$userTask->save()) {
                var_dump($userTask->getErrors());
            }else{
                MailMessage::NewMessage($post['lang'], 9, Yii::$app->user->identity->username, ['name' => Yii::$app->user->identity->username]);
            }
            Yii::$app->session->setFlash('success', "Задание отправлено на проверку");
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'message' => 'ok'
            ];

        }
    }

    protected function findModel()
    {
        if (($model = User::findOne(['id' => Yii::$app->user->identity->id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}