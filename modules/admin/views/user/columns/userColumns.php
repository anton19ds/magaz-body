<?php
use yii\helpers\Url;
use yii\helpers\Html;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'username',
        'label' => 'E-Mail',
        'format' => 'raw',
        'value' => function($model){

            return "<a href='/admin/user/update?id={$model->id}'>{$model->username}</a>";
        }
    ],

    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'Ф.И.О',
        'value' => function($model){
            return $model->firstName." ".$model->LastName." ".$model->secondName;
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'phone',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'date',
        'value' => function($model){
            return date('Y-m-d', $model->date);
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'user_lavel.lavel_id',
        'label' => 'Уровень партнерки',
        'value' => function($model){
            try{
                return $model->userLavel->lavel_id;
            }catch(Exception $e){

            }
            
            //return date('Y-m-d', $model->date);
        }
    ],

    
            
            
    
    // [
    //     'class' => 'kartik\grid\ActionColumn',
    //     'dropdown' => true,
    //     'vAlign' => 'middle',
    //     'urlCreator' => function ($action, $model, $key, $index) {
    //         return Url::to([$action, 'id' => $key]);
    //     },
    //     'updateOptions' => ['title' => 'update', 'data-toggle' => 'tooltip'],
    //     'deleteOptions' => ['title' => 'delete', 'data-toggle' => 'tooltip'],

    //     'buttons' => [
    //         'view' => function ($url, $model) {
    //             return false;
    //         },
    //         'update' => function ($url, $model) {
    //             return Html::a(
    //                 '<span class="fas fa-pencil-alt" aria-hidden="true">Посмотр</span>',
    //                 ['user/update-partners', 'id' => $model->id],
    //                 [
    //                     'data-pjax' => 0,
    //                     'role' => 'modal-remote',
    //                     'data-toggle' => 'tooltip'
    //                 ]
    //             );
    //         },
    //         'delete' => function ($url, $model) {
    //             return Html::a(
    //                 '<span class="fas fa-trash-can" aria-hidden="true">Удалить</span>',
    //                 ['partners/delete-partners', 'id' => $model->id],
    //                 [
    //                     'data-pjax' => 0,
    //                     'role' => 'modal-remote',
    //                     'data-toggle' => 'tooltip'
    //                 ]
    //             );
    //         },
    //     ],
    // ],

    // ['class' => 'kartik\grid\CheckboxColumn']
];
return $gridColumns;
?>