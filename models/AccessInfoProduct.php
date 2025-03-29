<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access_info_product".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $product_id
 * @property string|null $uuid
 */
class AccessInfoProduct extends ActiveRecord
{
    public const ACCESS_CREATED = '22';
    public const ACCESS_EXISTS = '23';

    public static function tableName()
    {
        return 'access_info_product';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'integer'],
            [['uuid'], 'string', 'max' => 500],
            [['date'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'uuid' => 'Uuid',
            'date' => 'Date',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getOrders()
    {
        return $this->hasOne(Orders::class, ['uuid' => 'uuid']);
    }

    public static function findByUserProductUuid($userId, $productId, $uuid)
    {
        return self::find()
            ->where(['user_id' => $userId, 'product_id' => $productId, 'uuid' => $uuid])
            ->one();
    }

    public static function addAccess($userId, $productId, $uuid)
    {
        if (self::findByUserProductUuid($userId, $productId, $uuid) !== null) {
            return self::ACCESS_EXISTS;
        }

        $model = new self([
            'user_id' => $userId,
            'product_id' => $productId,
            'uuid' => $uuid,
        ]);

        return $model->save() ? self::ACCESS_CREATED : $model->getErrors();
    }
}
