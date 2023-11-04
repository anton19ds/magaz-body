<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PaymentType $model */

$this->title = 'Create Payment Type';
$this->params['breadcrumbs'][] = ['label' => 'Payment Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
