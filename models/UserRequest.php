<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_request".
 *
 * @property int $id
 * @property int $user_id
 * @property string $text
 * @property int $type
 */
class UserRequest extends ActiveRecord
{
    const PROMOCODE = 1;

    const FEEDBACK = 2;

    public static function getType()
    {
        return [
            self::PROMOCODE => 'promocode',
            self::FEEDBACK => 'feedback'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_request';
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
            [['user_id', 'text', 'type'], 'required'],
            [['user_id', 'type', 'status'], 'integer'],
            [['text', 'date', 'subject', 'file', 'param'], 'string'],
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
            'text' => 'Сообщение',
            'type' => 'Тип',
            'status' => 'Статус',
            'date' => 'Дата'
            
        ];
    }

    public function getUser(){
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
