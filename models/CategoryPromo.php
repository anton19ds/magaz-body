<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "category_promo".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $date
 */
class CategoryPromo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */


    const TYPE_SIMPLE = 'simple';
    const TYPE_INFO = 'info';

    public static function getLabelType()
    {
        return [
            self::TYPE_SIMPLE => 'Физ. Товар',
            self::TYPE_INFO => 'Инфопродукт',
        ];
    }


     public static function getName($id){
        $model = self::find()->where(['id' => $id])->asArray()->one();
        return $model['name'];
     }
    public static function tableName()
    {
        return 'category_promo';
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
            [['name', 'date'], 'string', 'max' => 255],
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
            'date' => 'Date',
        ];
    }

    public function getPromoUserSize(){
        return $this->hasMany(PromoUserSize::class, ['category_promo_id'=> 'id']);
    }
}
