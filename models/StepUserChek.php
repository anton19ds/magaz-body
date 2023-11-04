<?php

namespace app\models;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "step_user_chek".
 *
 * @property int $id
 * @property int $user_id
 * @property int $step_id
 */
class StepUserChek extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'step_user_chek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'step_id'], 'required'],
            [['user_id', 'step_id'], 'integer'],
            [['date'], 'string', 'max' => 255]
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'step_id' => 'Step ID',
        ];
    }
}
