<?php

namespace app\modules\admin\controllers;

use app\assets\AdminAsset;
use app\models\Product;
use app\models\ProductMeta;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `admin` module
 */
class ProductVariableController extends ParentController
{

  public $arrayData = array(
    'productName'=> 'Наименование',
    'shortName' => 'Короткое Наименование',
    'shortDescription' => 'Короткое Описание',
    'link' => 'Постоянная Ссылка',
    'sort' => 'Позиция',
    'description' => 'Описание',
  );
  // $data['type'] = "made";
  public function actionCreate()
  {
    $this->title = 'Новый товар';
    $model = new Product();
    if(Yii::$app->request->isPost){
      $data = Yii::$app->request->post();
      if($model->load($data)){
        if($model->save()){
          $meta = $this->saveNewMeta($model->id ,$data['productMeta']);
          if($meta){
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

  public function saveNewMeta($product_id, $data){
    if(empty($data['productName'])){
      $data['productName'] = "Товар #".$product_id;
    }
    $data['type'] = "made";
    if(empty($data['link'])){
      $data['link'] = "tovar-".$product_id;
    }
    foreach($data as $key => $value){
      if(is_array($value)){
        $value = json_encode($value);
      }
      $model = new ProductMeta([
        'product_id' => $product_id,
        'meta' => $key,
        'value' => $value
      ]);
      if(!$model->save()){
        return var_dump($model->getErrors());
      }
    }
    return false;
  }
}