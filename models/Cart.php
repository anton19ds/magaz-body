<?php

namespace app\models;

class Cart extends \yii\base\BaseObject
{

    const TYPE_RUSS = 'russ';
    const TYPE_SNG = 'sng';
    const TYPE_EMS = 'ems';

    

    public static function getLabelType()
    {
        return [
            self::TYPE_RUSS => 'По России',
            self::TYPE_EMS => 'EMS',
            self::TYPE_SNG => 'Страны Балтии и СНГ',
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

    public static function type($id){
        $type = ProductMeta::find()->where(['meta' => 'type'])->andWhere(['product_id' => $id])->asArray()->one();
        return $type['value'];
    }

    public static function updateCartPromocode($cart, $promocode = null){
        if(!empty($promocode)){
            $promoUser = PromoUser::find()
            ->where(['name' => $promocode])
            ->with('userLavel')
            ->with('promoUserSize')
            ->asArray()
            ->one();
            $setData = array();
            foreach($promoUser['promoUserSize'] as $item){
                $categoryPromo = CategoryPromo::find()->where(['id' => $item['category_promo_id']])->asArray()->one();
                $setData[$categoryPromo['name']][$item['type']] = $item['size'];
            }
        }
        
        // 
        $totalData = [];
        $salePrice = 0; //стоймость всех товаров
        $saleSizePrice = 0; //размер скидки
        $totalPrice = 0; //стоймость товаров со скидкой
        $saleCash = 0; // Общий размер вознаграждения
        $count = 0; //количестов

        foreach($cart as &$elem){
            if(!empty($promocode)){
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
            }else{
                $elem['productSize'] = [
                    'totalPrice' => $elem['price'] * $elem['count'], //стоймость группы товаров без скидки
                ];
                $count = $count + $elem['count'];
                $salePrice = $salePrice + $elem['productSize']['totalPrice'];
            }
            
        }
        $totalData = [
            'salePrice' => $salePrice,
            'saleSizePrice' => $saleSizePrice,
            'totalPrice' => $totalPrice,
            'saleCash' => $saleCash,
            'count' => $count,
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