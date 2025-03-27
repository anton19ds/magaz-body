<?php

namespace app\modules\admin\controllers;

use app\models\Currencies;
use app\models\Tasks;
use app\models\TasksLang;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use Yii;
use yii\helpers\Html;

class TasksController extends MainController
{
    /**
     * @inheritDoc
     */

    public $title = 'Задания';
    public $preTitle;
    public $actionType;
    public $lang;

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => Tasks::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'provider' => $provider
        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $model = new Tasks();
            if ($model->load($data) && $model->save()) {
                return $this->redirect('index');
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title' => "Добавить задание",
                    'content' => $this->renderAjax('create', [
                        'model' => new Tasks(),
                        'data' => $data
                    ]),
                    'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal", "data-bs-dismiss" => "modal"]) .
                        Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }

        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Добавить задание",
                'content' => $this->renderAjax('create', [
                    'model' => new Tasks()
                ]),
                'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal", "data-bs-dismiss" => "modal"]) .
                    Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    }

    public function actionUpdate($id = null)
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $model = Tasks::findOne($id);
            if ($model->load($data) && $model->save()) {
                return $this->redirect('/admin/tasks/index');
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Изменить задание",
                'content' => $this->renderAjax('update', [
                    'model' => Tasks::findOne($id),
                    'data' => $data
                ]),
                'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal", "data-bs-dismiss" => "modal"]) .
                    Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = Tasks::findOne($id);
            return [
                'title' => "Изменить задание",
                'content' => $this->renderAjax('update', [
                    'model' => $model,
                    'id' => $id
                ]),
                'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal", "data-bs-dismiss" => "modal"]) .
                    Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    }

    public function actionUpdateTask($id, $lang = null)
    {
        $this->title = '';

        $currensy = Currencies::find()->all();
        $navLangStr = '<ul><li><a href="/admin/tasks/update-task?id=' . $id . '&lang=ru">RU</a></li>';
        foreach ($currensy as $item) {
            $navLangStr .= '<li><a href="/admin/tasks/update-task?id=' . $id . '&lang=' . $item->tag . '">' . $item->tag . '</a></li>';
        }
        $navLangStr .= "</ul>";
        $this->lang = $navLangStr;
        if (!$lang || $lang == 'ru') {
            $model = Tasks::findOne($id);
        } else {
            if (TasksLang::find()->where(['parent_id' => $id])->andWhere(['tag'=>$lang])->exists()) {
                $model = TasksLang::find()->where(['parent_id' => $id])->andWhere(['tag'=>$lang])->one();
            } else {
                $model = new TasksLang([
                    'tag' => $lang,
                    'parent_id' => $id
                ]);
            }
        }
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if($model->load($data) && $model->save()){
                return $this->refresh();
            }
        }
        return $this->render('update-task', [
            'model' => $model
        ]);
    }

    public function actionDeleteTasks($id)
    {
        $model = Tasks::findOne($id);
        if ($model->delete()) {
            return $this->redirect('index');
        }
    }
}