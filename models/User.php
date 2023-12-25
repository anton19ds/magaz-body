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

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $AuthAssignment = new AuthAssignment([
                'item_name' => 'user',
                'user_id' => strval($this->id),
            ]);
            $AuthAssignment->save();
            $newPromo = new PromoUser([
                'name' => substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 10).substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 10),
                'link' => '/',
                'user_id' => $this->id
            ]);
            $newPromo->save();
            $userLavel = new UserLavel([
                'user_id' => $this->id,
                'lavel_id' => Yii::$app->db->createCommand('SELECT `id` FROM `lavel` WHERE `main`=1')->queryOne()['id']
            ]);
            $userLavel->save();

            Yii::$app->db->createCommand()->batchInsert('promo_user_size', ['promo_user_id', 'category_promo_id', 'size', 'type'], [
                [$newPromo->id, 1, 3,  2],
                [$newPromo->id, 1, 10, 1],
                [$newPromo->id, 2, 10, 1],
                [$newPromo->id, 2, 3,  2],
            ])->execute();
        }
        parent::afterSave($insert, $changedAttributes);
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

    public function summOrder()
    {
        $model = $this->getOrders();
        $summ = 0;
        if ($model) {
            foreach ($model as $order) {
                $meta = $order->meta;
                if (!empty($meta->order_summ)) {
                    $summ += $meta->order_summ;
                }
            }
            return $summ;
        } else {
            return $summ;
        }

    }
    public function getLavel()
    {
        if (UserLavel::find()->where(['user_id' => $this->id])->exists()) {
            $lavelId = UserLavel::find()->where(['user_id' => $this->id])->one();
            return Lavel::find()->where(['id' => $lavelId->lavel_id])->one();
        } else {
            return Lavel::find()->where(['main' => '1'])->one();
        }
    }

    public function getCategoryLavel()
    {
        return CategoryLavel::find()->where(['lavel_id' => $this->lavel->id])->all();
    }

    public function getPromo()
    {
        return PromoUser::find()->where(['user_id' => $this->id])->all();
    }

    public function updateUser($user){
        $this->firstName = $user['name'];
        $this->LastName = $user['lastname'];
        $this->secondName = $user['surname'];
        $this->phone = $user['phone'];
        $this->save(false);
        return $this->id;
    }

                    
                    
                    
                    
}

// [user] => Array
                
