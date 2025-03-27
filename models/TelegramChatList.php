<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "telegram_chat_list".
 *
 * @property int $id
 * @property int $chat
 * @property string|null $name
 * @property string|null $lang
 * @property string|null $description
 * @property string|null $date
 */
class TelegramChatList extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_chat_list';
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
    // public function beforeSave($insert)
    // {
    //     $this->user_id = Yii::$app->user->identity->id;
    //     return parent::beforeSave($insert);

    // }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat'], 'required'],
            [['chat', 'user_id'], 'integer'],
            [['name', 'lang', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat' => 'Chat',
            'name' => 'Name',
            'lang' => 'Lang',
            'description' => 'Description',
            'date' => 'Date',
        ];
    }
}
