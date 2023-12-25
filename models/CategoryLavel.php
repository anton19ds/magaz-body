<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_lavel".
 *
 * @property int $id
 * @property int $category_promo_id
 * @property int $lavel_id
 * @property int $size
 */
class CategoryLavel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_lavel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_promo_id', 'lavel_id', 'size'], 'required'],
            [['category_promo_id', 'lavel_id', 'size'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_promo_id' => 'Category Promo ID',
            'lavel_id' => 'Lavel ID',
            'size' => 'Size',
        ];
    }

    public function getCategoryPromo(){
        return $this->hasOne(CategoryPromo::class, ['id' => 'category_promo_id']);
    }

    public function getLavel(){
        return $this->hasOne(Lavel::class, ['id' => 'lavel_id']);
    }
}
