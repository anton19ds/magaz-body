<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CategoryLavel $model */

$this->title = 'Create Category Lavel';
$this->params['breadcrumbs'][] = ['label' => 'Category Lavels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-lavel-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
