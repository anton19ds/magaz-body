<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CategoryPromo $model */

$this->title = 'Update Category Promo: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Category Promos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-promo-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
