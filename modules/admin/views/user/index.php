<?php

use app\models\User;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\widgets\ActiveField;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="E-Mail" name="search-email" value="<?= $post?>">
                    </div>
                    <div class="col-md-1">
                        <?= Html::submitButton('Поиск', ['class' => 'btn btn-success']) ?>
                    </div>
                    <div class="col-md-1">
                        <?= Html::a('Сбросить', '/admin/user',['class' => 'btn btn-warning']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'columns' => require_once __DIR__ . '/columns/userColumns.php',
                    'beforeHeader' => [
                        [
                            'columns' => [
                                //['content'=>'Header Before 1', 'options'=>['colspan'=>4, 'class'=>'text-center warning']], 
                                //['content'=>'Header Before 2', 'options'=>['colspan'=>4, 'class'=>'text-center warning']], 
                                //['content'=>'Header Before 3', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
                            ],
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
                        [
                            'content' =>
                                Html::button('Добавить', ['type' => 'button', 'title' => 'Add Book', 'class' => 'btn btn-success', 'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");'])
                        ],
                    ],
                    'pjax' => true,
                    'pjaxSettings' => [
                        'neverTimeout' => true,
                        'options' => [
                            'id' => 'set-pajax-table'
                        ]
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    //'floatHeaderOptions' => ['top' => $scrollingTop],
                    'showPageSummary' => true,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>