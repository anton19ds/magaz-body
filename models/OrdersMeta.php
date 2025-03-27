<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders_meta".
 *
 * @property int $id
 * @property int $order_id
 * @property string $shiping_type
 * @property string $payment_type
 * @property string $order_summ
 * @property int $adress_shipig
 * @property string|null $promocode
 */
class OrdersMeta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const CDEK = 'cdek';
    const POCHTA = 'pochta';

    const RUSS = 'russ';
    const EMS = 'ems';
    const SNG = 'sng';
    const CS = 'cs';
    const EURO = 'euro';
    const INFO = 'info';

    public static function getLabelStatus()
    {
        return [
            self::CDEK => 'CDEK',
            self::POCHTA => 'Почта России',
            self::RUSS => 'по России',
            self::EMS => 'EMS',
            self::SNG => 'Доставка по СНГ',
            self::CS => 'Доставка по Чехии',
            self::EURO => 'Доставка по Евросоюзу',
            self::INFO => 'Доставка Инфокурса',

        ];
    }

    const Inteleckt = 'inteleckt';
    const CARD = 'card';
    const YMONEY = 'ymoney';
    const TRISBY = 'trisby';


    const Inteleckt_MESS = 'inteleckt-mess';
    const CARD_MESS = 'card-mess';
    const YMONEY_MESS = 'ymoney-mess';
    const TRISBY_MESS = 'trisby-mess';

    public static function getLabelShiping()
    {
        return [
            self::Inteleckt_MESS => 'Intellect Money',
            self::CARD_MESS => 'Переводом на карту',
            self::YMONEY_MESS => 'Ю.Money',
            self::TRISBY_MESS => 'Trisbee',
        ];
    }

    public static function getLabelShipingSet(){
        
    }

    public static function getLabelPayDesc()
    {
        return [
            self::Inteleckt => 'Intellect Money',
            self::CARD => 'Ручной перевод на карту банка',
            self::YMONEY => 'Ю.Money',
            self::TRISBY => 'Trisbee',
        ];
    }


    public static function tableName()
    {
        return 'orders_meta';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'shiping_type', 'payment_type', 'adress_shipig'], 'required'],
            [['order_id', 'adress_shipig', 'promocode', 'coupon', 'shiping_summ'], 'integer'],
            [['shiping_type', 'payment_type', 'insurance', 'coupon_name'], 'string', 'max' => 255],
            [['order_summ'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'shiping_type' => 'Доставка',
            'payment_type' => 'Оплата',
            'order_summ' => 'Сумма оплаты',
            'adress_shipig' => 'Адресс доставки',
            'promocode' => 'Promocode',
            'insurance' => 'Страховка',
            'coupon' => 'Купон',
            'shiping_summ' => 'Стоймость доставки'
        ];
    }

    public function getAdress()
    {
        $userAdress = UserAdress::findOne($this->adress_shipig);
        if($userAdress){
            return $userAdress;
        }
        return false;
    }

    public function getUserAdress(){
        return $this->hasOne(UserAdress::class, ['id' => 'adress_shipig']);
    }

    public function getPromocod(){
        return $this->hasOne(Promocod::class, ['coupon' => 'id']);
    }

    public function getPromoUser(){
        return $this->hasOne(PromoUser::class, ['id' => 'promocode']);
    }

    public function getOrders(){
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }

    public function getStatus(){
        return $this->hasOne(OrderStatus::class, ['order_id' => 'order_id']);
    }
}
