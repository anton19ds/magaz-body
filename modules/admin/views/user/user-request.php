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
    //'filterModel' => $searchModel,
    'columns' => require_once __DIR__ . '/columns/userRequestColumns.php',
    'beforeHeader' => [
        [
            'options' => ['class' => 'skip-export'] // remove this row from export
        ]
    ],
    'toolbar' => [
        [
            'content' =>
                Html::button('Добавить', ['type' => 'button', 'title' => 'Add Book', 'class' => 'btn btn-success', 'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");'])
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
    //'floatHeaderOptions' => ['top' => $scrollingTop],
    'showPageSummary' => true,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY
    ],
]);
?>


<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "size" => "modal-xl",
    "footer" => "", // always need it for jquery plugin
]) ?>

<?php
Modal::end();
?>



<?php $this->registerJs('
$(".removeRequest").on("click", function(e){
    e.preventDefault();
    var id = $(this).data("id");
    $.post("/admin/user/delete-request", {"id":id}, function Success(data){
        if(data){
            $.pjax.reload("#set-pajax-table", {timeout: 3000});
        }
    });
})
')?>