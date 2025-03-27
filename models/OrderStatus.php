<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "order_status".
 *
 * @property int $id
 * @property int $order_id
 * @property string $status
 * @property string $data_update
 * @property string $data_created
 */
class OrderStatus extends ActiveRecord
{
    /**
     * {@inheritdoc}
     * 
     */

    const STATUS_NEW = 'new';
    const STATUS_PAY = 'pay';
    const STATUS_CLOSE = 'close';
    const STATUS_RETURN = 'return';
    const STATUS_FAILED = 'failed';


  public static function getLabelStatus()
  {
    return [
      self::STATUS_NEW => '1. В ожидании оплаты',
      self::STATUS_PAY => '2. Передан на упаковку (оплачен)',
      self::STATUS_CLOSE => '3. Сделка завершена (успешно)',
      self::STATUS_RETURN => '4. Отменен',
      self::STATUS_FAILED => '5. Возврат'
    ];
  }


  public function behaviors()
  {
    return [
      'timestamp' => [
        'class' => 'yii\behaviors\TimestampBehavior',
        'attributes' => [
          ActiveRecord::EVENT_BEFORE_INSERT => ['data_created', 'data_update'],
          ActiveRecord::EVENT_BEFORE_UPDATE => ['data_update'],
        ],
      ],
    ];
  }
 
    public static function tableName()
    {
        return 'order_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'status'], 'required'],
            [['order_id'], 'integer'],
            [['status'], 'string', 'max' => 255],
            [['data_update', 'data_created'], 'safe']
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
            'status' => 'Status',
            'data_update' => 'Data Update',
            'data_created' => 'Data Created',
        ];
    }

    public static function UpdateStatus($order_id){
      $model = self::find()->where(['order_id' => $order_id])->one();
      if($model){
        $model->status = self::STATUS_PAY;
        $model->save();
      }
    }
}
