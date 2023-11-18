<?php

use app\widgets\Apsell;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
    'id' => 'order-form',
]); ?>
<div id="page-magazin">
<?= $form->field($model, 'data_order')->hiddenInput(['value' => serialize($cart)])->label(false) ?>
    <div class="left-block">
        <div class="header-block-cart">
            <div class="logo">
            <a href="/<?= $currensy ?>">
                <img src="/img/Logo.svg" alt="">
            </a>    
            </div>
            <div class="stepblock">
                <div class="step step-cart">Корзина</div>
                <div class="step step-contact active">Контактная информация</div>
                <div class="step step-del">Способ доставки</div>
                <div class="step step-pay">Способ оплаты</div>
            </div>
        </div>

        <div class="order-form-cart">
            <?php $userAdress = $user->userAdress; ?>
            <div class="adress-list">
                <?php foreach ($userAdress as $key => $item): ?>
                    <div class="adress-item <?= ($key == 0 ? 'active' : '')?>">
                        <ul>
                            <li class="name_data">
                                <input type="checkbox" name="activeAdress" value="<?= $item->id ?>" class="chekerAdress" <?= ($key == 0 ? 'checked=checked' : '')?>>
                                <?= $user->LastName ?>
                                <?= $user->secondName ?>
                                <?= $user->firstName ?>
                            </li>
                            <li>
                                <p>
                                    <?= $item->country ?>
                                    <?= $item->postcode ?>
                                    <?= $item->area ?>
                                    <?= $item->city ?>
                                    <?= $item->street ?>
                                    <?= $item->flat ?>
                                </p>
                            </li>
                            <li>
                                <?= $user->phone ?>
                            </li>
                            <li>
                                <?= $user->email ?>
                            </li>
                        </ul>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="new_adress set_newadress">

                <input type="checkbox" name="activeAdress" value="newAdress" class="chekerAdress">
                Новый адрес
            </div>
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <?php echo Yii::$app->session->getFlash('error'); ?>
                </div>
            <?php endif; ?>
            <div class="cart-field">
                <input type="text" onkeypress="validate(event)" placeholder="" name="User[email]" class="requered"
                    value="<?= $user->email ?>">
                <label class="set-label">E-mail</label>
            </div>
            <div class="checkbox-field">
                <label>
                    <input type="checkbox" style="display:none" name="podpiska">
                    <div class="text-checkbox">
                        <span>Сообщать мне об акциях и скидках</span>
                    </div>
                </label>
            </div>

            <div class="cart-field s-phone">
                <input type="phone" onkeypress="validate(event)" placeholder="" name="User[phone]" class="requered"
                    value="<?= $user->phone ?>">
                <label class="set-label">Телефон</label>
            </div>
            <div class="checkbox-field in-border active">
                <label>
                    <input type="checkbox" style="display:none" name="sms" checked>
                    <div class="text-checkbox">
                        <div class="title">
                            Получать СМС оповещения о моем заказе
                            <span>Сразу после отправки заказа вы получите трек-номер посылки на
                                e-mail и в sms для отслеживания актуальной информации о
                                местонахождении отправления.</span>
                        </div>
                    </div>
                </label>
            </div>
            <div class="field-block-contact">
                <div class="slider_adress" style="display:none">
                    <div class="title-block">Адрес доставки</div>
                    <div class="form-contact-cart-order">
                        <div class="cart-field">
                            <input type="text" name="UserAdress[country]" onkeypress="validate(event)" placeholder=""
                                value="">
                            <label class="set-label">Страна</label>
                        </div>
                        <div class="card-set-el">
                            <div class="block-form-cart-left">
                                <div class="cart-field">
                                    <input type="text" name="UserAdress[postcode]" onkeypress="validate(event)"
                                        placeholder="" value="">
                                    <label class="set-label">Индекс</label>
                                </div>
                                <div class="cart-field">
                                    <input type="text" name="UserAdress[area]" onkeypress="validate(event)"
                                        placeholder="" value="">
                                    <label class="set-label">Область</label>
                                </div>
                            </div>
                            <div class="block-form-cart-right">
                                <div class="cart-field">
                                    <input type="text" name="UserAdress[city]" onkeypress="validate(event)"
                                        placeholder="">

                                    <label class="set-label">Город</label>
                                </div>
                                <div class="cart-field">
                                    <input type="text" name="UserAdress[street]" onkeypress="validate(event)"
                                        placeholder="">
                                    <label class="set-label">Улица</label>
                                </div>
                            </div>
                        </div>

                        <div class="cart-field">
                            <input type="text" name="UserAdress[flat]" onkeypress="validate(event)" placeholder="">
                            <label class="set-label">Дом, корпус, строение, квартира</label>
                        </div>
                        <div class="card-set-el">
                            <div class="col-s-1">
                                <div class="cart-field">
                                    <input type="text" name="User[firstName]" onkeypress="validate(event)"
                                        placeholder="">
                                    <label class="set-label">Фамилия</label>
                                </div>
                            </div>
                            <div class="col-s-1">
                                <div class="cart-field">
                                    <input type="text" name="User[LastName]" onkeypress="validate(event)"
                                        placeholder="">
                                    <label class="set-label">Имя</label>
                                </div>
                            </div>
                            <div class="col-s-1">
                                <div class="cart-field">
                                    <input type="text" name="User[secondName]" onkeypress="validate(event)"
                                        placeholder="">
                                    <label class="set-label">Отчество</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-field">
                    <input type="text" placeholder="">
                    <label class="set-label">Комментарии к заказу</label>
                </div>

                <div class="final-block">
                    <div class="bock-1">
                        <a href="">Вернуться в корзину</a>
                    </div>
                    <div class="bock-2">
                        <?= Html::submitButton('Продолжить', ['class' => 'btn btn-order-save']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-block">
    <?= Apsell::widget(['title' => 'Лучший выбор покупателей']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>


<div class="container">

    <?php
    //= $form->field($model, 'user_id')->textInput(['value' => Yii::$app->user->identity->id]) ?>




    <?php if (!empty($userAdressData)): ?>
        <div class="col-md-12">
            <label for="">Список адресов</label>
            <div class="row">
                <?php foreach ($userAdressData as $item): ?>
                    <div class="col-md-3">
                        <?php debug($item) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php endif; ?>

    <!-- getLabelStatus() -->

    <?php //=
    // $form->field($ordersMeta, 'shiping_type')->radioList($ordersMeta->getLabelStatus(), [
    //     'item' => function ($index, $label, $name, $checked, $value) {
    //             $check = $checked ? ' checked="checked"' : '';
    //             return "<label class=\"form__param\"><input type=\"radio\" name=\"$name\" value=\"$value\"$check> <i></i> $label</label>";
    //         }
    // ]);
    ?>


    <?php //=
    // $form->field($ordersMeta, 'payment_type')->radioList($ordersMeta->getLabelShiping(), [
    //     'item' => function ($index, $label, $name, $checked, $value) {
    //         $check = $checked ? ' checked="checked"' : '';
    //         return "<label class=\"form__param\"><input type=\"radio\" name=\"$name\" value=\"$value\"$check> <i></i> $label</label>";
    //     }
    // ]);
    ?>






</div>