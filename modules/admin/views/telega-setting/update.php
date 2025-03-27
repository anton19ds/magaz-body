<?php
use app\models\TelegramMessageUser;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Настройка сообшений телеграм';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'send-form-telega'
                ]); ?>
                    <?= $form->field($model, 'content')->textarea(['value' => htmlspecialchars($model->content, ENT_HTML5), 'rows' => '6'])?>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->registerJs('
// $("#send-form-telega button").on("click", function(e){
//     e.preventDefault();
//     var data = $("#content-message").html();
//     console.log(data);
//     alert(data);
// });
');

?>