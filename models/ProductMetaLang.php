<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_meta_lang".
 *
 * @property int $id
 * @property string|null $meta
 * @property string|null $value
 * @property string|null $product_id
 * @property string|null $tag
 */
class ProductMetaLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_meta_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['meta', 'value', 'tag'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'meta' => 'Meta',
            'value' => 'Value',
            'product_id' => 'Product ID',
            'tag' => 'Tag',
        ];
    }
}
