<?php

namespace app\modules\admin\controllers;

use app\assets\AdminAsset;
use app\models\CategoryInfoproduct;
use app\models\Currencies;
use app\models\InfoStep;
use app\models\InfoStepLang;
use app\models\Product;
use app\models\ProductMeta;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\Controller;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `admin` module
 */
class InfoController extends MainController
{
  public $arrayData = array(
    'productName' => 'Наименование',
    'shortName' => 'Короткое Наименование',
    'shortDescription' => 'Короткое Описание',
    'link' => 'Постоянная Ссылка',
    'sort' => 'Позиция',
    'description' => 'Описание',
  );
  public function actionCreate()
  {
    // info courses
    $model = new Product();

    if (Yii::$app->request->isPost) {
      $data = Yii::$app->request->post();
      if ($model->load($data)) {
        if ($model->save()) {
          $meta = $this->saveNewMeta($model->id, $data['productMeta']);
          if ($meta) {
            return $meta;
          }
        }
      }
      return $this->refresh();
    }

    $this->view->registerJsFile('/adminStyle/product.js', ['depends' => AdminAsset::className()]);
    return $this->render('create', [
      'model' => $model,
      'arrayData' => $this->arrayData
    ]);
  }

  public function saveNewMeta($product_id, $data)
  {
    if (empty($data['productName'])) {
      $data['productName'] = "Товар #" . $product_id;
    }
    $data['type'] = "info";
    if (empty($data['link'])) {
      $data['link'] = "tovar-" . $product_id;
    }
    foreach ($data as $key => $value) {
      $model = new ProductMeta([
        'product_id' => $product_id,
        'meta' => $key,
        'value' => $value
      ]);
      if (!$model->save()) {
        return var_dump($model->getErrors());
      }
    }
    return false;
  }
  public function actionArticlesSuccess()
  {
    if (Yii::$app->request->isAjax) {
      $data = Yii::$app->request->post();
      $url = "https://anticandida.com/api/success";
      $result = $this->CrosReqyest($data["id"], $url);
      return $result;
    }
  }

  public function actionIndex($sort = null)
  {
    $this->title = 'Список товаров';
    $this->preTitle = 'товары магазина';
    $this->actionType = '/admin/product/create';
    if (Yii::$app->request->isPost) {
      debug(Yii::$app->request->post());
    }
    $model = Product::find()->
      leftJoin("product_meta", "product_meta.product_id=product.id")->
      where(["product_meta.meta" => "type"])->
      andWhere(["product_meta.value" => "info"]);

    $dataProvider = new ActiveDataProvider([
      'query' => $model,
      'pagination' => [
        'pageSize' => 50,
        'pageSizeParam' => false,
        'forcePageParam' => false
      ],
    ]);
    $this->view->registerJsFile('/adminStyle/product.js', ['depends' => AdminAsset::className()]);
    return $this->render('index', [
      'dataProvider' => $dataProvider,
      'title' => $this->title,
      'preTitle' => $this->preTitle,
      'actionType' => $this->actionType
    ]);
  }

  public function actionUpdateDetail($id)
  {
    $model = InfoStep::find()->where(['info_id' => $id]);
    $dataProvider = new ActiveDataProvider([
      'query' => $model,
      'pagination' => [
        'pageSize' => 50,
        'pageSizeParam' => false,
        'forcePageParam' => false
      ],
    ]);
    return $this->render("update-detail", [
      'model' => $model,
      'dataProvider' => $dataProvider,
      'id' => $id
    ]);
  }

  public function actionAddStep($id)
  {
    $model = new InfoStep();
    if (Yii::$app->request->post()) {
      $category = CategoryInfoproduct::findOne($id);
      $model->info_id = $category->infoproduct_id;
      $model->category_id = $id;
      if ($model->load(Yii::$app->request->post())) {
        if (!$model->save()) {
          return var_dump($model->getErrors());
        } else {
          Yii::$app->session->setFlash('success', "Шаг сохранен");
          return $this->redirect(['update-step', 'id' => $model->id, 'category_id' => $id]);
        }
      }
    }
    return $this->render('add-step', [
      'model' => $model,
      'id' => $id
    ]);
  }

  public function actionUpdateStep($id, $category_id = null)
  {

    $request = Yii::$app->request->get();
    $currensy = Currencies::find()->all();
    $navLangStr = '<ul><li><a href="/admin/info/update-step?id=' . $id . '">RU</a></li>';
    foreach ($currensy as $item) {
      $navLangStr .= '<li><a href="/admin/info/update-step?id=' . $id . '&lang=' . $item->tag . '">' . $item->tag . '</a></li>';
    }
    $navLangStr .= "</ul>";
    //$this->lang = $navLangStr;

    if (isset($request['lang']) && $request['lang'] != 'ru') {
      $parent = InfoStep::findOne($id);
      if (InfoStepLang::find()->where(['tag' => $request['lang']])->andWhere(['info_id' => $id])->exists()) {
        $model = InfoStepLang::find()->where(['tag' => $request['lang']])->andWhere(['info_id' => $id])->one();
      } else {
        $model = new InfoStepLang();
      }
    } else {
      $model = InfoStep::findOne($id);
    }

    if (Yii::$app->request->isPost) {
      $data = Yii::$app->request->post();
      if ($model->load($data) && $model->save()) {
        Yii::$app->session->setFlash('success', "Шаг сохранен");
        return $this->refresh();
      } else {
        return var_dump($model->getErrors());
      }
    }
    if (isset($request['lang']) && $request['lang'] != 'ru') {
      return $this->render('add-step-lang', [
        'model' => $model,
        'id' => $model->info_id,
        'parent' => $parent,
        'lang' => $request['lang'],
        'category_id' => $category_id
      ]);
    } else {
      return $this->render('add-step', [
        'model' => $model,
        'id' => $model->info_id,
        'category_id' => $category_id
      ]);
    }
  }

  public function actionCategory($id, $tag = null)
  {


    $sort = new Sort([
      'attributes' => [
        'sort' => [
          'asc' => ['sort' => SORT_ASC],
          'desc' => ['sort' => SORT_DESC],
          'default' => SORT_ASC,
          'label' => 'Позиция',
        ],
        // or any other attribute
      ],
      'defaultOrder' => [
        'sort' => SORT_ASC
      ]
    ]);

    if (!empty($tag) && $tag != 'ru') {
      $model = CategoryInfoproduct::find()->where(['tag' => $tag])->andWhere(['infoproduct_id' => $id]);
    } else {
      $tag = 'ru';
      $model = CategoryInfoproduct::find()->where(['tag' => 'ru'])->andWhere(['infoproduct_id' => $id]);
    }

    $currensy = Currencies::find()->all();
    $navLangStr = '<ul><li><a href="/admin/info/category?id=' . $id . '">RU</a></li>';
    foreach ($currensy as $item) {
      $navLangStr .= '<li><a href="/admin/info/category?id=' . $id . '&tag=' . $item->tag . '">' . $item->tag . '</a></li>';
    }
    $navLangStr .= "</ul>";

    $this->lang = $navLangStr;
    $this->actionType = '/admin/info/create-category?id=' . $id . '&tag=' . $tag;
    $this->title = 'Категории Инфопродукта';
    $dataProvider = new ActiveDataProvider([
      'query' => $model,
      'pagination' => [
        'pageSize' => 50,
        'pageSizeParam' => false,
        'forcePageParam' => false
      ],
      'sort' => $sort
    ]);
    return $this->render('category', [
      'model' => $model,
      'tag' => $tag,
      'dataProvider' => $dataProvider,
      'id' => $id
    ]);
  }

  public function actionCategoryDelete($id)
  {
    if (InfoStep::find()->where(['category_id' => $id])->exists()) {
      InfoStep::deleteAll(['category_id' => $id]);
    }
    if (InfoStepLang::find()->where(['category_id' => $id])->exists()) {
      InfoStepLang::deleteAll(['category_id' => $id]);
    }
    if (CategoryInfoproduct::find()->where(['id' => $id])->exists()) {
      $customer = CategoryInfoproduct::findOne($id);
      $customer->delete();
    }
    return $this->redirect(['index']);
  }

  public function actionCreateCategory($id, $tag)
  {
    $this->title = 'Категория Инфопродукта';

    $model = new CategoryInfoproduct();
    if (Yii::$app->request->isPost) {
      $data = Yii::$app->request->post();
      if ($model->load($data) && $model->save()) {
        return $this->redirect(['category', 'id' => $id, 'tag' => $tag]);
      } else {
        debug($model->getErrors());
      }
    }
    return $this->render('create-category', [
      'model' => $model,
      'tag' => $tag,
      'id' => $id
    ]);
  }

  public function actionCategoryUpdate($id)
  {
    $this->title = 'Категория Инфопродукта';
    $model = CategoryInfoproduct::findOne($id);
    if (Yii::$app->request->isPost) {
      $data = Yii::$app->request->post();
      if ($model->load($data) && $model->save()) {
        return $this->refresh();
      } else {
        debug($model->getErrors());
      }
    }
    return $this->render('update-category', [
      'model' => $model,
    ]);
  }

  public function actionCategoryLesons($id, $tag)
  {
    $sort = new Sort([
      'attributes' => [
        'sort' => [
          'asc' => ['sort' => SORT_ASC],
          'desc' => ['sort' => SORT_DESC],
          'default' => SORT_ASC,
          'label' => 'Позиция',
        ],
        // or any other attribute
      ],
      'defaultOrder' => [
        'sort' => SORT_ASC
      ]
    ]);

    $category = CategoryInfoproduct::find()->where(['id' => $id])->one();


    $model = InfoStep::find()->where(['category_id' => $id]);
    $dataProvider = new ActiveDataProvider([
      'query' => $model,
      'pagination' => [
        'pageSize' => 50,
        'pageSizeParam' => false,
        'forcePageParam' => false
      ],
      'sort' => $sort
    ]);
    return $this->render('category-lesons', [
      'category' => $category,
      'dataProvider' => $dataProvider,
      'id' => $id,
      'tag' => $tag
    ]);
  }


  private function CrosReqyest($id, $url, $lang = null)
  {
    $curl = curl_init();
    curl_setopt_array(
      $curl,
      array(

        CURLOPT_URL => $url,
        // CURLOPT_URL => 'http://body-dev.na4u.ru/api/v1/content',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('post_id' => $id),
        CURLOPT_HTTPHEADER => array(
          'Apikey: yii2-magaz-hash'
        ),
      )
    );
    $response = curl_exec($curl);
    return json_decode($response, true);
  }

  public function actionDeleteStep()
  {
    if (Yii::$app->request->isAjax) {
      $data = Yii::$app->request->post();
      if (InfoStep::find()->where(['id' => $data['id']])->exists()) {
        $model = InfoStep::findOne($data['id']);
        if ($model->delete()) {
          return true;
        }
      }
      return false;
    }
  }

  public function actionUpdateSortStep()
  {
    if (Yii::$app->request->isAjax) {
      $data = Yii::$app->request->post();
      if (InfoStep::find()->where(['id' => $data['id']])->exists()) {
        $model = InfoStep::findOne($data['id']);
        $model->sort = $data['val'];
        if ($model->save()) {
          return true;
        }
        return false;
      }
    }
  }

  public function actionUpdateSortCategory()
  {
    if (Yii::$app->request->isAjax) {
      $data = Yii::$app->request->post();
      if (CategoryInfoproduct::find()->where(['id' => $data['id']])->exists()) {
        $model = CategoryInfoproduct::findOne($data['id']);
        $model->sort = $data['val'];
        if ($model->save()) {
          return true;
        }
        return false;
      }
    }
  }

  public function actionTimeUpdateStep()
  {
    if (Yii::$app->request->isAjax) {
      $data = Yii::$app->request->post();
      if (InfoStep::find()->where(['id' => $data['id']])->exists()) {
        $model = InfoStep::findOne($data['id']);
        $model->time = $data['val'];
        if ($model->save()) {
          return true;
        }
        return false;
      }
    }
  }

  public function actionHourseUpdateStep()
  {
    if (Yii::$app->request->isAjax) {
      $data = Yii::$app->request->post();
      if (InfoStep::find()->where(['id' => $data['id']])->exists()) {
        $model = InfoStep::findOne($data['id']);
        $model->hourse = $data['val'];
        if ($model->save()) {
          return true;
        }
        return false;
      }
    }
  }

  public function actionLangUpdateStep(){
    if (Yii::$app->request->isAjax) {
      $data = Yii::$app->request->post();
      if (InfoStep::find()->where(['id' => $data['id']])->exists()) {
        $model = InfoStep::findOne($data['id']);
        $model->lang = $data['val'];
        if ($model->save()) {
          return true;
        }
        return false;
      }
    }
  }


  

}