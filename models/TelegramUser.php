<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "telegram_user".
 *
 * @property int $id
 * @property string|null $chat_id
 * @property string|null $comment
 * @property string|null $date
 */
class TelegramUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id', 'comment', 'date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'comment' => 'Comment',
            'date' => 'Date',
        ];
    }
}
