<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promo_user_size".
 *
 * @property int $id
 * @property int $promo_user_id
 * @property int $category_promo_id
 * @property int $size
 */



 


class PromoUserSize extends \yii\db\ActiveRecord
{

const PRIM = '1';
 const SALE = '2';


 public static function getType()
    {
        return [
            self::PRIM => 'Вознаграждение',
            self::SALE => 'Размер скидки',
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promo_user_size';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promo_user_id', 'category_promo_id', 'size'], 'required'],
            [['promo_user_id', 'category_promo_id', 'size','type'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promo_user_id' => 'Promo User ID',
            'category_promo_id' => 'Category Promo ID',
            'size' => 'Size',
            'type' => 'Тип'
        ];
    }

    public function getCategoryPromo(){
        return $this->hasOne(CategoryPromo::class, ['id' => 'category_promo_id']);
    }
}
