<?php
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
//debug($provider);
use kartik\grid\GridView;

use yii\widgets\Pjax;
?>
<br>
<br>
<br>
<?php
echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => require_once __DIR__ . '/columns/userReviewsColumns.php',
    'beforeHeader' => [
        [
            'options' => ['class' => 'skip-export']
        ]
    ],
    'toolbar' => [
        [
            'content' => '',
        ],
    ],
    'pjax' => true,
    'pjaxSettings' =>[
        'neverTimeout' => true ,
        'options' => [
            'id' => 'set-pajax-table'
        ]
    ],
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'responsive' => false,
    'hover' => true,
    'floatHeader' => true,
    'showPageSummary' => true,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY
    ],
]);
?>

<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "size" => "modal-xl",
    "footer" => "",
]) ?>

<?php
Modal::end();
?>

<?php $this->registerJs('
$(".removeRivers").on("click", function(e){
    e.preventDefault();
    var id = $(this).data("id");
    $.post("/admin/user/delete-rivers", {"id":id}, function Success(data){
        if(data){
            setTimeout(() => {
                $.pjax.reload("#set-pajax-table");
              }, 2000);
        }
    });
})
')?>