<?php

namespace app\widgets;

use app\models\Currencies;
use app\models\Product;
use Yii;
use yii\helpers\ArrayHelper;

class CyrList extends \yii\bootstrap5\Widget
{
    /**
     * {@inheritdoc}
     */

    public function run()
    {
        $model = Currencies::find()->asArray()->all();
        $request = Yii::$app->request->get();
        return $this->render('cyr-list', [
            'request' => $request,
            'model' => $model
        ]);
    }
}
