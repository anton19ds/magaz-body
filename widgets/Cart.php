<?php

namespace app\widgets;

use app\models\Product;
use app\models\PromoUser;
use Yii;

class Cart extends \yii\bootstrap5\Widget
{

    public $lang;

    public function run()
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        return $this->render('cart', [
            'cart' => $cart,
            'lang' => $this->lang,
        ]);
    }

    
}