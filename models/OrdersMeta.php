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
    const EMS = 'ems';

    public static function getLabelStatus()
    {
        return [
            self::CDEK => 'CDEK',
            self::POCHTA => 'Почта России',
            self::EMS => 'EMS',

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
            [['order_id', 'adress_shipig', 'order_summ'], 'integer'],
            [['shiping_type', 'payment_type', 'promocode'], 'string', 'max' => 255],
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
}
