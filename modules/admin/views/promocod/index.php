<?php

use app\models\Promocod;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Promocods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'promocode',
                        'date',
                        'size',
                        'active',
                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, Promocod $model, $key, $index, $column) {
                                                return Url::toRoute([$action, 'id' => $model->id]);
                                            }
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>