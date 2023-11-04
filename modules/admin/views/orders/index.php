<?php

use app\models\Orders;
use app\models\OrdersMeta;
use app\models\OrderStatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sort-block">
    <?php echo $this->render('sort-block') ?>
</div>
<div class="orders-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'Товары в заказе',
                'format' => 'raw',
                'value' => function ($model) {
                        $orderTovar = $model->getTovar();
                        if ($orderTovar) {
                            $listTovarName = '<ul class="list-tovar-order">';
                            foreach ($orderTovar as $item) {
                                $listTovarName .= '<li><a href="">' . $item->getParam('ProductName') . '</a></li>';
                            }
                            return $listTovarName;
                        }
                    }
            ],
            [
                'attribute' => 'Покупатель',
                'format' => 'raw',
                'value' => function ($model) {
                        return '<a href="/admin/user/update?id=' . $model->user->id . '">' . $model->user->username . '</a>';
                    }
            ],
            [
                'attribute' => 'Дата заказа',
                'format' => 'raw',
                'value' => function ($model) {
                        return '<span style = "white-space: nowrap;">' . date('Y-m-d H:s', $model->date) . '</span>';
                    }
            ],
            [
                'attribute' => 'Сумма заказа',
                'value' => function ($model) {
                        return $model->dataPrice() . ' ' . $model->dataCurrensy();
                    }
            ],
            [
                'attribute' => 'Статус',
                'format' => 'raw',
                'value' => function ($model) {

                        return $this->render('selectStatus', [
                            'model' => $model
                        ]);
                    }
            ],
            [
                'attribute' => 'Тип оплаты',
                'format' => 'raw',
                'value' => function ($model) {
                        $meta = $model->Metas();
                        if ($meta) {

                            return '<span style="white-space: nowrap;">' . OrdersMeta::getLabelShiping()[$meta['payment_type']] . '</span>';
                        }
                    }
            ],
            [
                'attribute' => 'Тип доставки',
                'value' => function ($model) {
                        $meta = $model->Metas();
                        if ($meta) {

                            return OrdersMeta::getLabelStatus()[$meta['shiping_type']];
                        }
                    }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '<div style="white-space: nowrap;">{update} {delete}</div>',
                'urlCreator' => function ($action, Orders $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
            ],
        ],
    ]); ?>
</div>

<style>
    .list-tovar-order {
        padding: 0;
        margin: 0;
        list-style-type: none;
    }

    .list-tovar-order li {
        margin-bottom: 10px;

    }
</style>