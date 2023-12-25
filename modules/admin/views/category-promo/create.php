<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CategoryPromo $model */

$this->title = 'Create Category Promo';
$this->params['breadcrumbs'][] = ['label' => 'Category Promos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-promo-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
