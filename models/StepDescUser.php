<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class StepDescUser extends ActiveRecord
{
    
    public static function tableName()
    {
        return 'step_desc_user';
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

    public function rules()
    {
        return [
            [['user_id', 'step_id', 'status'], 'required'],
            [['user_id', 'step_id', 'status'], 'integer'],
            [['date'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'user_id',
            'step_id' => 'step_id',
            'status' => 'status',
            'date' => 'date'
        ];
    }
}