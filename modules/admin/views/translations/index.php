<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="row" id="tableTransList">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                <table>
                    <?php foreach ($param as $item): ?>
                        <tr>
                            <td>
                                <?= $item; ?>
                            </td>
                            <?php foreach ($currens as $elem): ?>
                                <td><input type="text" value="<?php if(isset($arrayDataTran[$item][$elem])){ echo $arrayDataTran[$item][$elem];} ?>"
                                        name="data[<?= $item; ?>][<?= $elem; ?>]" class="form-control"
                                        placeholder="<?= $elem; ?>">
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <br>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>