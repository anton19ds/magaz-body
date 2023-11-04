<?php

use app\models\OrdersMeta;
use app\models\UserAdress;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="orders-form">
        <div class="row">
            <div class="col-md-12">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-title">
                            <?= date("Y-m-d H:s", $model->date); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'firstName')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'secondName')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($model, 'active')->textInput() ?>
                            </div>
                            <div class="col-md-6">
                                <?php $ordersUser = $model->getOrders(); ?>
                                <div class="row">
                                    <?php foreach ($ordersUser as $item): ?>
                                        <div class="col-md-12">
                                            <?php $dataOrder = $item->getTovar(); ?>
                                            <?php $arrayOrder = unserialize($item->data_order); ?>
                                            <ul style="padding:0; list-style-type:none">
                                                <?php $i = 1; ?>
                                                <?php foreach ($dataOrder as $prod): ?>
                                                    <li>
                                                        <?= $i; ?> ) -
                                                        <?= $prod->id ?>
                                                        <?= $prod->getParam('productName') ?> -
                                                        <?= $arrayOrder[$prod->id]['count'] ?> (шт.)
                                                        <?= $arrayOrder[$prod->id]['price'] ?>
                                                        <?= $arrayOrder[$prod->id]['symbol'] ?>
                                                    </li>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                            <p>
                                                <label for="">
                                                    Заказчик:
                                                </label>
                                                <?= $item->user->firstName; ?>
                                                <?= $item->user->LastName; ?>
                                                <?= $item->user->secondName; ?>
                                                <?= $item->user->email; ?>
                                                <?= $item->user->phone; ?>
                                                <br>
                                                <?= OrdersMeta::getLabelStatus()[$item->meta->shiping_type]; ?> -
                                                <?= OrdersMeta::getLabelShiping()[$item->meta->payment_type]; ?> -
                                                <?= $item->meta->order_summ; ?>
                                                <?= $item->meta->promocode; ?>
                                                <?php
                                                $adress = UserAdress::findOne($item->meta->adress_shipig);
                                                ?>
                                                <label for="">
                                                    Адрес:
                                                </label>
                                                <?= $adress->postcode; ?>
                                                <?= $adress->country; ?>
                                                <?= $adress->city; ?>
                                                <?= $adress->area; ?>
                                                <?= $adress->flat; ?>
                                                <?= $adress->street; ?>
                                            </p>
                                            <hr>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="">Доступ к инфокурсам:</label>
                                <div class="row">
                                    <?php foreach ($infoCurs as $curs): ?>
                                        <div class="col-md-12 mt-1">
                                            <?= $curs->getParam('ProductName') ?>
                                            <?php if ($curs->accessCurs($model->id)): ?>
                                                <span style="color:green">Ok</span>
                                            <?php else: ?>
                                                <span style="color:red">No</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>