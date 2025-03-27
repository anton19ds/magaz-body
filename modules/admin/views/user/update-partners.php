<?php

use app\models\OrdersMeta;
use app\models\PromoUserSize;
use app\models\UserAdress;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput() ?>
   
    <?php ActiveForm::end();?>