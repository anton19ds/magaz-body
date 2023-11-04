<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

?>
<div id="user_page">
    <div class="left_block">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'data-user'
        ]) ?>

    </div>
    <div class="right_block">
    <div class="breadcrambs">
            <ul>
                <li><a href="">Магазин</a></li>
                <li><a href="">Личный данные</a></li>
            </ul>
        </div>
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-info alert-dismissible" role="alert" style="color:#4d4949">
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif; ?>
        <div class="block-title-page">
            Личный данные
        </div>
        <ul class="user_data">
            <li>
                <span>Имя</span>
                <span>
                    <?= $user->firstName; ?>
                    <?= $user->LastName; ?>
                    <?= $user->secondName; ?>
                </span>
            </li>
            <li>
                <span>Email</span>
                <span>
                    <?= $user->email; ?>
                </span>
            </li>
            <li>
                <span>
                    Телефон
                </span>
                <span>
                    <?= $user->phone; ?>
                </span>
            </li>
            <li>
                <span>
                    Дата регистрации
                </span>
                <span>
                    <?= date('Y-m-d', $user->date); ?>
                </span>
            </li>
            <li>
                <span>
                    Пароль
                </span>
                <span>
                    <a href="#" class="newPassGen"> Задать новый пароль</a>
                </span>
            </li>
        </ul>
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



<?php Modal::begin([
    'id' => 'new-pass',
]) ?>
<?php $form = ActiveForm::begin() ?>
<?php echo $form->field($user, 'password')->passwordInput(['value' => ''])->label('Новый пароль') ?>
<?php echo $form->field($user, 'rePass')->passwordInput()->label('Повторить пароль') ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-info', 'style' => 'color: #fff']) ?>
<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>