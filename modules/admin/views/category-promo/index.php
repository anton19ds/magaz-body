<?php

use app\models\CategoryPromo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Category Promos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-promo-index">

    <p>
        <?= Html::a('Create Category Promo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'date:date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CategoryPromo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
