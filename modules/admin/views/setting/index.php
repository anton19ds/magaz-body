<?php
use yii\bootstrap5\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-body">
                    <?php $form = ActiveForm::begin() ?>
                    <div class="row">
                        <?php foreach ($data as $key => $value): ?>
                            <div class="col-md-6 mt-2">
                                <label for="<?= $key ?>">
                                    <?= $value ?>
                                </label>
                                <?= Html::textInput('Data[' . $key . ']', ($settingData[$key] ? $settingData[$key] : ''), ['id' => $key, 'class' => 'form-control', 'placeholder' => $value]) ?>
                            </div>
                        <?php endforeach; ?>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        
                        <?php foreach ($delivery as $key => $value): ?>
                            <div class="col-md-7 mt-2">
                                <label for="<?= $key ?>">
                                    <?= $value ?>
                                </label>
                                <?= Html::textInput('Data[' . $key . ']', ($settingData[$key] ? $settingData[$key] : ''), ['id' => $key, 'class' => 'form-control', 'placeholder' => $value]) ?>
                            </div>
                            <div class="col-md-4">
                            <?php foreach($langData as $el => $it):?>
                                <label for=""></label>
                                <?= Html::checkbox('Data[del-data][' . $key . ']['.strtoupper($it).']', (isset($resViewDelivery[$key][strtoupper($it)]) && $resViewDelivery[$key][strtoupper($it)] == 1 ? true : false), ['label' => strtoupper($it),  'uncheck' => '0']) ?>
                            <?php endforeach;?>
                            </div>
                        <?php endforeach; ?>
                        <?php foreach ($langSet as $key => $value): ?>
                            <?php foreach($field as $el => $item):?>
                            <div class="col-md-7 mt-2">
                                <label for="<?= $value ?>">
                                    <?= $value ?>
                                    <?= $item ?>
                                    
                                </label>
                                <?= Html::textInput("Seo[{$value}][{$el}]", $SeoDataArray[$value][$el], ['class' => 'form-control']) ?>
                            </div>
                            <?php endforeach;?>
                        <?php endforeach; ?>



                        <div class="col-md-12 mt-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <strong>Главный баннер</strong>
                                </div>
                                <div class="col-md-6">
                                    <?= Html::textInput('Data[main-banner]', (isset($settingData['main-banner']) ? $settingData['main-banner'] : ''), ['id' => 'main-banner', 'class' => 'form-control', 'placeholder' => 'Баннер на главной странице']) ?>
                                </div>
                                <div class="col-md-6">
                                    <span class="banner-image btn btn-success">Добавить изображение</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <strong>Логотип</strong>
                                </div>
                                <div class="col-md-6">
                                    <?= Html::textInput('Data[logo]', (isset($settingData['logo']) ? $settingData['logo'] : ''), ['id' => 'logo', 'class' => 'form-control', 'placeholder' => 'Логотип']) ?>
                                </div>
                                <div class="col-md-6">
                                    <span class="logo-image btn btn-success">Добавить изображение</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <strong>Телеграмм</strong>
                                </div>
                                <div class="col-md-12">

                                    <?= Html::textInput('Data[telegram]', (isset($settingData['telegram']) ? $settingData['telegram'] : ''), ['class' => 'form-control', 'placeholder' => 'Телеграмм Бот']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <strong>Email Dev</strong>
                                </div>
                                <div class="col-md-12">

                                    <?= Html::textInput('Data[email-dev]', (isset($settingData['email-dev']) ? $settingData['email-dev'] : ''), ['class' => 'form-control', 'placeholder' => 'Email Dev']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
        <div class="col-md-1 mt-3 mb-3">
            <div class="row">
                <?= Html::a('Добавить','/admin/setting/add-user-tel',['class' => 'btn btn-success'])?>
            </div>
        </div>    
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'chat_id',
                    //'date:date',
                    'comment',
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{update} {delete}',
                        'urlCreator' => function ($action, $model, $key, $index, $column) {
                                        return Url::toRoute([$action."-tel", 'id' => $model->id]);
                                    }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>