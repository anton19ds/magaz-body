<?php

use app\models\InfoStep;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card full-height">
      <div class="card-body">
        <?= $form->field($model, 'content')->textInput() ?>
        <?= $form->field($model, 'type_step')->dropDownList(InfoStep::getLabelStatus()) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
      </div>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?> 