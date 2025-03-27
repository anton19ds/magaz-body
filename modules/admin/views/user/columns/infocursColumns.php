<?php
use app\models\Product;
use yii\helpers\Url;
use yii\helpers\Html;
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    // [
    //     'class' => 'kartik\grid\EditableColumn',
    //     'attribute' => 'name',
    //     'editableOptions' => ['header' => 'Наименование промокода', 'size' => 'md']
    // ],
    // [
    //     'class' => 'kartik\grid\EditableColumn',
    //     'attribute' => 'link',
    //     'editableOptions' => ['header' => 'Целевая ссылка', 'size' => 'md']
    // ],
    // [
    //     'class' => 'kartik\grid\DataColumn',
    //     'attribute' => 'id',
    // ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'Наименование',
        'value' => function($model){
            return $model['productMeta']['productName'];
        }
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'status',
        'editableOptions' => function($model, $key, $index) use ($user_id){
            $stat = Product::accessEnableInfo($model['id'], $user_id);
            return [
                    'formOptions' => [
                        'id' => $model['id'],
                        'action' => 'open-user-info?id='.$model['id']."&user_id=".$user_id,
                    ],
                    'name' => 'status'.$model['id'],
                    'model' => $model,
                    'displayValueConfig' => [
                        false => 'закрыт',
                        true => 'открыт'
                    ],
                    'value' => $stat,
                    'asPopover' => false,
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'data' => [
                        false => 'закрыт',
                        true => 'открыт'
                    ],
                    'header' => 'Доступность',
                    'size' => 'md'
                ];
        }
    ],
    [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'Отправка Уведомления',
        'editableOptions' => function($model, $key, $index) use ($user_id){
            $stat = Product::accessEnableInfo($model['id'], $user_id);
            return [
                    'formOptions' => [
                        'id' => $model['id'],
                        'action' => 'message-user-info?id='.$model['id']."&user_id=".$user_id,
                    ],
                    'name' => 'type',
                    'model' => $model,
                    'displayValueConfig' => [
                        '0' => 'отправить уведомление',
                        'ru' => 'ru',
                        'en' => 'en',
                        'cs' => 'cs'
                    ],
                    'value' => 0,
                    'asPopover' => false,
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'data' => [
                        '0' => 'отправить уведомление',
                        'ru' => 'ru',
                        'en' => 'en',
                        'cs' => 'cs'
                    ],
                    'header' => 'Отправка Уведомления',
                    'size' => 'md'
                ];
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'id',
    ]
];
return $gridColumns;
?>
