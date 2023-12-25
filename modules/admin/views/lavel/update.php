<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Lavel $model */

$this->title = 'Update Lavel: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Lavels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lavel-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
