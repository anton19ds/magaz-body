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
        $product = '';
        if(isset($cart['data'])){
            $productList = array_keys($cart['data']);
        $product = Product::find()->where(['id' => $productList])->all();
    }
        return $this->render('cart', [
            'cart' => $cart,
            'lang' => $this->lang,
            'product' => $product
        ]);
        
        
    }

    
}