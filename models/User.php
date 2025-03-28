<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
class User extends ActiveRecord implements IdentityInterface
{
    public $rePass;
    public $rememberMe;
    public $group;

    public static function tableName()
    {
        return 'user';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class => [
                'class' => TimestampBehavior::class,
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
            $this->assignDefaultRole();
            $this->createDefaultPromo();
            $this->assignDefaultLavel();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    protected function assignDefaultRole()
    {
        $authAssignment = new AuthAssignment([
            'item_name' => 'user',
            'user_id' => (string)$this->id,
        ]);
        $authAssignment->save();
    }

    protected function createDefaultPromo()
    {
        $promo = new PromoUser([
            'name' => $this->generatePromoCode(),
            'link' => '/',
            'user_id' => $this->id,
            'lavel_id' => 1,
        ]);

        if ($promo->save()) {
            $this->insertDefaultPromoSizes($promo->id);
        }
    }

    protected function generatePromoCode()
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($chars), 0, 3) . substr(str_shuffle($chars), 0, 4);
    }

    protected function insertDefaultPromoSizes($promoUserId)
    {
        Yii::$app->db->createCommand()->batchInsert(
            'promo_user_size',
            ['promo_user_id', 'category_promo_id', 'size', 'type'],
            [
                [$promoUserId, 1, 3, 2],
                [$promoUserId, 1, 10, 1],
                [$promoUserId, 2, 10, 1],
                [$promoUserId, 2, 3, 2],
                [$promoUserId, 3, 10, 1],
                [$promoUserId, 3, 3, 2],
            ]
        )->execute();
    }

    protected function assignDefaultLavel()
    {
        $mainLavel = Yii::$app->db->createCommand('SELECT `id` FROM `lavel` WHERE `main`=1')->queryOne();
        $userLavel = new UserLavel([
            'user_id' => $this->id,
            'lavel_id' => $mainLavel['id'],
        ]);
        $userLavel->save();
    }

    public function rules()
    {
        return [
            [['password', 'email'], 'required'],
            [['active'], 'integer'],
            [['lang', 'userGroup', 'username', 'password', 'authKey', 'accessToken', 'email', 'firstName', 'LastName', 'secondName', 'phone'], 'string', 'max' => 255],
            [['phone', 'email'], 'unique', 'targetAttribute' => ['phone', 'email']],
        ];
    }

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
            'lang' => 'lang',
            'user_lavel' => 'Уровень партнера',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['id' => (string)$token->getClaim('uid')])->one();
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['user_id' => 'id']);
    }

    public function getUserRequest()
    {
        return $this->hasMany(UserRequest::class, ['user_id' => 'id']);
    }

    public function getUserAdress()
    {
        return $this->hasMany(UserAdress::class, ['user_id' => 'id']);
    }

    public function getUserTasks()
    {
        return $this->hasMany(UserTasks::class, ['user_id' => 'id']);
    }

    public function getUserRivers()
    {
        return $this->hasMany(Reviews::class, ['user_id' => 'id']);
    }

    public function savePhone($phone)
    {
        if ($this->phone !== $phone) {
            $this->phone = $phone;
            $this->save();
        }
    }

    public function getInfocurs()
    {
        return AccessInfoProduct::findAll(['user_id' => $this->id]);
    }

    public function summOrder()
    {
        $sum = 0;
        foreach ($this->orders as $order) {
            $meta = $order->meta;
            if (!empty($meta->order_summ)) {
                $sum += $meta->order_summ;
            }
        }

        return $sum;
    }

    public function getLavel()
    {
        $userLavel = UserLavel::findOne(['user_id' => $this->id]);

        if ($userLavel !== null) {
            return Lavel::findOne($userLavel->lavel_id);
        }

        return Lavel::findOne(['main' => '1']);
    }

    public function getUserLavel()
    {
        return $this->hasOne(UserLavel::class, ['user_id' => 'id']);
    }

    public function getPromoUser()
    {
        return $this->hasMany(PromoUser::class, ['user_id' => 'id']);
    }

    public function getPromo()
    {
        return $this->promoUser;
    }

    public function updateUser($user)
    {
        $this->firstName = $user['name'];
        $this->LastName = $user['lastname'];
        $this->secondName = $user['surname'];
        $this->phone = $user['phone'];
        $this->save(false);

        return $this->id;
    }

    public function Login()
    {
        $userLogin = new LoginForm([
            'username' => $this->username,
            'password' => $this->password,
            'rememberMe' => true,
        ]);

        $userLogin->login();
    }

    public function getUserBalance()
    {
        return $this->hasMany(UserBalance::class, ['user_id' => 'id']);
    }

    public static function getUsername($id)
    {
        $model = static::findOne($id);
        return $model ? $model->email : null;
    }
}
