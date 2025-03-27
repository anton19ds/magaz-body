<?php

use app\models\Product;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="row" id="tableProductList">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'title')->textInput() ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Обложка этапа</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'img')->textInput()->label(false) ?>
                    </div>
                    <div class="col-md-6">
                        <span class="open-image btn btn-success">Добавить обложку</span>
                    </div>
                </div>
                <?= Html::submitButton('Сохранить и Добавить новый', ['class' => 'btn btn-info']) ?>
                <?= $form->field($model, 'infoproduct_id')->hiddenInput(['value' => $id])->label(false) ?>
                <?= $form->field($model, 'tag')->hiddenInput(['value' => $tag])->label(false) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>