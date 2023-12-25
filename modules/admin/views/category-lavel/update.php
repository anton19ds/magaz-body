<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CategoryLavel $model */

$this->title = 'Update Category Lavel: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Category Lavels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-lavel-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
