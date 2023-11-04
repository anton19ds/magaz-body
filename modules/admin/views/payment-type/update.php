<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PaymentType $model */

$this->title = 'Update Payment Type: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payment Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-type-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
