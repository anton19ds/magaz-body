<?php

use app\models\OrdersMeta;
use app\widgets\Apsell;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>


<?php $form = ActiveForm::begin([
    'id' => 'payment-form',
]); ?>


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

        <div class="order-form-cart">
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <?php echo Yii::$app->session->getFlash('error'); ?>
                </div>
            <?php endif; ?>
            <div class="set-block-data payment-cart-data">
                <p><span>Имя:</span><span>
                        <?= $user['firstName']; ?>
                        <?= $user['LastName']; ?>
                        <?= $user['secondName']; ?>
                    </span></p>
                <p><span>Телефон:</span><span>
                        <?= $user['phone']; ?>
                    </span></p>
                <p><span>Адрес:</span><span>
                        <?= $userAdress['postcode'] ?>
                        <?= $userAdress['city'] ?>
                        <?= $userAdress['country'] ?>
                        <?= $userAdress['area'] ?>
                        <?= $userAdress['flat'] ?>
                        <?= $userAdress['street'] ?>
                    </span></p>
                <p><span>E-mail:</span><span>
                        <?= $user['email']; ?>
                    </span></p>
            </div>
            <div class="paymnet-type">
                <div class="elem-payment">
                <div class="stek-input"></div>
                    <label>
                        <input type="radio" name="pay-type" value="<?= OrdersMeta::Inteleckt?>" class="type-payment">
                        <span>Intelect Money</span>
                        <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem est adipisci obcaecati corporis aliquam. Impedit tempore beatae itaque accusantium exercitationem ut modi libero sequi! Corrupti ratione nulla reprehenderit sapiente incidunt.
                        </p>
                        
                    </label>
                </div>
                <div class="elem-payment">
                    <div class="stek-input"></div>
                    <label>
                        <input type="radio" name="pay-type" value="<?= OrdersMeta::TRISBY?>" class="type-payment">
                        <span>Trisby</span>
                    </label>
                </div>
                <div class="elem-payment">
                <div class="stek-input"></div>
                    <label>
                        <input type="radio" name="pay-type" value="<?= OrdersMeta::CARD?>" class="type-payment">
                        <span>Переводом на карту</span>
                    </label>
                </div>
            </div>
            <div class="field-block-contact">
                <div class="final-block">
                    <div class="bock-1">
                        <a href="">Вернуться в корзину</a>
                    </div>
                    <div class="bock-2">
                        <?= Html::submitButton('Продолжить', ['class' => 'btn btn-order-payment']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-block">
    <?= Apsell::widget(['title' => 'Лучший выбор покупателей']) ?>

        <!-- <div class="apccel">
            <div class="appcel-header">
                <span>Приобретайте страховку, чтобы защитить свой товар на всех этапах
                    доставки:</span>
            </div>
            <div class="appcel-body">
                <div class="appcel-list">
                    <div class="appcel-element">
                        <div class="img-appcel">
                            <img src="/img/IMG_7555 2.png" alt="">
                        </div>

                        <div class="appcel-data">
                            <div class="appcel-title">
                                <div class="dd-title">
                                    <span class="title"> Cтраховка </span>

                                    <span>
                                        Если вашу посылку потеряет почта, то мы вышлем вам новый
                                        товар.
                                    </span>
                                </div>
                            </div>

                            <div class="appcel-element-data">
                                <div class="appcel-rating">
                                    <div class="apccels-rating-price">
                                        300 ₽<span>700 ₽</span>
                                    </div>
                                </div>
                                <div class="appcel-in-cart">
                                    <div class="btn-appcel-cart">Добавить</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
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
</div>