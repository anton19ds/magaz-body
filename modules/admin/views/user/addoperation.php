<?php
use app\models\UserBalance;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($userBalanse, 'summ')->textInput(['type' => 'number', 'max' => $balanceUser, 'min' => 0]) ?>
    <?= $form->field($userBalanse, 'type')->dropDownList(
        UserBalance::getLabelStatus()
    ) ?>
    <?= $form->field($userBalanse, 'order_id')->textInput(['value' => 0]) ?>
    <?= $form->field($userBalanse, 'user_id')->hiddenInput(['value' => $user_id])->label(false) ?>
    <?= $form->field($userBalanse, 'data') ?>
    <?= $form->field($userBalanse, 'link') ?>
    <?= $form->field($userBalanse, 'status')->dropDownList([
        0 => 'В обработке',
        1 => 'Обработано'
    ]) ?>
    <?= $form->field($userBalanse, 'cyrrency')->textInput(['value' => 'ru']) ?>
    
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>