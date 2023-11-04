<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Promocod $model */

$this->title = 'Update Promocod: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Promocods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="promocod-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
