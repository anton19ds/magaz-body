<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_active_promo".
 *
 * @property int $id
 * @property int $user_id
 * @property int $promo_id
 * @property string|null $date
 */
class UserActivePromo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_active_promo';
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
            [['user_id', 'promo_id'], 'required'],
            [['user_id', 'promo_id'], 'integer'],
            [['date'], 'string', 'max' => 255],
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
            'promo_id' => 'Promo ID',
            'date' => 'Date',
        ];
    }

    public function getPromo()
    {
        return $this->hasOne(PromoUser::class, ['id' => 'promo_id']);
    }
}
