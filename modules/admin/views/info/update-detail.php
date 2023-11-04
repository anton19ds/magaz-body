<?php

use app\models\Product;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="row" id="tableProductList">
  <div class="col-md-12">
    <a href="/admin/info/add-step?id=<?= $id?>" class="btn btn-info">Добавить</a>
  </div>

  <div class="col-md-12">
    <div class="card full-height">
      <div class="card-body">
        <? $form = ActiveForm::begin(); ?>

        <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'columns' => [
            'date:date',
            'content',
            'title',
            [
              'attribute' => '',
              'format' => 'raw',
              'value' => function($model){
                return "<a href='/admin/info/update-step?id=$model->id'>Изменить</a>";
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