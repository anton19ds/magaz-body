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
            [['name', 'surname', 'lastname'], 'string', 'max' => 255],
            
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
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'lastname' => 'Отчество'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function updateAdress($adress, $user_id, $name = null)
    {
        $this->country = $adress['country'];
        $this->postcode = $adress['postcode'];
        $this->city = $adress['city'];
        $this->area = $adress['area'];
        $this->street = $adress['street'];
        $this->flat = $adress['house'];
        $this->user_id = $user_id;
        $this->name = (isset($name['name']) ? $name['name'] : null);
        $this->surname = (isset($name['surname']) ? $name['surname'] : null);
        $this->lastname = (isset($name['lastname']) ? $name['lastname'] : null);
        $this->save(false);
        return $this->id;
    }

    public static function getPostcodeUserAdress($id){
        $model = self::findOne($id);
        if($model){
            return $model->postcode;
        }
        return null;
        
    }
}


