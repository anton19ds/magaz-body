<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view_product".
 *
 * @property int $id
 * @property int $product_id
 * @property string $tag
 * @property int $satatus
 */
class ViewProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'view_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'tag'], 'required'],
            [['product_id', 'status'], 'integer'],
            [['tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'tag' => 'Tag',
            'status' => 'Satatus',
        ];
    }
}
