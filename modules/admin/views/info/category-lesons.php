<?php

use app\models\Product;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="row">
  <div class="col-md-12">
    <div class="card full-height">
      <div class="card-header">
        <div class="card-title">Список уроков</div>
      </div>
      <div class="card-body">
        <div class="row" id="tableProductList">
          <div class="col-md-12">
            
            
            <a href="/admin/info/category?id=<?= $category->infoproduct_id?><?= isset($tag) && !empty($tag) ? "&tag=".$tag : ""?>" class="btn btn-warning">Назад</a>
            <a href="/admin/info/add-step?id=<?= $id ?>&tag=<?= $tag ?>" class="btn btn-info">Добавить</a>
          </div>
          <div class="col-md-12">
            <div class="card full-height">
              <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                  'columns' => [
                    'date:date',
                    'content',
                    'title',
                    [
                      'attribute' => 'sort',
                      'format' => 'raw',
                      'value' => function ($model) {
                                        return "<input value='{$model->sort}' type='number' data-id='{$model->id}' class='sort-update' min=0>";
                                      }
                    ],
                    [
                      'attribute' => 'time',
                      'format' => 'raw',
                      'value' => function ($model) {
                                        return "<input value='{$model->time}' type='number' data-id='{$model->id}' class='time-update' min=0>";
                                      }
                    ],
                    [
                      'attribute' => 'hourse',
                      'format' => 'raw',
                      'value' => function ($model) {
                                        return "<input value='{$model->hourse}' type='time' data-id='{$model->id}' class='hourse-update' min=0>";
                                      }
                    ],
                    [
                      'attribute' => 'Язык',
                      'format' => 'raw',
                      'value' => function($model){
                        return Html::dropDownList('select-'.$model->id, $model->lang, [
                          'ru' => 'ru',
                          'cs' => 'cs',
                          'en' => 'en'
                        ],['data-id' => $model->id, 'class' => 'select-lang']);
                         //$model->lang;
                      }
                    ],
                    'disc',
                    [
                      'attribute' => '',
                      'format' => 'raw',
                      'value' => function ($model) use ($tag) {
                                        return "<a href='/admin/info/update-step?id=$model->id&tag=$tag'>Изменить</a>" . "<br>" . "<a href='#'  class='delete-step' data-id='$model->id'>Удалить</a>";
                                      }
                    ],
                  ],
                ]); ?>
                <?php //= Html::submitButton('qwe') ?>
                <?php ActiveForm::end(); ?>
              </div>
            </div>
          </div>
        </div>




        <?php

        $this->registerJs('
$(".delete-step").on("click", function(e){
  e.preventDefault();
  var id = $(this).data("id");
  var conf = confirm("Удалить?");
  if(conf){
    $.post("/admin/info/delete-step", {id: id}, function Success(data){
      if(data){
        document.location = document.location;
      }
    });
  }
})
$(".sort-update").on("change", function(e){
  var id = $(this).data("id");
  var val = $(this).val();
  var obj = $(this);
  $.post("/admin/info/update-sort-step", {id: id, val: val}, function Success(data){
    if(data){
      obj.css("border", "1px solid #51e751");
    }else{
      obj.css("border", "1px solid red");
    }
  });
})


$(".time-update").on("change", function(e){
  var id = $(this).data("id");
  var val = $(this).val();
  var obj = $(this);
  $.post("/admin/info/time-update-step", {id: id, val: val}, function Success(data){
    if(data){
      obj.css("border", "1px solid #51e751");
    }else{
      obj.css("border", "1px solid red");
    }
  });
})


$(".hourse-update").on("change", function(e){
  var id = $(this).data("id");
  var val = $(this).val();
  var obj = $(this);
  $.post("/admin/info/hourse-update-step", {id: id, val: val}, function Success(data){
    if(data){
      obj.css("border", "1px solid #51e751");
    }else{
      obj.css("border", "1px solid red");
    }
  });
});



$(".select-lang").on("change", function(e){
var id = $(this).data("id");
var val = $(this).val();
var obj = $(this);
$.post("/admin/info/lang-update-step", {id: id, val: val}, function Success(data){
    if(data){
      obj.css("border", "1px solid #51e751");
    }else{
      obj.css("border", "1px solid red");
    }
  });
});
')
          ?>
        <style>
          .sort-update {
            outline: none;
          }
        </style>
      </div>
    </div>
  </div>
</div>