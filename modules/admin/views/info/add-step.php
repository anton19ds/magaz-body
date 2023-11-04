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
                <div class="row">
                    <div class="col-md-12">
                        <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <?php echo Yii::$app->session->getFlash('success'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">
                            # Номер статьи для инфокурса
                        </label>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Обложка этапа</label>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'img')->textInput()->label(false) ?>
                            </div>
                            <div class="col-md-6">
                                <span class="open-image btn btn-success">Добавить обложку</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'title')->textInput()->label('Наименование этапа курса ') ?>
                    </div>
                    <div class="col-md-8">
                        <?= $form->field($model, 'content')->textInput(['placeholder' => 'Номер статьи'])->label(false) ?>
                    </div>
                    <div class="col-md-4">
                        <a href="" class="btn btn-warning success-articles">Проверить</a>

                    </div>
                </div>
                <?= Html::submitButton('Сохранить', ['id' => 'btnStepAdd', 'class' => 'btn btn-info', "disabled" => "disabled"]) ?>
                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <?= Html::a('Добавить новую', '/admin/info/add-step?id=' . $id, ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Назад', '/admin/info/index', ['class' => 'btn btn-success']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<?php $this->registerJs('
$(".success-articles").on("click", function(e){
  e.preventDefault();
  var id = $("#infostep-content").val();
  ArticlesGet(id);
});

function ArticlesGet(id){
  $.post("/admin/info/articles-success", {id: id}, function Success(data){
    if(data == "ok"){
      $("#infostep-content").removeClass("is-invalid");
      $("#infostep-content").addClass("is-valid");
      $("#btnStepAdd").attr("disabled", false);
    }else{
      $("#infostep-content").removeClass("is-valid");
      $("#infostep-content").addClass("is-invalid");
      $("#btnStepAdd").attr("disabled", true);
    }
    console.log(data);
  });
}
') ?>
<!-- alert(id);
  $.ajax({
    url: "http://body-dev.na4u.ru/api/v1/success",
    type: "post",
    data: {
      "id": id
    },
    headers: {
        "Apikey": "yii2-magaz-hash"
    },
    dataType: "json",
    success: function (data) {
        console.info(data);
    }
}); -->