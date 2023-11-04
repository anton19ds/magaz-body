<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "info_courses".
 *
 * @property int $id
 * @property int $product_id
 * @property string $meta
 * @property string|null $value
 */
class InfoCourses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'info_courses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'meta'], 'required'],
            [['product_id'], 'integer'],
            [['meta', 'value'], 'string'],
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
            'meta' => 'Meta',
            'value' => 'Value',
        ];
    }
}
