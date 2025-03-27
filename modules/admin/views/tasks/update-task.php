<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

?>
<div class="row">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-header">
                <div class="card-title">Редактирование Задания</div>
            </div>
            <div class="card-body">
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
                    <?php if(isset($model->summ)):?>
                    <?= $form->field($model, 'summ') ?>
                    <?php endif;?>
                    <?php if(isset($model->status)):?>
                    <?= $form->field($model, 'status') ?>
                    <?php endif;?>
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- sete-tasks -->