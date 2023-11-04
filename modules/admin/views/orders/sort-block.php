<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>




<?php
$form = ActiveForm::begin([
  'method' => 'get',
])
?>
<div class="row mb-5">
<div class="col-md-3 mb-2">
<?= Html::textInput('id', '', ['class' => 'form-control', 'placeholder' => 'Номер заказа'])?>
</div>
<div class="col-md-3 mb-2">
<?= Html::textInput('user', '', ['class' => 'form-control', 'placeholder' => 'Покупатель'])?>
</div>
<div class="col-md-3 mb-2">
<?= Html::textInput('product', '', ['class' => 'form-control','placeholder' => 'Товар'])?>
</div>
<div class="col-md-3 mb-2">
<?= Html::textInput('status', '', ['class' => 'form-control','placeholder' => 'Статус'])?>
</div>
<div class="col-md-3 mb-2">
<?= Html::textInput('summ-min', '', ['class' => 'form-control', 'placeholder' => 'Минимальная сумма заказа'])?>
</div>
<div class="col-md-3 mb-2">
<?= Html::textInput('summ-max', '', ['class' => 'form-control', 'placeholder' => 'Максимальная сумма заказа'])?>
</div>
<div class="col-md-3 mb-2">
<?= Html::textInput('summ-max', '', ['class' => 'form-control', 'placeholder' => 'Дата заказа'])?>
</div>
<div class="col-md-3 mb-2">
<?= Html::textInput('summ-max', '', ['class' => 'form-control', 'placeholder' => 'Валюта'])?>
</div>
<div class="col-md-3 mb-2">
<?= Html::textInput('summ-max', '', ['class' => 'form-control', 'placeholder' => 'Тип оплаты'])?>
</div>
<div class="col-md-12 mt-3">
<?= Html::submitButton('Поиск',['class' => 'btn btn-success'])?>
<?= Html::a('Сбросить', '/admin/orders', ['class' => 'btn btn-info', 'style' => 'margin-left:5px']);?>
</div>
</div>
<?php ActiveForm::end();?>
