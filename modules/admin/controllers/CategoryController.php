<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\CategoryLang;
use app\models\Currencies;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends MainController
{
    /**
     * @inheritDoc
     */

     public $title = "Категории";
     public $preTitle;
     public $actionType = "/admin/category/create";

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

    /**
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $request = Yii::$app->request->get();
        $currensy = Currencies::find()->all();
        $navLangStr = '<ul><li><a href="/admin/category/update?id=' . $id . '">RU</a></li>';
        foreach ($currensy as $item) {
            $navLangStr .= '<li><a href="/admin/category/update?id=' . $id . '&lang=' . $item->tag . '">' . $item->tag . '</a></li>';
        }
        $navLangStr .= "</ul>";
        $this->lang = $navLangStr;
        if(isset($request['lang'])){
            if(CategoryLang::find()->where(['category_id' => $id])->andWhere(['lang' => $request['lang']])->exists()){
                $model = CategoryLang::find()->where(['category_id' => $id])->andWhere(['lang' => $request['lang']])->one();
            }else{
                $model = new CategoryLang([
                    'category_id' => $id,
                    'lang' => $request['lang']
                ]);
            }
        }
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
