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
                <a href="/<?= $lang?>">
                <img src="/img/Logo.svg" alt="">
                </a>
            </div>
            <div class="stepblock">
                <div class="step step-cart active">Корзина</div>
                <div class="step step-contact">Контактная информация</div>
                <div class="step step-del">Способ доставки</div>
                <div class="step step-pay">Способ оплаты</div>
            </div>

            <div class="payment-final">
                Вы через 5 секунды будете перенаправлены на страницу оплаты. Если этого не произошло прейдите по ссылке.
                <br>
                <a href="">Оплатить</a>
            </div>
        </div>

    </div>
    <div class="right-block">
        <?= Apsell::widget(['title' => 'Лучший выбор покупателей']) ?>
    </div>
</div>
