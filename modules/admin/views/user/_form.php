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
<?php $model->userLavel ?>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="orders-form">
        <div class="row">
            <div class="col-md-12">
                <div class="card full-height">
                    <div class="card-header">
                        <div class="card-title">
                            <?= date("Y-m-d H:s", $model->date); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                
                                <div class="col-md-6">
                                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'active')->textInput() ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'password')->textInput() ?>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?= $this->render('promocode-setting',[
                                    'lavel' => $model->userLavel,

                                ])?>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>