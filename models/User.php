<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $authKey
 * @property string|null $accessToken
 * @property string $email
 * @property string|null $firstName
 * @property string|null $LastName
 * @property string|null $secondName
 * @property string|null $phone
 * @property string $date
 * @property int $active
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */

    public $rePass;
    public $rememberMe;

    public $group;

    /**
     * Class constructor.
     */
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

    public function beforeSave($insert)
    {
        $this->username = $this->email;
        return parent::beforeSave($insert);
    }


    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'email'], 'required'],
            [['active'], 'integer'],
            [['userGroup', 'username', 'password', 'authKey', 'accessToken', 'email', 'firstName', 'LastName', 'secondName', 'phone'], 'string', 'max' => 255],
            [['phone', 'email'], 'unique', 'targetAttribute' => ['phone', 'email']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Пароль',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'email' => 'Email',
            'firstName' => 'Имя',
            'LastName' => 'Фамилия',
            'secondName' => 'Отчество',
            'phone' => 'Телефон',
            'date' => 'Дата',
            'rePass' => 'Пароль',
            'active' => 'Статус',
        ];
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['id' => (string) $token->getClaim('uid')])->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function getOrders()
    {
        $orders = Orders::find()->where(['user_id' => $this->id])->all();
        return $orders;
    }
    public function getUserAdress()
    {
        return $this->hasMany(UserAdress::className(), ['user_id' => 'id']);
    }

    public function savePhone($phone)
    {
        if ($this->phone != $phone) {
            $this->phone = $phone;
            $this->save();
        }

    }

    public function getInfocurs()
    {
        return AccessInfoProduct::find()->where(['user_id' => $this->id])->all();
    }

    public function summOrder(){
        $model = $this->getOrders();
        $summ  = 0;
        if($model){
            foreach ($model as $order){
                $meta = $order->meta;
                $summ += $meta->order_summ;
            }
            return $summ;
        }else{
            return $summ;
        }
        
    }

    
}
