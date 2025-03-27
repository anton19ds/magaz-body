<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */

class YandexPay extends Model
{
    public static function senRequest($orderId){
        $array = [
            "currencyCode"=>"RUB",
            "orderId"=>$orderId,
            "redirectUrls"=> [
                "onAbort"=>"https://anticandida.com/ru",
                "onError"=>"https://anticandida.com/ru",
                "onSuccess"=>"https://anticandida.com/ru"
            ],
            "cart" => [
                "externalId"=>$orderId,
                "items"=>[
                    [
                        "productId"=>"qwe123",
                        "quantity"=> [
                            "count"=>"123.45"
                        ],
                        "title"=>"asd",
                        "total"=>"123.45"
                    ]
                ],
            "total"=> [
                "amount"=> "123.45"
                ]
            ],    
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://sandbox.pay.yandex.ru/api/merchant/v1/orders',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($array),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Api-Key '.Yii::app()->params['yandex-merchat'],
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }
}