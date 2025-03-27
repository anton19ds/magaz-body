<?php
namespace app\models;
use Yii;

class Cart extends \yii\base\BaseObject
{
    private static $instance;
    const TYPE_RUSS = 'russ';
    const TYPE_SNG = 'sng';
    const TYPE_EMS = 'ems';
    const TYPE_CS = 'cs';
    const TYPE_EURO = 'euro';
    const TYPE_INFO = 'info';

    public $ourCartSumm;
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct()
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        if (isset($cart['totalData']['totalPrice']) && $cart['totalData']['totalPrice'] != 0) {
            $this->ourCartSumm = $cart['totalData']['totalPrice'];
        } else {
            $this->ourCartSumm = $cart['totalData']['salePrice'];
        }
    }

    public static function checkInfocurs($id)
    {
        $product = Product::findOne($id);
        if (!Yii::$app->user->isGuest) {
            if (AccessInfoProduct::find()->where(['product_id' => $id])->andWhere(['user_id' => Yii::$app->user->identity->id])->exists()) {
                return true;
            }
        }
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        if ($product->getType() == 'info' && isset($cart['data'][$id])) {
            return true;
        }
        return false;
    }

    public static function PromocodeSizeSale($cart, $product, $lang, $promocode = null, $view = null)
    {
        if($promocode){
            $promoUser = PromoUser::find()->where(['id' => $promocode])->one();
        }else{
            $promoUser = PromoUser::find()->where(['name' => $cart['promocode']])->one();
        }
        $promoSize = PromoUserSize::find()->where(['promo_user_id' => $promoUser->id])->andWhere(['type' => PromoUserSize::SALE])->asArray()->all();
        $arraData = [];
        foreach ($promoSize as $size) {
            $arraData[$size['category_promo_id']] = $size['size'];
        }
        $ourSumm = 0;
        foreach ($product as $item) {
            $priceData = Product::getPriceProductbyId($item->id, $lang);
            $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
            
            $coutn = $cart['data'][$item->id]['count'];
            //return debug($priceData);
            if($coutn == 2){
                if(isset($priceData['productPac']['pricePac-2']['sale']) && $priceData['productPac']['pricePac-2']['sale']){
                    $price = $priceData['productPac']['pricePac-2']['sale'];
                }elseif(isset($priceData['productPac']['pricePac-2']['prise']) && $priceData['productPac']['pricePac-2']['prise']){
                    $price = $priceData['productPac']['pricePac-2']['prise'];
                }
            }elseif($coutn >= 3){
                if(isset($priceData['productPac']['pricePac-3']['sale']) && $priceData['productPac']['pricePac-3']['sale']){
                    $price = $priceData['productPac']['pricePac-3']['sale'];
                }elseif(isset($priceData['productPac']['pricePac-3']['prise']) && $priceData['productPac']['pricePac-3']['prise']){
                    $price = $priceData['productPac']['pricePac-3']['prise'];
                }
            }
            $type = $item->type;
            if ($type == 'info') {
                //$arraData['2']
                $ourSumm = $ourSumm + round(($price * $cart['data'][$item->id]['count'] / 100 * $arraData['2']));
            }else if($type == 'made' || $type == 'simple'){
                $ourSumm = $ourSumm + round(($price * $cart['data'][$item->id]['count'] / 100 * $arraData['1']));
            }else if($type == 'data'){
                $ourSumm = $ourSumm + round(($price * $cart['data'][$item->id]['count'] / 100 * $arraData['3']));
            }
        } 
        if($view){
            return $ourSumm;
        }else{
            return number_format($ourSumm, 0, '', ' ')  . " " . Yii::t('app', 'currency-symbol');
        }
    }

    public static function totalSummProduct($cart, $product, $lang)
    {
        $ourSumm = 0;
        foreach ($product as $item) {

            $priceData = Product::getPriceProductbyId($item->id, $lang);

            if($cart['data'][$item->id]['count'] == 1){
                if(isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-1']['sale']) && $priceData['productPac']['pricePac-1']['sale']){
                    $price = $priceData['productPac']['pricePac-1']['sale'];
                }else{
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            }else if($cart['data'][$item->id]['count'] == 2){
                if(isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-2']['sale']) && $priceData['productPac']['pricePac-2']['sale']){
                    $price = $priceData['productPac']['pricePac-2']['sale'];
                }else{
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            }else if($cart['data'][$item->id]['count'] >= 3){
                if(isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-3']['sale']) && $priceData['productPac']['pricePac-3']['sale']){
                    $price = $priceData['productPac']['pricePac-3']['sale'];
                }else{
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            }else{
                $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
            }
            $ourSumm = $ourSumm + ($price * (isset($cart['data'][$item->id]['count']) && $cart['data'][$item->id]['count'] >= 1 ? $cart['data'][$item->id]['count'] : 1));
        }
        return number_format($ourSumm, 0, '', ' ') . " " . Yii::t('app', 'currency-symbol');
    }
    public static function totalSumm(
        $cart,
        $product,
        $lang,
        $coupon = null,
        $promocode = null,
        $delivery = null,
        //$inshure = null,
        $view = null,
        $order_id = null,
        $poctcode = null
        )
    {
        $ourSumm = 0;
        foreach ($product as $item) {
            $priceData = Product::getPriceProductbyId($item->id, $lang);
            $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
            if($cart['data'][$item->id]['count'] == 1){
                if(isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-1']['sale']) && $priceData['productPac']['pricePac-1']['sale']){
                    $price = $priceData['productPac']['pricePac-1']['sale'];
                }else{
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            }else if($cart['data'][$item->id]['count'] == 2){
                if(isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-2']['sale']) && $priceData['productPac']['pricePac-2']['sale']){
                    $price = $priceData['productPac']['pricePac-2']['sale'];
                }else{
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            }else if($cart['data'][$item->id]['count'] >= 3){
                if(isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-3']['sale']) && $priceData['productPac']['pricePac-3']['sale']){
                    $price = $priceData['productPac']['pricePac-3']['sale'];
                }else{
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            }else{
                $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
            }
            if (isset($cart['promocode']) || $promocode) {
                if(isset($cart['promocode'])){
                    $promoUser = PromoUser::find()->where(['name' => $cart['promocode']])->one();
                }else{
                    $promoUser = PromoUser::find()->where(['id' => $promocode])->one();
                }
                $promoSize = PromoUserSize::find()->where(['promo_user_id' => $promoUser->id])->andWhere(['type' => PromoUserSize::SALE])->asArray()->all();
                $arraData = [];
                foreach ($promoSize as $size) {
                    $arraData[$size['category_promo_id']] = $size['size'];
                }
                $type = $item->type;
                if ($type == 'info') {
                    $ourSumm = $ourSumm + ($price * $cart['data'][$item->id]['count']) - round(($price * $cart['data'][$item->id]['count']) / 100 * $arraData['2']);
                } else if ($type == 'simple') {
                    $ourSumm = $ourSumm + ($price * $cart['data'][$item->id]['count']) - round(($price * $cart['data'][$item->id]['count']) / 100 * $arraData['1']);
                }else if($type == 'made'){
                    $ourSumm = $ourSumm + (($price * $cart['data'][$item->id]['count'])) - round(($price * $cart['data'][$item->id]['count']) / 100 * $arraData['1']);
                }else if($type == 'data'){
                        $ourSumm = $ourSumm + (($price * $cart['data'][$item->id]['count'])) - round(($price * $cart['data'][$item->id]['count']) / 100 * $arraData['3']);
                }else{
                    $ourSumm = $ourSumm + ($price * $cart['data'][$item->id]['count']);    
                }

            } else {
                $ourSumm = $ourSumm + ($price * $cart['data'][$item->id]['count']);
            }
        }

         if((isset($cart['coupon']) && !empty($cart['coupon'])) || $coupon){
            $setSize = Promocod::getSize($cart, $lang, $coupon);
            if(str_contains($setSize, '%')){
                $ourSumm = $ourSumm - round($ourSumm / 100 * str_replace("%","",Promocod::getSize($cart, $lang, $coupon)));
            }else{
                $ourSumm = $ourSumm - Promocod::getSize($cart, $lang, $coupon);
            }
             
         }
        $postcode = null;
        if( isset($cart['delivery']) && !empty($cart['delivery']) && $cart['delivery'] != 'info'){
            if(isset($cart['user']['activeAdress']) && !empty($cart['user']['activeAdress'])){
                $userAdress = UserAdress::find()->where(['id' => $cart['user']['activeAdress']])->asArray()->one();
                if($userAdress){
                    $postcode = $userAdress['postcode'];
                }
            }
            if(!$postcode && $poctcode){
                $postcode = $poctcode;
            }
            $ourSumm = Delivery::getInstance()->getDelSumm($cart['delivery'], $lang, $postcode) + $ourSumm;
        }else if($delivery){
            if(!$postcode && $poctcode){
                $postcode = $poctcode;
            }
            $ourSumm = Delivery::getInstance()->getDelSumm($delivery, $lang, $postcode) + $ourSumm;
        }
        $ourSumm = Insurance::getInstance()->getSumm($lang, $product, $order_id) + $ourSumm;
        if($view){
            return $ourSumm;    
        }else{
            return number_format($ourSumm, 0, ',',' ') . " " . Yii::t('app', 'currency-symbol');
        }
    }


    public function getOurSummCart($lang = null)
    {
        $coupon = 0;
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        if (Promocod::getSize($cart, $lang)) {
            $coupon = Promocod::getSize($cart, $lang);
        }
        $summ = Insurance::getInstance()->getSumm($lang) + $this->ourCartSumm - $coupon;
        return $summ;
    }


    public static function getLabelType()
    {
        return [
            self::TYPE_RUSS => 'По России',
            self::TYPE_EMS => 'EMS',
            self::TYPE_SNG => 'Страны Балтии и СНГ',
            self::TYPE_CS => 'Доставка по Чехии',
            self::TYPE_EURO => 'Доставка по Евросоюзу',
            self::TYPE_INFO => 'Доставка инфокурса',
        ];
    }


    public static function getSummType()
    {
        return [
            self::TYPE_RUSS => 100,
            self::TYPE_EMS => 500,
            self::TYPE_SNG => 1200,
            self::TYPE_EURO => 750,
            self::TYPE_CS => 1050,
            self::TYPE_INFO => 0,
        ];
    }


    const Inteleckt = 'inteleckt';
    const CARD = 'card';
    const YMONEY = 'ymoney';
    const TRISBY = 'trisby';

    public static function getLabelShiping()
    {
        return [
            self::Inteleckt => 'Intelleckt Money',
            self::CARD => 'Переводом на карту',
            self::YMONEY => 'Ю.Money',
            self::TRISBY => 'TRISBY',
        ];
    }

    public static function getName($id, $lang)
    {
        if ($lang == 'ru' || empty($lang)) {
            $name = ProductMeta::find()->where(['meta' => 'productName'])->andWhere(['product_id' => $id])->asArray()->one();
        } else {
            $name = ProductMetaLang::find()->where(['meta' => 'productName'])->andWhere(['product_id' => $id, 'tag' => $lang])->asArray()->one();
        }
        return $name['value'];
    }


    public static function getPhoto($id)
    {
        $image = ProductMeta::find()->where(['meta' => 'image'])->andWhere(['product_id' => $id])->asArray()->one();
        $photo = '/adminStyle/assets/img/no-image.png';
        if (!empty($image)) {
            $data = json_decode($image['value'], true);
            if (!empty($data['array'])) {
                $photo = $data['array'][array_key_first($data['array'])]['value'];
            }
        }
        return $photo;
    }


    public static function saleSize($arrayPromo, $item)
    {
        $userLavel = CategoryLavel::find()
            ->leftJoin('user_lavel', 'user_lavel.lavel_id=category_lavel.lavel_id')
            ->where(['user_lavel.user_id' => $arrayPromo['user']])
            ->asArray()
            ->all();
        $promoData = array();
        foreach ($userLavel as $size) {
            $promoData['saleSize'] = $size['size'] / 2;
            $saleSumm = $item['price'] - ($item['price'] / 100 * $size['size'] / 2);
            $promoData['sale'] = round($saleSumm);
        }
        return $promoData;
    }


    public static function type($id)
    {
        $type = ProductMeta::find()->where(['meta' => 'type'])->andWhere(['product_id' => $id])->asArray()->one();
        return $type['value'];
    }


    public static function updateCartPromocode($cart, $promocode = null)
    {
        if (!empty($promocode)) {
            $promoUser = PromoUser::find()
                ->where(['name' => $promocode])
                ->with('userLavel')
                ->with('promoUserSize')
                ->asArray()
                ->one();
            $setData = array();
            foreach ($promoUser['promoUserSize'] as $item) {
                $categoryPromo = CategoryPromo::find()->where(['id' => $item['category_promo_id']])->asArray()->one();
                $setData[$categoryPromo['name']][$item['type']] = $item['size'];
            }
        }

        $totalData = [];
        $salePrice = 0;
        $saleSizePrice = 0;
        $totalPrice = 0;
        $saleCash = 0;
        $count = 0;

        foreach ($cart as &$elem) {
            if (!empty($promocode)) {
                $elem['productSize'] = [
                    'saleSize' => $setData[$elem['type']]['2'], //размер скидки в процентах
                    'salePrice' => self::calcPercent($elem['price'], $setData[$elem['type']]['2']) * $elem['count'], //размер скидки
                    'saleSizePrice' => $elem['price'] - self::calcPercent($elem['price'], $setData[$elem['type']]['2']), // стоймость товара со скидкой
                    'totalSale' => ($elem['price'] - self::calcPercent($elem['price'], $setData[$elem['type']]['2'])) * $elem['count'], //стоймость группы товаров со скидкой
                    'totalPrice' => $elem['price'] * $elem['count'], //стоймость группы товаров без скидки
                    'saleCash' => self::calcPercent($elem['price'], $setData[$elem['type']]['1']) * $elem['count'], // размер вознаграждения
                ];
                $count = $count + $elem['count'];
                $salePrice = $salePrice + $elem['productSize']['totalPrice'];
                $saleSizePrice = $saleSizePrice + $elem['productSize']['salePrice'];
                $totalPrice = $totalPrice + $elem['productSize']['totalSale'];
                $saleCash = $saleCash + $elem['productSize']['saleCash'];
            } else {
                $elem['productSize'] = [
                    'totalPrice' => $elem['price'] * $elem['count'], //стоймость группы товаров без скидки
                ];
                $count = $count + $elem['count'];
                $salePrice = $salePrice + $elem['productSize']['totalPrice'];
            }

        }
        $summInsurance = 0;
        $session = Yii::$app->session;
        $dataCart = $session->get('cart');
        if (isset($dataCart['insurance']) && $dataCart['insurance']) {
            foreach ($cart as $val) {
                if ($val['type'] == 'simple') {
                    $summInsurance = $summInsurance + ($val['count'] * 300);
                }
            }
        }
        $totalData = [
            'salePrice' => $salePrice,
            'saleSizePrice' => $saleSizePrice,
            'totalPrice' => $totalPrice,
            'saleCash' => $saleCash,
            'count' => $count,
            'summInsurance' => $summInsurance
        ];
        return [
            'cart' => $cart,
            'totalData' => $totalData
        ];
    }

    public static function calcPercent($price, $percent)
    {
        return $price * ($percent / 100);
    }

}