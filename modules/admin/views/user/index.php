<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'email:email',
                        [
                            'attribute' => '',
                            'format' => 'raw',
                            'value' => function ($model) {
                                                return $model->firstName . " " . $model->LastName . " " . $model->secondName;
                                            }
                        ],
                        //'firstName',
                        //'LastName',
                        //'secondName',
                        'phone',
                        'date:date',
                        [
                            'attribute' => 'Все заказы',
                            'format' => 'raw',
                            'value' => function ($model) {
                                                return $model->summOrder();
                                            }
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{update} {delete}',
                            'urlCreator' => function ($action, User $model, $key, $index, $column) {
                                                return Url::toRoute([$action, 'id' => $model->id]);
                                            }
                        ],
                        'active',
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>