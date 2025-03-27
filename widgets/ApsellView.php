<?php

namespace app\widgets;

use app\models\Product;
use Yii;
use yii\helpers\ArrayHelper;

class ApsellView extends \yii\bootstrap5\Widget
{
    /**
     * {@inheritdoc}
     */

    public $lang;
    public $title;

    public $cart = null;
    public function run()
    {
        $session = Yii::$app->session;
        $cart = $session->get("cart");
        $apsellProduct = Product::find()->where(["upsale" => "1"])->andWhere(['not in', 'id', array_keys($cart['data'])])->all();
        return $this->render('apsell-view', [
            'cart' => $cart,
            'apsellProduct' => $apsellProduct,
            'title' => $this->title,
            'lang' => $this->lang
        ]);
    }
}
