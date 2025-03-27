<?php
use yii\helpers\Url;
use yii\helpers\Html;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'text',
    ],

    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'status',
        'editableOptions' => function($model, $key, $index){
            return [
                    'formOptions' => [
                        'id' => $model->id,
                        'action' => 'update-request-status?id='.$model->id,
                    ],
                    'name' => 'status'.$model->id,
                    'model' => $model,
                    'displayValueConfig' => [
                        0 => 'Не прочитано',
                        1 => 'Прочитано'
                    ],
                    'value' => $model->status,
                    //'asPopover' => false,
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'data' => [
                        0 => 'Не прочитано',
                        1 => 'Прочитано'
                    ],
                    'header' => 'Статус',
                    'size' => 'md'
                ];
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'type',
        'value' => function($model){
            if($model->type == '1'){
                return 'Заявка на повышения уровня партнерки';
            }else{
                return 'Сообщение обратной связи';
            }
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'date',
        'value' => function($model){
            return date('d.m.Y H:i',$model->date);
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'updateOptions' => ['title' => 'update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => [
            'title' => 'delete',
        ],
        'buttons' => [
            'view' => function ($url, $model) {
                return false;
            },
            'update' => function ($url, $model) {
                return false;
            },
            'delete' => function ($url, $model) {
                return Html::a(
                    '<span class="fas fa-trash-can removeRequest" data-id="'.$model->id.'" aria-hidden="true" >Удалить</span>',
                    ['delete-request', 'id' => $model->id],
                    [
                    'title'=>'Delete', 
                    'data-confirm'=>false,
                    'data-confirm-title'=>'Are you sure?',
                    'data-confirm-message'=>'Are you sure want to delete this item'
                ], 
                );
            },
        ],
    ],
];
return $gridColumns;
?>