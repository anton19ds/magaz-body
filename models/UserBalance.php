<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_balance".
 *
 * @property int $id
 * @property int $user_id
 * @property float $summ
 * @property string $type
 * @property string $date
 */
class UserBalance extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_REFILL = 'refill';
    const STATUS_DEBIT = 'debit';

    public static function getLabelStatus()
    {
        return [
            self::STATUS_REFILL => 'пополнение счета',
            self::STATUS_DEBIT => 'списание средств',
        ];
    }
    public static function tableName()
    {
        return 'user_balance';
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'summ', 'type'], 'required'],
            [['user_id', 'order_id'], 'integer'],
            [['summ'], 'number'],
            [['type', 'date', 'cyrrency', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'summ' => 'Сумма начисления',
            'type' => 'Тип операции',
            'date' => 'Дата',
            'order_id' => 'Номер заказа',
            'data' => 'Текст сообщения',
            'link' => 'Контактные данные',
            'status' => 'Статус операции'

        ];
    }

    public function getOrders()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }
}
