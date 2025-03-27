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
    'columns' => require_once __DIR__ . '/columns/tasksColumns.php',
    'beforeHeader' => [
        [
            'options' => ['class' => 'skip-export'] // remove this row from export
        ]
    ],
    'toolbar' => [
        [
            'content' =>
            Html::a(
                '<span class="fas fa-pencil-alt" aria-hidden="true">Добавить</span>',
                ['/admin/tasks/create'],
                [
                    'data-pjax' => 0,
                    'role' => 'modal-remote',
                    'data-toggle' => 'tooltip'
                ]
                ),
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