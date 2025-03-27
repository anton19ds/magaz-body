<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_data".
 *
 * @property int $id
 * @property string|null $data
 */
class PaymentData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'string'],
            [['order_id'], 'integer'],
            [['statys', 'paymentId'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
        ];
    }
}
