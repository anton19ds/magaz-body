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
        <?php $form = ActiveForm::begin(); ?>

        <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'columns' => [
            [
                'attribute' => 'img',
                'format' => 'raw',
                'value'=> function ($model) {
                    try{
                        if(!empty($model->img)){
                            $image = json_decode($model->img, true);
                            if(isset($image['array']) && !empty($image['array'])){
                                return "<img style='width:100px' src='".$image['array']['1']['value']."'>";
                            }
                        }
                    }catch(Exception $e){
        
                    }
                }
            ],
            'title',
            [
              'attribute' => 'sort',
              'format' => 'raw',
              'value' => function($model){
                return "<input value='{$model->sort}' type='number' data-id='{$model->id}' class='sort-update' min=0>";
              }
            ],
            [
                'attribute' => 'Действие',
                'format' => 'raw',
                'value' => function($model) use ($tag, $id){
                    return "<ul><li><a href='/admin/info/category-update?id=".$model->id."'>Редактировать</a></li>".
                    "<li><a href='/admin/info/category-lesons?id=".$model->id."&tag=".$tag."'>Список уроков</a></li>".
                    "<li><a href='/admin/info/category-delete?id=".$model->id."&tag=".$tag."' data-confirm='Вы уверены, что хотите удалить этот элемент. Это приведет к удалению уроков?'>Удалить</a></li></ul>";
                }
            ],
            [
                'attribute' => 'Количество уроков',
                'format' => 'raw',
                'value'=> function($model){
                    return $model->countStep();
                }
              ],
            'date:date',

          ],
          
        ]); ?>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>




<?php

$this->registerJs('
$(".sort-update").on("change", function(e){
  var id = $(this).data("id");
  var val = $(this).val();
  var obj = $(this);
  $.post("/admin/info/update-sort-category", {id: id, val: val}, function Success(data){
    if(data){
      obj.css("border", "1px solid #51e751");
    }else{
      obj.css("border", "1px solid red");
    }
  });
})
')
?>
<style>
  .sort-update{
    outline: none;
  }
</style>