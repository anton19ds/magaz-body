<?php

use app\models\CategoryLavel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Category Lavels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-lavel-index">


    <p>
        <?= Html::a('Create Category Lavel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'attribute' => 'category_promo_id',
                'value' => function($model){
                    return $model->categoryPromo->name;
                }
            ],

            [
                'attribute' => 'lavel_id',
                'value' => function($model){
                    return $model->lavel->name;
                }
            ],
            
            'size',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CategoryLavel $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
