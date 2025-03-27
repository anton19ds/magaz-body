<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ViewDelivery extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'view_delivery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'meta', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'data' => 'data',
            'meta' => 'meta',
            'value' => 'value',
        ];
    }
}