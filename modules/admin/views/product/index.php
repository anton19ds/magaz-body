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
                <?php \yii\widgets\Pjax::begin([
                    'id' => 'pjaxTable'
                ]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        // [
                        //   'attribute' => '',
                        //   'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
                        //   'format' => 'raw',
                        //   'value' => function ($model) {
                        //             $obj = '<input type="checkbox" value="' . $model->id . '" name="action[' . $model->id . ']">';
                        //             return $obj;
                        //           }
                        // ],
                        [
                            'attribute' => 'Картинка',
                            'contentOptions' => ['class' => 'table_class-image', 'style' => 'width:60px'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->getProductFoto();
                            }
                        ],
                        [
                            'attribute' => 'Название',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $titleRes = '<div class="product_data">' .
                                    '<span class="link-product"><a href="/admin/product/update?id=' . $model->id . '">' . ($model->getParam('shortName') ? $model->getParam('shortName') : $model->getParam('productName')) . '</a></span><br>' .
                                    '<sub>' . $model->getParam('productName') . '</sub>' .
                                    '<ul>' .
                                    '<li><a href="/admin/product/update?id=' . $model->id . '">id: ' . $model->id . '</a></li>' .
                                    '<li><a class="stap-update" data-id="' . $model->id . '">Быстрое редактирование</a></li>' .
                                    '<li><a>История</a></li>' .
                                    '<li><a class="delete-product" data-id="' . $model->id . '" style="color:red" href="/admin/product/delete?id=' . $model->id . '" data-confirm="Вы уверены, что хотите удалить этот элемент?">Удалить</a></li>' .
                                    '</ul>
                        </div>
                        <div class="block-stap-update-' . $model->id . '"></div>
                        ';
                                return $titleRes;
                            }
                        ],
                        [
                            'attribute' => 'Тип товара',
                            'format' => 'raw',
                            'value' => function ($model) {

                                return Product::getLabelType()[$model->getType()];
                            }
                        ],
                        [
                            'attribute' => 'Категория',
                            'contentOptions' => ['style' => 'width:0px; white-space: nowrap;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->getCategory();

                            }
                        ],
                        [
                            'attribute' => 'price',
                            'contentOptions' => ['style' => 'width:0px; white-space: nowrap;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                $str = "<ul><li>RUB - " . $model->price . "</li>";
                                if ($model->getPrice()) {
                                    foreach ($model->getPrice() as $key => $value) {
                                        $str .= "<li>" . $key . "-" . $value . "</li>";
                                    }
                                }
                                $str .= "</ul>";
                                return $str;
                            }

                        ],
                        [
                            'attribute' => 'sale',
                            'contentOptions' => ['style' => 'width:0px; white-space: nowrap;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->sale) {
                                    $str = "<psan>-" . $model->sale . "%</span>";
                                    return $str;
                                }

                            }
                        ],
                        [
                            'attribute' => 'date',
                            'contentOptions' => ['style' => 'width:0px; white-space: nowrap;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                $str = "<psan>Опубликован<br>" . date('Y-m-d в H:s', $model->date) . "</span>";
                                return $str;
                            }
                        ],
                        [
                            'attribute' => '',
                            'contentOptions' => ['style' => 'width:0px; white-space: normal;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->active) {
                                    return "<span class='statys st-ok'></span>";
                                } else {
                                    return "<span class='statys st-no'></span>";
                                }
                            }
                        ],
                    ],
                ]); ?>
                <?php //= Html::submitButton('qwe') ?>
                <?php \yii\widgets\Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


<?php
$this->registerJs('
$(document).on("click", "a.stap-update", function(e){
var id = $(this).data("id");
$.post("/admin/product/stap-update", {id : id}, function Success(data){
  if($(".fast-update").length){
    $(".fast-update").remove();
  }
  $("tr[data-key=\""+id+"\"]").after(data);
});
});

$(document).on("submit", "#form-update-prod", function (e) {
  e.preventDefault();
  var $yiiform = $("#form-update-prod");
  $.ajax({
    type: $yiiform.attr("method"),
    url: $yiiform.attr("validationUrl"),
    data: $yiiform.serializeArray()
      }
  )
  .done(function(data) {
     if(data) {
      $.pjax.reload({container: "#pjaxTable", async: false});
      
      
      }
  })
})
$(document).on("pjax:success", function(event) {
   $.notify({
     	icon: "flaticon-alarm-1",
     	title: "Сообщение",
     	message: "Сохранено",
     },{
     	type: "info",
     	placement: {
     		from: "bottom",
     		align: "right"
     	},
     	time: 900000,
     });
})

')

    ?>

<style>
    .st-ok {
        background-color: green;
    }

    .st-no {
        background-color: red;
    }

    .statys {
        display: block;
        width: 20px;
        height: 20px;
        border-radius: 50px;
    }
    #product-raite{
        height: 40px;
        align-items: center;
        justify-content: center;
    }
    #product-raite label{
        margin-bottom: 0;
        margin-right: 5px;
    }
    .link-product a{
        font-size: 14px;
        text-transform: lowercase;
    }
    #tableProductList table th,
    #tableProductList table td{
        padding: 0 10px !important;
    }
    #tableProductList .product_data{
        padding: 10px 0;
    }
</style>