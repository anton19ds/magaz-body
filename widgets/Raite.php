<?php

namespace app\widgets;

use app\models\Product;
use app\models\Reviews;
use Yii;
use yii\helpers\ArrayHelper;

class Raite extends \yii\bootstrap5\Widget
{

    public $id;

    public $view = false;

    public $front = false;

    public function run()
    {
        $model = Product::findOne($this->id);
        $raite = Reviews::find()->where(['product_id' => $this->id])->andWhere(['status' => '2'])->asArray()->all();
        $grade = 5;
        if(!empty($raite)){
            $gradeArray = ArrayHelper::getColumn($raite, 'star');
            $grade = array_sum($gradeArray) / count($gradeArray);
        }
        return $this->render("raite", [
            "model"=> $model,
            "view"=> $this->view,
            "raite" => $raite,
            'front' => $this->front,
            'grade' => $grade
        ]);
    }
}