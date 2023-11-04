<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Promocod $model */

$this->title = 'Create Promocod';
$this->params['breadcrumbs'][] = ['label' => 'Promocods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promocod-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
