<?php
use app\models\OrdersMeta;
use app\widgets\Apsell;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
?>

<div id="page-magazin">
    <div class="left-block">
        <div class="header-block-cart">
            <div class="logo">
                <img src="/img/Logo.svg" alt="">
            </div>
            <div class="stepblock">
                <div class="step step-cart active">Корзина</div>
                <div class="step step-contact">Контактная информация</div>
                <div class="step step-del">Способ доставки</div>
                <div class="step step-pay">Способ оплаты</div>
            </div>
        </div>

    </div>
    <div class="right-block">
        <?= Apsell::widget(['title' => 'Лучший выбор покупателей']) ?>
    </div>
</div>
