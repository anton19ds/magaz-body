<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_adress".
 *
 * @property int $id
 * @property string|null $postcode
 * @property string|null $city
 * @property string|null $country
 * @property int $user_id
 * @property string|null $area
 * @property string|null $flat
 * @property string|null $street
 */
class UserAdress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_adress';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['postcode', 'city', 'country', 'area', 'flat', 'street'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postcode' => 'Индекс',
            'city' => 'Город',
            'country' => 'Страна',
            'user_id' => 'User ID',
            'area' => 'Область',
            'flat' => 'Дом',
            'street' => 'Улица',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}