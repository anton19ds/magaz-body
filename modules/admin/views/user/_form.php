<?php

use app\models\OrdersMeta;
use app\models\PromoUserSize;
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


                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <?php $ordersUser = $model->getOrders(); ?>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>Список заказов</h2>
                                    </div>
                                    <?= $this->render('order-list', [
                                        'ordersUser' => $ordersUser
                                    ]) ?>

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
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>Партнерская система</h2>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="">Уровень программы:</label>
                                        <?= $model->lavel->name ?>
                                    </div>
                                    <div class="col-md-6">
                                        <table style="width:100%">
                                            <tr>
                                                <th>Категория</th>
                                                <th style="text-align:center">Скидка партнеру</th>
                                                <th style="text-align:center">Вознаграждение за покупку</th>
                                                <th style="text-align:center">Обшая скидка</th>
                                            </tr>
                                            <?php $categoryLavel = $model->categoryLavel; ?>
                                            <?php foreach ($categoryLavel as $item): ?>
                                                <tr>
                                                    <td>
                                                        <?= $item->categoryPromo->name ?>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <?= $item->size / 2 ?>%
                                                    </td>
                                                    <td style="text-align:center">
                                                        <?= $item->size / 2 ?>%
                                                    </td>
                                                    <td style="text-align:center">
                                                        <?= $item->size ?>%
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2>Промокоды</h2>
                                            </div>
                                            <div class="col-md-12">
                                                <?php if (empty($model->promo)): ?>
                                                    <label for="" class="mb-3">Промокодов нет
                                                        <sub>(Промокод по
                                                            умолчанию)
                                                        </sub>
                                                    </label>
                                                    <div>
                                                        <p><a href="/ru/p/promo-<?= $model->id ?>">promo-
                                                                <?= $model->id ?>
                                                            </a>
                                                        </p>
                                                    </div>
                                                    <table style="width:100%">
                                                        <tr>
                                                            <th>Категория</th>
                                                            <th style="text-align:center">Скидка партнеру</th>
                                                            <th style="text-align:center">Вознаграждение за покупку</th>
                                                            <th style="text-align:center">Обшая скидка</th>
                                                        </tr>
                                                        <?php $categoryLavel = $model->categoryLavel; ?>
                                                        <?php foreach ($categoryLavel as $item): ?>
                                                            <tr>
                                                                <td>
                                                                    <?= $item->categoryPromo->name ?>
                                                                </td>
                                                                <td style="text-align:center">
                                                                    <?= $item->size / 2 ?>%
                                                                </td>
                                                                <td style="text-align:center">
                                                                    <?= $item->size / 2 ?>%
                                                                </td>
                                                                <td style="text-align:center">
                                                                    <?= $item->size ?>%
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </table>
                                                <?php else: ?>
                                                    <?= $this->render('promo_data', [
                                                        'model' => $model
                                                    ]) ?>

                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
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