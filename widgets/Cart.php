<?php

namespace app\widgets;

use app\models\Product;
use Yii;

class Cart extends \yii\bootstrap5\Widget
{

    public $lang;
    public function run()
    {
        return $this->render('cart', [
            'lang' => $this->lang
        ]);
    }
}