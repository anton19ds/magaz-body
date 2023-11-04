<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            // 'password',
            // 'authKey',
            // 'accessToken',
            'email:email',
            'firstName',
            'LastName',
            'secondName',
            'phone',
            'date:date',
            'active',
        ],
    ]) ?>
</div>
<div class="user_orders">
    <label for="">Заказы</label>
    <?php $order = $model->getOrders(); ?>
    <?php if (!empty($order)): ?>
        <table class="order_user_list">
            <tr>
                <th style="text-align: center;">#</th>
                <th>uuid</th>
                <th style="text-align: center;">В заказе</th>
                <th style="text-align: center;">Дата заказа</th>
            </tr>
            <?php if ($order): ?>
                <?php $chet = 1; ?>
                <?php foreach ($order as $key => $element): ?>
                    <tr>
                        <td class="numb">
                            <?= $chet ?>
                        </td>
                        <td>
                            <a href="#" class="view-product" data-uuid="<?= $element->uuid; ?>" data-lang="<?php //= $lang; ?>">
                                №
                                <?= $element->uuid; ?>
                            </a>
                        </td>
                        <td class="date-set">
                            <?php echo $element->orderInfo() ?>
                        </td>

                        <td class="date-set">
                            <?php echo date('Y-m-d H:s', $element->date); ?>
                        </td>
                    </tr>
                    <?php $chet++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    <?php endif; ?>
</div>
<div class="user_orders_infocurs">
    <label for="">Доступные инфокурсы</label>
    <?php $order = $model->getInfocurs(); ?>
    <?php if (!empty($order)): ?>
        <table class="order_user_list">
            <tr>
                <th style="text-align: center;">#</th>
                <th>uuid</th>
                <th style="text-align: center;">Инфокурс</th>
            </tr>
            <?php if ($order): ?>
                <?php $chet = 1; ?>
                <?php foreach ($order as $key => $element): ?>
                    <tr>
                        <td class="numb">
                            <?= $chet ?>
                        </td>
                        <td>
                            <a href="#" class="view-product" data-uuid="<?= $element->uuid; ?>" data-lang="<?php //= $lang; ?>">
                                №
                                <?= $element->uuid; ?>
                            </a>
                        </td>
                        <td class="date-set">
                            <?php echo $element->product_id ?>
                        </td>

                    </tr>
                    <?php $chet++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    <?php endif; ?>

</div>



<style>
    .order_user_list th,
    .order_user_list td {
        border: 1px solid #ddd;
        font-weight: 300;
        font-size: 14px;
        padding: 5px;
        padding: 15px;
    }

    .order_user_list td.date-set {
        width: 150px;
        text-align: center;
    }

    .order_user_list td.numb {
        width: 25px;
        text-align: center;
    }

    .user_orders_infocurs {
        margin-top: 30px;
    }
</style>