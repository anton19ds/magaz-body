<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class TelegramMessageUser extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_message_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['type', 'lang'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'content' => 'Контент',
            'type' => 'Тип',
            'lang' => 'Язык',
        ];
    }
}