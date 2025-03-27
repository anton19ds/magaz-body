<?php
use yii\helpers\Url;
use yii\helpers\Html;

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'Номер заказа',
        'value' => function($model){
            return $model->id;
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'uuid',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'data_order',
        'format' => 'raw',
        'value' => function($model){
            $listOrder = '<ul>';
            foreach(unserialize($model->data_order) as $item){
                $listOrder .= '<li>'.$item['productName'].' x '.$item['count'].' - '.$item['productSize']['totalPrice'];
            }
            $listOrder .= '</ul>';
            //return debug(unserialize($model->data_order));
            return $listOrder;
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'Сумма заказа',
        'format' => 'raw',
        'value' => function($model){
            $orderSumm = unserialize($model->ordersMeta->order_summ);
            return $orderSumm['salePrice'];
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'Дата заказа',
        'format' => 'raw',
        'value' => function($model){
            return date('d-m-Y', $model->date);
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'shiping_type',
        'format' => 'raw',
        'value' => function($model){
            return $model->ordersMeta->shiping_type;
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'payment_type',
        'format' => 'raw',
        'value' => function($model){
            return $model->ordersMeta->payment_type;
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'promocode',
        'value' => function($model){
            return $model->ordersMeta->promocode;
        }
        
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'Статус',
        'format' => 'raw',
        'value' => function($model){
            return $model->orderStatus->status;
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