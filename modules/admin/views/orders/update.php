<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */

$this->title = 'Update Orders: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="orders-update">

    <?= $this->render('_form', [
        'product' => $product,
        'icon' => $icon,
        'dataOrder' => $dataOrder,
        'model' => $model,
        'dataProvider' => (isset($dataProvider) ? $dataProvider : null)
    ]) ?>

</div>