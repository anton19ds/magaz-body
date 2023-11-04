<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="site-login">
  <div class="container">
    <?php $form = ActiveForm::begin([
      'id' => 'login-form',
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'rePass')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>
    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    <?php ActiveForm::end(); ?>
  </div>
</div>