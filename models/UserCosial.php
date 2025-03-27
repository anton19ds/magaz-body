<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_cosial".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $inst
 * @property string|null $vk
 * @property string|null $fb
 * @property string|null $wa
 * @property string|null $tg
 */
class UserCosial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_cosial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['inst', 'vk', 'fb', 'wa', 'tg'], 'string', 'max' => 255],
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
            'inst' => 'Inst',
            'vk' => 'Vk',
            'fb' => 'Fb',
            'wa' => 'Wa',
            'tg' => 'Tg',
        ];
    }
}
