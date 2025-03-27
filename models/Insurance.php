<?php
namespace app\models;
use Yii;
class Insurance extends \yii\base\BaseObject
{
    private static $instance;

    public $insuranceSale;

    public $insurance;

    public function __construct()
    {
        $insurance = SettingData::find()->where(['meta' => 'insurance'])->one();
        if ($insurance && $insurance->value) {
            $this->insurance = $insurance->value;
        }
        $insuranceSale = SettingData::find()->where(['meta' => 'insuranceSale'])->one();
        if ($insuranceSale && $insuranceSale->value) {
            $this->insuranceSale = $insuranceSale->value;
        }

    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getSize($lang = null)
    {
        if ($lang && Currencies::find()->where(['tag' => $lang])->exists()) {
            $currencies = Currencies::find()->where(['tag' => $lang])->one();
            if (!empty($this->insuranceSale)) {
                return round($this->insuranceSale * $currencies->code);
            } else {
                return round($this->instance * $currencies->code);
            }
        }
        if (!empty($this->insuranceSale)) {
            return $this->insuranceSale;
        } else {
            return $this->instance;
        }
    }

    public function getSumm($lang = null, $product = null, $order_id = null){
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        $result = 0;
        if(isset($cart['insurance']) && $cart['insurance']){
            foreach($product as $item){
                $type = $item->getParam('type', null);
                if($type == 'simple' || $type == 'made'){
                    $result = $result + ($cart['data'][$item->id]['count']*$this->getSize($lang));
                }
            }
        }else if(!empty($order_id && OrdersMeta::find()->where(['order_id'=>$order_id])->andWhere(['insurance' => '1'])->exists())){
            $order = Orders::findOne($order_id);
            $orderData = unserialize($order->data_order);
            $product = Product::find()->where(['id' => array_keys($orderData)])->all();
            foreach($product as $item){
                $type = $item->getParam('type', null);
                if($type == 'simple' || $type == 'made'){
                    $result = $result + ($orderData[$item->id]['count']*$this->getSize($lang));
                }
            }
        }
        return $result;
    }

    
}