<?php

use app\models\Promocod;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Promocod $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card full-height">
            <div class="card-header">
                <div class="card-title">Добавление нового промокода</div>
            </div>
            <div class="card-body">
                <?= $form->field($model, 'size')->textInput() ?>
                <?= $form->field($model, 'active')->dropDownList(Promocod::getLabelStatus(), ['prompt' => '']) ?>
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>