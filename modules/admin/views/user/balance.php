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
<?php
$user_id = $model->id;
echo GridView::widget([
    'dataProvider' => $provider,
    //'filterModel' => $searchModel,
    'columns' => require_once __DIR__ . '/columns/balanceColumns.php',
    'beforeHeader' => [
        [
            'options' => ['class' => 'skip-export'] // remove this row from export
        ]
    ],
    'toolbar' => [
        [
            'content' =>"<div class='data-balance'>Баланс пользователя: ".$balanceUser." ".Html::button('Добавить', [
                'type' => 'button',
                'title' => 'Add Book',
                'class' => 'btn btn-success',
                'role' => 'modal-remote'
                //'onclick' => ''
                ])."</div>"
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

<script>
    // window.addEventListener('load', function () {
    //     $.pjax.reload({container: '#set-pajax-table', async: false});
    // })
</script>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "size" => "modal-xl",
    "footer" => "", // always need it for jquery plugin
]) ?>

<?php
Modal::end();
?>
<style>
    .data-balance{
        display: flex;
        align-items: center;

    }
    .data-balance{
        font-weight: 700;
    }
    .data-balance button{
        margin-left: 50px;
    }
</style>