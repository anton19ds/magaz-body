<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Lavel $model */

$this->title = 'Create Lavel';
$this->params['breadcrumbs'][] = ['label' => 'Lavels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lavel-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
