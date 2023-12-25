<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_lavel".
 *
 * @property int $id
 * @property int $user_id
 * @property int $lavel_id
 */
class UserLavel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_lavel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'lavel_id'], 'required'],
            [['user_id', 'lavel_id'], 'integer'],
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
            'lavel_id' => 'Lavel ID',
        ];
    }
}
