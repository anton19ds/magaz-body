<?php

namespace app\widgets;

use app\models\Currencies;
use Yii;

class Curren extends \yii\bootstrap5\Widget
{
    public function run()
    {
        $model = Currencies::find()->asArray()->all();
        return $this->render('curren',[
            'model' => $model
        ]);
    }
}
