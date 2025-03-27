<?php
use app\models\UserBalance;
use yii\helpers\Url;
use yii\helpers\Html;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'summ',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'type',
        'value' => function($model){
            if(isset($model->type) && !empty($model->type)){
                return UserBalance::getLabelStatus()[$model->type];
            }
        }
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'status',
        'editableOptions' => function($model, $key, $index) use ($user_id){
            return [
                    'formOptions' => [
                        'id' => $model->id,
                        'action' => 'update-balanse-status?id='.$model->id.'&user_id='.$user_id,
                    ],
                    'name' => 'status',
                    'model' => $model,
                    'displayValueConfig' => [
                        0 => 'В обработке',
                        1 => 'Обработано',
                        2 => 'Отказано'
                    ],
                    'value' => $model->status,
                    //'asPopover' => false,
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'data' => [
                        0 => 'В обработке',
                        1 => 'Обработано',
                        2 => 'Отказано'
                    ],
                    'header' => 'Статус',
                    'size' => 'md'
                ];
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'date',
        'value' => function($model){
            return date('d-m-Y H:i', $model->date);
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'order_id',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'data',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'link',
    ],
    
];
return $gridColumns;
?>