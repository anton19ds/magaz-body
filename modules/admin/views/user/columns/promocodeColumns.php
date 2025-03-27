<?php
use yii\helpers\Url;
use yii\helpers\Html;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'name',
        'editableOptions' => ['header' => 'Наименование промокода', 'size' => 'md']
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'link',
        'editableOptions' => ['header' => 'Целевая ссылка', 'size' => 'md']
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'data_created',
        'value' => function($model){
            return date('d-m-Y', $model->data_created);
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'data_updated',
        'value' => function($model){
            return date('d-m-Y', $model->data_updated);
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => true,
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'updateOptions' => ['title' => 'update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['title' => 'delete', 'data-toggle' => 'tooltip'],

        'buttons' => [
            'view' => function ($url, $model) {
                return false;
            },
            'update' => function ($url, $model) {
                return Html::a(
                    '<span class="fas fa-pencil-alt" aria-hidden="true">Посмотр</span>',
                    ['user/update-partners', 'id' => $model->id],
                    [
                        'data-pjax' => 0,
                        'role' => 'modal-remote',
                        'data-toggle' => 'tooltip'
                    ]
                );
            },
            'delete' => function ($url, $model) {
                return Html::a(
                    '<span class="fas fa-trash-can" aria-hidden="true">Удалить</span>',
                    ['partners/delete-partners', 'id' => $model->id],
                    [
                        'data-pjax' => 0,
                        'role' => 'modal-remote',
                        'data-toggle' => 'tooltip'
                    ]
                );
            },
        ],
    ],

    ['class' => 'kartik\grid\CheckboxColumn']
];
return $gridColumns;
?>