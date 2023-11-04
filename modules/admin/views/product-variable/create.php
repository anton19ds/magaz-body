<?php

use app\models\Product;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
  <div class="col-md-8">
    <div class="card full-height">
      <div class="card-header">
        <div class="card-title">Добавление сборного товара</div>
      </div>
      <div class="card-body">
        <input type="hidden" value="<?= Url::base(true); ?>" id="urlSite">
        <div class="col-md-12">
          <label for="">Постоянная ссылка:</label>
          <div class="linkUrl">
          </div>
        </div>
        <?php foreach ($arrayData as $key => $value): ?>
          <div class="form-group field-product-<?= $key?>">
            <label class="control-label" for="product-<?= $key?>">
              <?= $value ?>
            </label>
            <?= Html::textInput('productMeta[' . $key . ']', '', ['class' => 'form-control', 'id' => 'productMeta'.$key]); ?>
          </div>
        <?php endforeach; ?>
        <?= $form->field($model, 'price')->textInput() ?>
        <?= $form->field($model, 'sale')->textInput() ?>
        <?php
        $raite = array(
          1 => 1,
          2 => 2,
          3 => 3,
          4 => 4,
          5 => 5,
        );
        ?>
        <?= $form->field($model, 'raite')->radioList($raite, ['unselect' => 5, 'class' => 'selectgroup w-100']); ?>

        <?= $form->field($model, 'active')->dropDownList(Product::getLabelStatus()) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card full-height">
      <div class="card-body">
        <div class="col-md-12">
          <input type="hidden" name="productMeta[image]" id="imageListInput">
          <span class="open-image btn btn-success">Добавить изображение</span>
        </div>
        <div class="col-md-12 mt-3">
          <div class="img-prew">
          </div>
        </div>
        <div class="col-md-12 mt-3">

          <?php
          echo '<label class="control-label">Provinces</label>';
          echo Select2::widget([
              'name' => 'productMeta[product]',
              'data' => $model->getProductSimpleList(),
              'options' => [
                  'placeholder' => 'Select provinces ...',
                  'multiple' => true
              ],
          ]);
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>


<?php 
$this->registerJs('
        $("#productMetaproductName").change(function(e){
          var val = $(this).val();
          var urlLink = rus_to_latin(val);
          var link = "<a href=\""+urlLink+"\">"+urlLink+"</a>";
          $(".linkUrl").html(link);
          $("#productMetalink").val(urlLink);
        });
');

?>