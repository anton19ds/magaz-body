<?php

namespace app\modules\admin\controllers;

use app\assets\AdminAsset;
use app\models\InfoStep;
use app\models\Product;
use app\models\ProductMeta;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `admin` module
 */
class InfoController extends ParentController
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
      $url = "http://body-dev.na4u.ru/api/v1/success";
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
      $model->info_id = $id;
      if ($model->load(Yii::$app->request->post())) {
        if (!$model->save()) {
          return var_dump($model->getErrors());
        }else{
            Yii::$app->session->setFlash('success', "Шаг сохранен");
            return $this->redirect(['update-step', 'id' => $model->id]);
        }
      }
    }
    return $this->render('add-step', [
      'model' => $model,
      'id' => $id
    ]);
  }

  public function actionUpdateStep($id)
  {
    $model = InfoStep::findOne($id);
    if(Yii::$app->request->isPost){
        $data = Yii::$app->request->post();
        if($model->load($data) && $model->save()){
            Yii::$app->session->setFlash('success', "Шаг сохранен");
        }else{
            return var_dump($model->getErrors());
        }
    }
    return $this->render('add-step', [
      'model' => $model,
      'id' => $model->info_id
    ]);
  }


  private function CrosReqyest($id, $url)
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      
      CURLOPT_URL => $url,
      // CURLOPT_URL => 'http://body-dev.na4u.ru/api/v1/content',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => false,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('id' => $id),
      CURLOPT_HTTPHEADER => array(
        'Apikey: yii2-magaz-hash'
      ),
    )
    );
    $response = curl_exec($curl);
    return json_decode($response, true);
  }
}