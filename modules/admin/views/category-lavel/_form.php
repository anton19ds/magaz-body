<?php

use app\models\CategoryLavel;
use app\models\CategoryPromo;
use app\models\Lavel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CategoryLavel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-lavel-form">
<?php $dataArray = ArrayHelper::getColumn(CategoryLavel::find()->asArray()->all(), 'category_promo_id');

?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_promo_id')->dropDownList(ArrayHelper::map(CategoryPromo::find()->asArray()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'lavel_id')->dropDownList(ArrayHelper::map(Lavel::find()->asArray()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
