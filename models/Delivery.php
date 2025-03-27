<?php
namespace app\models;

use Yii;
use yii\httpclient\Client;

class Delivery extends \yii\base\BaseObject
{
    private static $instance;

    public $russ;

    public $ems;

    public $sng;

    public $cs;
    public $info;
    public $euro;

    public function __construct()
    {
        $russ = SettingData::find()->where(['meta' => 'russ'])->one();
        if ($russ && $russ->value) {
            $this->russ = $russ->value;
        }
        $ems = SettingData::find()->where(['meta' => 'ems'])->one();
        if ($ems && $ems->value) {
            $this->ems = $ems->value;
        }
        $sng = SettingData::find()->where(['meta' => 'sng'])->one();
        if ($sng && $sng->value) {
            $this->sng = $sng->value;
        }
        $cs = SettingData::find()->where(['meta' => 'cs'])->one();
        if ($cs && $cs->value) {
            $this->cs = $cs->value;
        }
        $euro = SettingData::find()->where(['meta' => 'euro'])->one();
        if ($euro && $euro->value) {
            $this->euro = $euro->value;
        }
        $info = SettingData::find()->where(['meta' => 'info'])->one();
        if ($info && $info->value) {
            $this->info = $info->value;
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getDelSumm($type, $lang, $postcode = null)
    {
        if($type == 'russ'){
            $client = new Client();
        $response = $client->createRequest()
        ->setMethod('get')
        ->setUrl('https://tariff.pochta.ru/v2/calculate/tariff')
        ->setData([
        'object'=>27030,
        'from'=>236016,
        'to'=>$postcode,
        'weight'=>250,
        'pack'=>11,
        'return'=>236016,
        'date'=>date('Ymd'),
        'time'=>date('Hs')
        ])
        ->send();
        if ($response->isOk) {
            //debug();
            return  round($response->data['paymoney']/100);
        }else{
            if ($lang && Currencies::find()->where(['tag' => $lang])->exists()) {
                $currencies = Currencies::find()->where(['tag' => $lang])->one();
                return round($this->$type * $currencies->code);
            }
        }
        }else{
            if ($lang && Currencies::find()->where(['tag' => $lang])->exists()) {
                $currencies = Currencies::find()->where(['tag' => $lang])->one();
                return round($this->$type * $currencies->code);
            }
        }
        
        return $this->$type;
    }
}