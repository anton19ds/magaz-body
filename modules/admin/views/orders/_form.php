<?php

use app\models\OrdersMeta;
use app\models\OrderStatus;
use app\models\UserAdress;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="orders-form">
    <div class="row">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-header">
                    <div class="card-title">Параметры заказа  от <?= date("Y-m-d H:s", $model->date);?></div>
                    <div class="set-block">
                    <?= Html::dropDownList('status', $model->getStatus(), OrderStatus::getLabelStatus(), ['data-id' => $model->id, 'class' => 'selected-status form-control ' . $model->getStatus()])?>
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <div class="card-body">
                    
                    <?php $dataOrder = $model->getTovar(); ?>
                    
                    
                    <?php $arrayOrder = unserialize($model->data_order); ?>
                    <ul style="padding:0; list-style-type:none">
                        <?php $i = 1; ?>
                        <?php foreach ($dataOrder as $item): ?>
                            <li>
                                <?= $i; ?> ) -
                                <?= $item->id ?>
                                <?= $item->getParam('productName') ?> -
                                <?= $arrayOrder[$item->id]['count'] ?> (шт.)
                                <?= $arrayOrder[$item->id]['price'] ?>
                                <?= $arrayOrder[$item->id]['symbol'] ?>
                            </li>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </ul>
                    <hr>
                    <label for="">
                        Заказчик:
                    </label>
                    <p>
                        <?= $model->user->firstName; ?>
                        <?= $model->user->LastName; ?>
                        <?= $model->user->secondName; ?>
                        <br>
                        <?= $model->user->email; ?>
                        <br>
                        <?= $model->user->phone; ?>
                    </p>
                    <hr>

                    
                    <?= OrdersMeta::getLabelStatus()[$model->meta->shiping_type];?>
                    <br>
                    <?= OrdersMeta::getLabelShiping()[$model->meta->payment_type];?>
                    <br>
                    <?= $model->meta->order_summ;?>
                    <br>
                    <?= $model->meta->promocode;?>
                    <hr>
                    <?php
                    $adress = UserAdress::findOne($model->meta->adress_shipig);
                    ?>
                    <label for="">
                        Адрес:
                    </label>
                    <p>
                    <?= $adress->postcode;?> <?= $adress->country;?> <?= $adress->city;?>  <?= $adress->area;?> <?= $adress->flat;?> <?= $adress->street;?>
                    </p>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<style>
    .card-header{
        display: flex;
        align-items: center;
    }
    .set-block{
        display: flex;
        margin-left: 50px;
        width: 100%;
    }
    .selected-status.form-control{
        width: 100%;
        margin-right: 20px;
    }
    .card-title{
        white-space: nowrap;
    }

</style>