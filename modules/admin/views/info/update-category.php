<?php

use app\models\Product;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="row" id="tableProductList">
    <div class="col-md-9">
        <div class="card full-height">
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'title')->textInput() ?>
                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="control-label">Обложка этапа</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <?= $form->field($model, 'img')->textInput()->label(false) ?>
                            </div>
                            <div class="col-md-6">
                                <span class="open-image btn btn-success">Добавить обложку</span>
                            </div>
                        </div>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?php if(!empty($model->img)):?>
            <?php try{
                $image = json_decode($model->img, true);
                if(isset($image['array']) && !empty($image['array'])){
                    echo "<img style='width:100%' src='".$image['array']['1']['value']."'>";
                }
            }catch(Exception $e){

            }?>
        <?php endif;?>
    </div>
</div>