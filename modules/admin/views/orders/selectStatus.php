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
  select{
    color: #fff;
  }
  select.pay {
    background-color: green;
  }

  select.new {
    background-color: blue;
  }

  option[value=pay] {
    background-color: green;
    color: #fff;
  }
</style>