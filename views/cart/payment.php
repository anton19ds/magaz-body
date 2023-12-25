<?php

use app\models\Cart;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>
<input type="hidden" id="currensy" value="<?= $currensy ?>">
<div class="product-wrapper">
    <div class="cart-contact-info">
        <div class="title-ff">
            Контактная информация
        </div>
        <div class="contact-info-data">
            <ul class="contact-info-list">
                <li><span>Имя:</span><span>
                        <?= $user['surname'] ?>
                        <?= $user['name'] ?>
                        <?= $user['lastname'] ?>
                    </span></li>
                <li><span> Адрес: </span> <span>
                        <?= $user['postcode'] ?>
                        <?= $user['country'] ?>
                        <?= $user['city'] ?>
                        <?= $user['area'] ?>
                        <?= $user['street'] ?>
                        <?= $user['house'] ?>
                    </span></li>
                <li><span> Телефон: </span> <span>
                        <?= $user['phone'] ?>
                    </span></li>
                <li><span> E-mail: </span> <span>
                        <?= $user['email'] ?> Изменить
                    </span></li>
                <li><span>Доставка: </span> <span>
                        <?= Cart::getLabelType()[$cart['delivery']] ?>
                    </span></li>
            </ul>
        </div>
    </div>
    <div class="cart-del-type">
        <div class="title-ff">
            Способ оплаты
        </div>
        <?php $form = ActiveForm::begin([
            'id' => 'form-payment'
        ]); ?>

        <div class="pay-info-data">
            <ul class="pay-info-list">
                <li><input type="radio" id="del1" value="inteleckt" name="pay"><label for="del1">
                        <p><span>Оплата картой через IntellectMoney (Visa / Mastercard / МИР)</span><br>
                            <span>Максимальный платёж до 30 тысяч рублей за одну операцию. Оплата практически из любой
                                точки мира. Из США, Канады, Новой Зеландии и Австралии платежи не принимаются.</span>
                        </p>
                    </label></li>
                <li><input type="radio" id="del2" value="trisby" name="pay"><label for="del2">Оплата картой через сервис
                        TRISBY (Visa / Mastercard)</label></li>
                <li><input type="radio" id="del3" value="card" name="pay"><label for="del3">Ручной перевод на карту
                        банка
                        (Сбербанк Онлайн, Альфа-Банк, Тинькофф)</label></li>
            </ul>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="set-end-block">
    <a href="" class="back-cart"> Вернуться в корзину </a>
    <?= Html::submitButton('Продолжить', ['class' => 'next-step', 'id' => 'send-pay']) ?>
</div>
</div>
<div class="left-block">

    <?= $this->render('min-cart', [
        'cart' => $cart,
    ]) ?>
</div>