<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use vova07\imperavi\Widget;

?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'title')->textInput() ?>
                <?php echo $form->field($model, 'content')->widget(Widget::className(), [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 200,
                        'plugins' => [
                            'clips',
                        ],
                        'clips' => 
                            $arrrayTemplate,
                    ],
                ]);
                ?>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
                <?php
                
                    if($lang && $lang != 'ru'){
                        $link = "/admin/mail/send-test?id={$model->id}&lang={$lang}";
                    }else{
                        $link = "/admin/mail/send-test?id={$model->id}";
                    }
                ?>
                <?= Html::a('Тестовая отправка',$link, ['class' => 'btn btn-info']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>