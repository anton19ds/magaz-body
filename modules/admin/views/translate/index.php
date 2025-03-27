<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-header">
                <div class="card-title">Переводы</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2 mb-2"><strong>Title</strong></div>
                            <div class="col-md-3 mb-2"><strong>RU</strong></div>
                            <div class="col-md-3 mb-2"><strong>CS</strong></div>
                            <div class="col-md-3 mb-2"><strong>EN</strong></div>
                        </div>
                    </div>
                    <?php $i = 1;?>
                    <?php foreach ($arrRu as $key => $item): ?>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2 mb-1">
                                    <label class="control-label" for="product-<?= $key ?>">
                                    <?= $i?> )   <?= $key ?>
                                    </label>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <input type="text" name="ru[<?= $key ?>]" value="<?= htmlspecialchars($item) ?>" class="form-control">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <input type="text" name="cs[<?= $key ?>]" value="<?= (isset($arrCs[$key]) ? htmlspecialchars($arrCs[$key]) : "") ?>" class="form-control">
                                </div>
                                <div class="col-md-3 mb-1">
                                    <input type="text" name="en[<?= $key ?>]" value="<?= (isset($arrEn[$key]) ? htmlspecialchars($arrEn[$key]) : "") ?>" class="form-control">
                                </div>
                                
                            </div>
                        </div>
                        <?php $i++?>
                    <?php endforeach; ?>
                    <div class="col-md-12">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>