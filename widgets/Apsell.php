<?php

namespace app\widgets;

use app\models\Product;
use Yii;

class Apsell extends \yii\bootstrap5\Widget
{
    /**
     * {@inheritdoc}
     */

    public $lang;
    public $title;
    public function run()
    {
        $apsellProduct = Product::find()->where(["upsale" => "1"])->all();
        return $this->render('apsell', [
            'apsellProduct' => $apsellProduct,
            'title' => $this->title,
            'lang' => $this->lang
        ]);
    }
}
