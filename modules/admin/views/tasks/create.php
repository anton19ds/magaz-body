<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tasks $model */
/** @var ActiveForm $form */
?>
<div class="sete-tasks">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name') ?>
    <?php echo $form->field($model, 'text')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
        ],
    ]);
    ?>
    <?= $form->field($model, 'summ') ?>
    <?= $form->field($model, 'status') ?>
    <?php ActiveForm::end(); ?>
</div><!-- sete-tasks -->