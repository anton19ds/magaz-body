<?php
use yii\helpers\Url;
use yii\helpers\Html;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'tasks_id',
        'value' => function($model){
            return $model->tasks->name;
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'text',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'file',
        'format' => 'raw',
        'value' => function($model){
            $array = unserialize($model->file);
            $list = '<ul>';
            foreach($array as $key => $value){
                if(file_exists(Yii::getAlias('@webroot/uploads/').$value)){
                    $list .= '<li><a href="/uploads/'.$value.'" target="_blank" data-pjax="0">'.$value.'</a></li>';
                }
            }
            $list .='</ul>';
            return $list;
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'date',
        'value' => function($model){
            return date('d.m.Y H:i', $model->date);
        }
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'status',
        'editableOptions' => function($model, $key, $index){
            return [
                    'formOptions' => [
                        'id' => $model->id,
                        'action' => 'update-tasks-status?id='.$model->id,
                    ],
                    'name' => 'status'.$model->id,
                    'model' => $model,
                    'displayValueConfig' => [
                        0 => 'Не проверен',
                        1 => 'Проверен',
                        2 => 'Не пройден'
                    ],
                    'value' => $model->status,
                    //'asPopover' => false,
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'data' => [
                        0 => 'Не проверен',
                        1 => 'Проверен',
                        2 => 'Не пройден'

                    ],
                    'header' => 'Статус',
                    'size' => 'md'
                ];
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
        'deleteOptions' => ['title' => 'delete', 'data-toggle' => 'tooltip'],

        'buttons' => [
            'view' => function ($url, $model) {
                return false;
            },
            'update' => function ($url, $model) {
                return false;
            },
            'delete' => function ($url, $model) {
                return Html::a(
                    '<span class="fas fa-trash-can removeTask" aria-hidden="true" data-id="'.$model->id.'">Удалить</span>',
                    ['partners/delete-partners', 'id' => $model->id],
                    [
                        
                    ]
                );
            },
        ],
    ],
    ['class' => 'kartik\grid\CheckboxColumn']
];
return $gridColumns;
?>