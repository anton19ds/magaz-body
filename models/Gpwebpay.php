<?php

namespace app\models;
use Yii;
class Gpwebpay extends \yii\base\BaseObject
{
    public static function genLink($totalSumm){   
        $orderId = rand(0, 99) . rand(0, 99);
        $price = $totalSumm * 100;
        $currency = 203;
        $flag = 1;
        $merchantId = Yii::$app->params['gpbwebpay-merchat'];
        $opeation = "CREATE_ORDER";
        $url = "https://frame.anticandida.com/cs/sets-data";
        $signCode = $merchantId . "|" . $opeation . "|" . $orderId . "|" . $price . "|" . $currency . "|" . $flag . "|".$url;
        $paymuzo = "https://3dsecure.gpwebpay.com/pgw/order.do";
        $get = "";
        $get .= "&CURRENCY=$currency";
        $get = "MERCHANTNUMBER=" . urlencode(trim($merchantId)) . "&OPERATION=$opeation&ORDERNUMBER=" . urlencode($orderId)
            . "&AMOUNT=" . trim($price) . "&DEPOSITFLAG=$flag";
        if (isset($currency) && trim($currency) != "") {
            $get .= "&CURRENCY=$currency";
        }
        
        $get .= "&URL=" . urlencode($url);
        $split = explode("|", $paymuzo, 2);
        if (sizeof($split) >= 1) {
            $paymuzo = $split[0];
        }
        $get .= "&DIGEST=" . urlencode(self::setData($signCode));
        $path = $paymuzo . "?" . $get;
        return $path;
    }

    private static function setData($text)
    {
        $privateKey = __DIR__ . '/../web/sert/gpwebpay-pvk.key';

        $privateKeyPassword = 'Ac777apa.';
        $fp = fopen($privateKey, "r");
        $privateKeyd = fread($fp, filesize($privateKey));
        fclose($fp);
        $pkeyid = openssl_get_privatekey($privateKeyd, $privateKeyPassword);
        openssl_sign($text, $signature, $pkeyid);
        $signature = base64_encode($signature);
        return $signature;
    }


    
}