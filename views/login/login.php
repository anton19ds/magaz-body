<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="page-magazin">
    <div class="action_login">

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>
        <div class="titleLog"><?php
        echo \Yii::t('app', 'aut');
        ?></div>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Email') ?>
        <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\" custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ])->label('Запомнить меня') ?>
                </div>
                <div class="col-md-12">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-login', 'name' => 'login-button']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="action_register">
        <div id="input_email_reg">
            <div class="titleLog">
                Регистрация
            </div>
            <div class="mb-3 row field-loginform-username required">
                <label class="col-lg-1 col-form-label mr-lg-3" for="regEmail">Email</label>
                <input type="text" id="regEmail" class="col-lg-3 form-control" name="username"
                    autofocus="" aria-required="true" aria-invalid="true">
            </div>
            <p class="sup">На ваш почтовый адрес будет отправлен пароль.
                Ваши личные данные будут использоваться для упрощения вашей работы с сайтом, управления доступом к вашей
                учетной записи и для других целей, описанных в нашей политике конфиденциальности.
            </p>
            <a href="#" class="btn-reg">Регистрация</a>
            <div class="data_user_con">
            <label for="">Чат с администратором</label>
            <ul>
                <li><a href=""><img src="/icon/facebook.svg" /></a></li>
                <li><a href=""><img src="/icon/Group.svg" /></a></li>
                <li><a href=""><img src="/icon/odnoklassniki 2.svg" /></a></li>
                <li><a href=""><img src="/icon/vk.svg" /></a></li>
            </ul>
        </div>
        </div>
    </div>
</div>