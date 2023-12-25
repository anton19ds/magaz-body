<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "promo_user".
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property int $user_id
 * @property string|null $data_created
 * @property string|null $data_updated
 */
class PromoUser extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promo_user';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['data_created'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['data_updated'],
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
            [['name', 'link', 'user_id'], 'required'],
            [['user_id', 'active'], 'integer'],
            [['name', 'link', 'data_created', 'data_updated'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'link' => 'Link',
            'user_id' => 'User ID',
            'data_created' => 'Data Created',
            'data_updated' => 'Data Updated',
        ];
    }

    public function getPromoUserSize()
    {
        return $this->hasMany(PromoUserSize::class, ['promo_user_id' => 'id']);
    }

    public function getUserLavel(){
        return $this->hasOne(UserLavel::class, ['user_id' => 'user_id']);
    }
}
