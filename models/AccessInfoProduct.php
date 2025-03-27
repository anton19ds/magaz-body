<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "access_info_product".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $product_id
 * @property string|null $uuid
 *
 * @property Product $product
 * @property User $user
 */
class AccessInfoProduct extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access_info_product';
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
            [['user_id', 'product_id'], 'integer'],
            [['uuid'], 'string', 'max' => 500],
            [['date'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
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
            'product_id' => 'Product ID',
            'uuid' => 'Uuid',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getOrders(){
        return $this->hasOne(Orders::class, ['uuid' => 'uuid']);
    }

    public static function addAccess($user_id, $product_id, $uuid){
        if(!self::find()->where(['user_id' => $user_id])->andWhere(['product_id' => $product_id])->andWhere(['uuid' => $uuid])->exists()){
            $model = new self([
                'user_id'=> $user_id,
                'product_id' => $product_id,
                'uuid' => $uuid
            ]);
            if($model->save()){
                return '22';
            }else{
                return $model->getErrors();
            };
        }else{
            return '23';
        }
        
    }
}
