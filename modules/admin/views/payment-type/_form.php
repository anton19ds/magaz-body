<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PaymentType $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="row">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-header">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'descript')->textarea(['rows' => 6])->label('Текст описание') ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>