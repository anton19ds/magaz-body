<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_type".
 *
 * @property int $id
 * @property string $titel
 * @property string|null $descript
 * @property string|null $icon
 */
class PaymentType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titel'], 'required'],
            [['descript'], 'string'],
            [['titel', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titel' => 'Titel',
            'descript' => 'Descript',
            'icon' => 'Icon',
        ];
    }
}
