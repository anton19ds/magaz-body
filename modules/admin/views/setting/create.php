<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="row">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <div class="category-form">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'chat_id')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'comment')->textInput() ?>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>