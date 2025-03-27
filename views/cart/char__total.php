<?php

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
}
?>
<?= number_format(($price * $cart['data'][$item->id]['count']), 0, '', ' ') ?> <?= Yii::t('app', 'currency-symbol') ?>