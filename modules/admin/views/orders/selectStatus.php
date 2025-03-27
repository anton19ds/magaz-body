<?php

use app\models\OrderStatus;
use yii\helpers\Html;

?>
<?php
echo Html::dropDownList('status', $model->getStatus(), OrderStatus::getLabelStatus(), ['data-id' => $model->id, 'class' => 'selected-status form-control ' . $model->getStatus()])
  ?>


<style>
  option {
    padding: 5px 15px;
  }

  select {
    color: #fff;
  }

  select.pay {
    background-color: #eeee22;
    color: #fff;
    font-weight: bold;
  }

  select.close {
    background-color: #00d627;
    color: #fff;
    font-weight: bold;
  }
  select.failed,
  select.return {
    background-color: #dd3333;
    color: #fff;
    font-weight: bold;
  }

  select.new {
    background-color: #4397d8;
    color: #fff;
    font-weight: bold;
  }

  .selected-status.form-control {
    height: 35px !important;
    padding: 0 10px;
  }
</style>