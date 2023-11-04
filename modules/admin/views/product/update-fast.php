<?php

use app\models\Category;
use app\models\Product;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$raite = array(
  1 => 1,
  2 => 2,
  3 => 3,
  4 => 4,
  5 => 5,
);
?>
<tr class="fast-update">
  <td colspan="9">
    <?php $form = ActiveForm::begin(['options' => [
      'id' => 'form-update-prod',
      // 'id' => 'form-'.$model->id,
      'enctype' => 'multipart/form-data',
      'action' => ["validete-product"],
      'enableAjaxValidation' => true,
      'validationUrl' => "/admin/product/validete-product",
      ]]); ?>
      <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    <div class="row g-0 mb-3">
      <div class="col-2 g-0">
        <div class="form-group field-product-productName">
          <label class="control-label" for="product-productName">
            Наименование
          </label>
          <?= Html::textInput('productMeta[productName]', $model->getParam('productName'), ['class' => 'form-control', 'id' => 'productMetaproductName']); ?>
        </div>
      </div>
      <div class="col-1 g-0">
        <?= $form->field($model, 'price')->textInput()->label() ?>
      </div>
      <div class="col-1 g-0">
        <?= $form->field($model, 'sale')->textInput() ?>
      </div>
      <div class="col-1 g-0">
        <div class="raite_block">
        <?= $form->field($model, 'raite')->radioList($raite, ['unselect' => 5, 'class' => 'selectgroup w-100']); ?>
        </div>
      </div>
      <div class="col-1 g-0">
        <?= $form->field($model, 'active')->dropDownList(Product::getLabelStatus()) ?>
      </div>
      <div class="col-1 g-0">
        <?= $form->field($model, 'upsale')->dropDownList(Product::getUpsaleStatus()) ?>
      </div>
      <div class="col-1 g-0">
      <!-- dropDownList() -->
      <div class="form-group field-product-category">
        <label> Категория</label>
      <?php $category = ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'title');
      $category['0'] = 'Без категории';
      ksort($category);
      ?>
        <?= Html::dropDownList('productMeta[category]', $model->getParam('category'), $category, ['class' => 'form-control'])?>
        </div>
      </div>
      <div class="col-md-12"></div>
      <div class="col-3 mt-5">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info sendForm', 'data-pjax' => 0]) ?>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
  </td>
</tr>
