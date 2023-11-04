<?php

use app\models\Product;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="row" id="tableProductList">
  <div class="col-md-12">
    <div class="card full-height">
      <div class="card-body">
        <? $form = ActiveForm::begin(); ?>

        <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'columns' => [
            [
              'attribute' => '',
              'format' => 'raw',
              'value' => function ($model) {
                        $obj = '<input type="checkbox" value="' . $model->id . '" name="action[' . $model->id . ']">';
                        return $obj;
                      }
            ],
            [
              'attribute' => 'image',
              'contentOptions' =>['class' => 'table_class-image','style' => 'width:60px'],
              'format' => 'raw',
              'value' => function ($model) {
                        return $model->getProductFoto();
                      }
            ],
            [
              'attribute' => 'name',
              'format' => 'raw',
              'value' => function ($model) {
                        $titleRes = '<div class="product_data">'.
                        '<span>' . $model->getParam('productName') . '</span>'.
                        '<ul>'.
                        '<li><a href="/admin/info/update-detail?id='.$model->id.'">id: ' . $model->id . '</a></li>'.
                        '<li><a>Быстрое редактирование</a></li>'.
                        '<li><a>История</a></li>'.
                        '</ul></div>';
                        return $titleRes;
                      }
            ],

            'date:date',
            'updated_at:date',
            [
              'attribute' => 'active',
              'format' => 'raw',
              'value' => function($model){
                return Product::getLabelStatus()[$model->active];
              }
            ],
          ],
        ]); ?>
        <?php //= Html::submitButton('qwe') ?>
        <? ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>