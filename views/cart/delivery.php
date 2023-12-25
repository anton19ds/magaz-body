<?php
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
            </ul>
        </div>
    </div>
    <div class="cart-del-type">
        <div class="title-ff">
            Способ доставки
        </div>
        <div class="del-info-data">
            <?php $form = ActiveForm::begin([
                'id' => 'form-delivery'
            ]); ?>
            <ul class="del-info-list">
                <li> <span><input type="radio" id="del1" value="russ" name="del" checked><label for="del1">По
                            России</label></span> <span> 100 ₽ </span></li>
                <li> <span><input type="radio" id="del2" value="sng" name="del"><label for="del2">Страны Балтии и
                            СНГ</label></span> <span> 500 ₽ </span></li>
                <li> <span><input type="radio" id="del3" value="ems" name="del"><label for="del3">EMS — Доставка по
                            всему миру</label></span> <span> 1 200 ₽</span></li>
            </ul>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="set-end-block">
    <a href="" class="back-cart"> Вернуться в корзину </a>
    <?= Html::submitButton('Продолжить', ['class' => 'next-step', 'id' => 'send-del']) ?>
</div>
</div>
<div class="left-block">
    <?= $this->render('min-cart', [
        'cart' => $cart,
    ]) ?>
</div>