<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "message_send_order".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $template_id
 * @property int $send
 * @property string|null $type
 * @property string|null $data
 */
class MessageSendOrder extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message_send_order';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['data'],
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
            [['order_id', 'template_id', 'send'], 'integer'],
            [['type', 'data'], 'string', 'max' => 255],
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
            'template_id' => 'Template ID',
            'send' => 'Send',
            'type' => 'Type',
            'data' => 'Data',
        ];
    }
}
