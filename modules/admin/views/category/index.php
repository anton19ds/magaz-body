<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categories';
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
                        'title',
                        'date:date',
                        [
                            'attribute' => 'active',
                            'value' => function($model){
                                if($model->active == '1'){
                                    return 'Включен';
                                }else{
                                    return 'Отключен';
                                }
                            }
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{update} {delete}',
                            'urlCreator' => function ($action, Category $model, $key, $index, $column) {
                                                return Url::toRoute([$action, 'id' => $model->id]);
                                            }
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>