<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $data_order
 * @property int $user_id
 * @property string $date
 */
class Orders extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                ],
            ],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $order_Status = new OrderStatus([
                'order_id' => $this->id,
                'status' => OrderStatus::STATUS_NEW
            ]);
            $order_Status->save();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_order', 'user_id'], 'required'],
            [['data_order', 'uuid', 'cyrrency'], 'string'],
            [['user_id'], 'integer'],
            [['uuid'], 'unique',],
            [['date'], 'string', 'max' => 255],
            [['del_track'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data_order' => 'Данные заказа',
            'user_id' => 'Пользователь',
            'uuid' => 'uuid',
            'date' => 'Дата заказа',
            'del_track' => 'Трек номер доставки'
        ];
    }

    public function getMeta()
    {
        return OrdersMeta::find()->where(['order_id' => $this->id])->one();
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function dataOrder()
    {
        if (!empty($this->data_order)) {
            return unserialize($this->data_order);
        }
        return null;
    }

    public function dataPrice()
    {
        if ($this->dataOrder()) {
            $orderArray = $this->dataOrder();

            $summ = 0;
            foreach ($orderArray as $item) {
                $summ = $summ + ($item['price'] * $item['count']);
            }
            return $summ;
        }
        return null;

    }

    public function dataCurrensy()
    {
        if ($this->dataOrder()) {
            $orderArray = $this->dataOrder();

            $symbol = '';
            foreach ($orderArray as $item) {
                $symbol = $item['symbol'];
            }
            return $symbol;
        }
        return null;
    }

    public function getTovar()
    {
        if ($this->dataOrder()) {
            $tovarList = Product::find()->where(['id' => ArrayHelper::getColumn($this->dataOrder(), 'id')])->all();
            return $tovarList;
        }
        return null;
    }


    public function getStatus()
    {
        $status = OrderStatus::find()->where(['order_id' => $this->id])->one();
        if (!$status) {
            return OrderStatus::STATUS_NEW;
        } else {
            return $status->status;
        }
    }

    public function getStatusDate()
    {
        return $this->hasOne(OrderStatus::class, ['order_id' => 'id']);
    }

    public function Metas()
    {
        return OrdersMeta::find()->where(['order_id' => $this->id])->asArray()->one();
    }


    public function getOrdersUser()
    {
        return unserialize($this->data_order);

    }

    public function orderInfo()
    {
        $str = '';
        $count = 0;
        $summ = 0;
        $symbol = '';
        $meta = $this->Metas();
        $icon = '₽';

        $ourSumm = 0;
        $orderData = unserialize($this->data_order);
        $product = Product::find()->where(['id' => array_keys($orderData)])->all();

        foreach ($product as $item) {
            $priceData = Product::getPriceProductbyId($item->id, $this->cyrrency);
            $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
            $ourSumm = $ourSumm + ($price * $orderData[$item->id]['count']);
        }
        $curensy = Currencies::find()->where(['tag' => $this->cyrrency])->asArray()->one();
        if ($this->cyrrency != 'ru') {
            $icon = $curensy['icon'];
        }
        foreach (unserialize($this->data_order) as $item) {
            $count = $count + $item['count'];
            $symbol = $icon;
        }
        $str = number_format($ourSumm, 0, '', ' ') . " " . $icon . " " . "-" . " " . $count . " " . Yii::t('app', 'items');
        return $str;
    }

    public static function getTovarList($array)
    {

        $data = unserialize($array);

        $arrayId = ArrayHelper::getColumn($data, 'id');
        $model = Product::find()->where(['id' => $arrayId])->all();
        return $model;
    }

    public function getOrdersMeta()
    {
        return $this->hasOne(OrdersMeta::class, ['order_id' => 'id']);
    }

    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::class, ['order_id' => 'id']);
    }


    public function getOrderSumm($lang = null)
    {
        $ourSumm = 0;
        $ordersMeta = $this->ordersMeta;
        $data = unserialize($this->data_order);
        $product = Product::find()->where(['id' => array_keys($data)])->all();
        $ourSumm = 0;

        foreach ($product as $item) {
            $priceData = Product::getPriceProductbyId($item->id, $this->cyrrency);
            $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
            if ($data[$item->id]['count'] == 1) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-1']['sale']) && $priceData['productPac']['pricePac-1']['sale']) {
                    $price = $priceData['productPac']['pricePac-1']['sale'];
                    
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            } else if ($data[$item->id]['count'] == 2) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-2']['sale']) && $priceData['productPac']['pricePac-2']['sale']) {
                    $price = $priceData['productPac']['pricePac-2']['sale'];
                    
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                    
                }
            } else if ($data[$item->id]['count'] >= 3) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-3']['sale']) && $priceData['productPac']['pricePac-3']['sale']) {
                    $price = $priceData['productPac']['pricePac-3']['sale'];
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            } else {
                $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
            }



            if (isset($ordersMeta->promocode)) {
                $promoUser = PromoUser::find()->where(['id' => $ordersMeta->promocode])->one();
                $promoSize = PromoUserSize::find()->where(['promo_user_id' => $promoUser->id])->andWhere(['type' => PromoUserSize::SALE])->asArray()->all();
                $arraData = [];
                foreach ($promoSize as $size) {
                    $arraData[$size['category_promo_id']] = $size['size'];
                }
                $type = $item->type;
                if ($type == 'info') {
                    $ourSumm = $ourSumm + ($price * $data[$item->id]['count']) - round(($price * $data[$item->id]['count']) / 100 * $arraData['2']);
                    
                } else if ($type == 'simple') {
                    $ourSumm = $ourSumm + ($price * $data[$item->id]['count']) - round(($price * $data[$item->id]['count']) / 100 * $arraData['1']);
                    
                } else if ($type == 'made') {
                    $ourSumm = $ourSumm + (($price * $data[$item->id]['count'])) - round(($price * $data[$item->id]['count']) / 100 * $arraData['1']);
                    
                } else {
                    $ourSumm = $ourSumm + ($price * $data[$item->id]['count']);
                    
                }

            } else {
                $ourSumm = $ourSumm + ($price * $data[$item->id]['count']);
                
            }
        }
        if (isset($ordersMeta->coupon) && $ordersMeta->coupon) {
            
            $ourSumm = $ourSumm - Promocod::getSize(['data' => $data], $this->cyrrency, $ordersMeta->coupon);
        }
        

        if ($ordersMeta->shiping_type) {
            if(!empty($ordersMeta->shiping_summ) || $ordersMeta->shiping_summ == 0){
                $ourSumm = $ordersMeta->shiping_summ + $ourSumm;
            }else{
                $ourSumm = Delivery::getInstance()->getDelSumm($ordersMeta->shiping_type, $this->cyrrency) + $ourSumm;
            }
            
        }

        $ourSumm = Insurance::getInstance()->getSumm($lang, $product, $this->id) + $ourSumm;
        return $ourSumm;
    }

    public function getShipingSumm()
    {
        if ($this->ordersMeta->shiping_type == 'russ') {
            $ourSumm = Delivery::getInstance()->getDelSumm('russ', $this->cyrrency, $this->ordersMeta->userAdress->postcode);
            return $ourSumm;
        }
        if (SettingData::find()->where(['meta' => $this->ordersMeta->shiping_type])->exists()) {
            $summDell = SettingData::find()->where(['meta' => $this->ordersMeta->shiping_type])->asArray()->one();
            return $summDell['value'];
        }
        return 0;

    }

    public function Reward()
    {
        $meta = $this->ordersMeta;

        $promoUser = PromoUser::find()->where(['id' => $meta->promocode])->one();
        $arraData = [];
        if ($promoUser) {
            $promoSize = PromoUserSize::find()->where(['promo_user_id' => $promoUser->id])->andWhere(['type' => PromoUserSize::PRIM])->asArray()->all();
            foreach ($promoSize as $size) {
                $arraData[$size['category_promo_id']] = $size['size'];
            }
        }

        $data = unserialize($this->data_order);
        $product = Product::find()->where(['id' => array_keys($data)])->all();
        $ourSumm = 0;

        foreach ($product as $item) {
            $priceData = Product::getPriceProductbyId($item->id, $this->cyrrency);
            $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
            $coutn = $data[$item->id]['count'];
            if ($coutn == 2) {
                if (isset($priceData['productPac']['pricePac-2']['sale']) && $priceData['productPac']['pricePac-2']['sale']) {
                    $price = $priceData['productPac']['pricePac-2']['sale'];
                } elseif (isset($priceData['productPac']['pricePac-2']['prise']) && $priceData['productPac']['pricePac-2']['prise']) {
                    $price = $priceData['productPac']['pricePac-2']['prise'];
                }
            } elseif ($coutn >= 3) {
                if (isset($priceData['productPac']['pricePac-3']['sale']) && $priceData['productPac']['pricePac-3']['sale']) {
                    $price = $priceData['productPac']['pricePac-3']['sale'];
                } elseif (isset($priceData['productPac']['pricePac-3']['prise']) && $priceData['productPac']['pricePac-3']['prise']) {
                    $price = $priceData['productPac']['pricePac-3']['prise'];
                }
            }
            $type = $item->type;
            if (!empty($arraData)) {
                if ($type == 'info') {
                    $ourSumm = $ourSumm + round(($price * $data[$item->id]['count'] / 100 * $arraData['2']));
                } else if ($type == 'simple' || $type == 'made') {
                    $ourSumm = $ourSumm + round((($price * $data[$item->id]['count']) / 100 * $arraData['1']));
                } else if ($type == 'data') {
                    $ourSumm = $ourSumm + round(($price * $data[$item->id]['count'] / 100 * $arraData['3']));
                }
            }
        }
        return $ourSumm;
    }


    public function paymentDataNewOreder()
    {
        $model = PaymentData::find()
            ->where(['order_id' => $this->id])
            ->andWhere(['statys' => 3])
            ->andWhere(['not', ['paymentId' => null]])->one();
        if ($model) {
            return $model;
        }
        return $model;
    }


    public function productDiscountPromoCode($type, $prise){
        $resPrise = 0;
        if(PromoUser::find()->where(['id' => $this->ordersMeta->promocode])->exists()){
            $promoUser = PromoUserSize::find()->where(['promo_user_id' => $this->ordersMeta->promocode])->andWhere(['type' => 2])->asArray()->all();
            $newArray = ArrayHelper::map($promoUser, 'category_promo_id', 'size');
            if($type == 'made' || $type == 'simple'){
                $resPrise = $prise / 100 * $newArray[1];
            }
            if($type == 'info'){
                $resPrise = $prise / 100 * $newArray[2];
            }
            if($type == 'data'){
                $resPrise = $prise / 100 * $newArray[3];
            }
        }
        return $resPrise;
    }

}