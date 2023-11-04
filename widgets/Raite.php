<?php

namespace app\widgets;

use app\models\Product;
use Yii;

class Raite extends \yii\bootstrap5\Widget
{

    public $id;
    public function run()
    {
        $model = Product::findOne($this->id);
        return $this->render("raite", [
            "model"=> $model
        ]);
    }
}