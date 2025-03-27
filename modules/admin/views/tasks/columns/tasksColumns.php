<?php
use yii\helpers\Url;
use yii\helpers\Html;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'name',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'text',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'status',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'summ',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'summ',
        'format' => 'raw',
        'value' => function($model){
            return '<a href="/admin/tasks/update-task?id='.$model->id.'">Редактировать</a>';
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
                    '<span class="fas fa-pencil-alt" aria-hidden="true">Изменить</span>',
                    ['tasks/update', 'id' => $model->id],
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
                    ['tasks/delete-tasks', 'id' => $model->id],
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