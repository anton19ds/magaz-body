<?php

use app\models\Currencies;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Валюты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currencies-index">
    <div class="row">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-header">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'id',
                                'name',
                                'tag',
                                'code',
                                'status',
                                [
                                    'class' => ActionColumn::className(),
                                    'urlCreator' => function ($action, Currencies $model, $key, $index, $column) {
                                        return Url::toRoute([$action, 'id' => $model->id]);
                                                            }
                                ],
                            ],
                        ]); ?>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>