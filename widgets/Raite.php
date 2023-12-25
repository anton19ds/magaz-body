<?php

namespace app\widgets;

use app\models\Product;
use app\models\Reviews;
use Yii;

class Raite extends \yii\bootstrap5\Widget
{

    public $id;

    public $view = false;

    public function run()
    {

        $model = Product::findOne($this->id);
        $raite = Reviews::find()->where(['product_id' => $this->id])->asArray()->all();
        return $this->render("raite", [
            "model"=> $model,
            "view"=> $this->view,
            "raite" => $raite
        ]);
    }
}