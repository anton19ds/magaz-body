<?php
namespace app\widgets;
use app\models\User;
use Yii;

class OrderId extends \yii\bootstrap5\Widget
{
    public $order_id = false;

    public function run()
    {
        return $this->order_id;
    }
}
