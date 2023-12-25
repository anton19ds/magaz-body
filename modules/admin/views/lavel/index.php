<?php

use app\models\Lavel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lavels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lavel-index">

    <p>
        <?= Html::a('Create Lavel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'date:date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Lavel $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
