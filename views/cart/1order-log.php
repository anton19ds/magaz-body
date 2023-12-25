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