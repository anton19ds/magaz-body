<?php

namespace app\widgets;

use app\models\Product;
use Yii;
use yii\helpers\ArrayHelper;

class ApsellCart extends \yii\bootstrap5\Widget
{
    /**
     * {@inheritdoc}
     */

    public $lang;
    public $title;
    public function run()
    {
        $session = Yii::$app->session;
        $cart = $session->get("cart");
        //debug($cart);
        $apsellProduct = Product::find()->where(["upsale" => "1"])->all();
        if(!empty($cart) && isset($cart['data'])){
            $idList = array_keys($cart['data']);
            //debug($idList);
            $apsellProduct = Product::find()->where(["upsale" => "1"])->andWhere(['not in', 'id', $idList])->all();
        }
        return $this->render('apsell-cart', [
            'cart' => $cart,
            'apsellProduct' => $apsellProduct,
            'title' => $this->title,
            'lang' => $this->lang
        ]);
    }
}
