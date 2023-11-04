<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "promocod".
 *
 * @property int $id
 * @property string $promocode
 * @property string $date
 * @property int $size
 * @property string $active
 */
class Promocod extends ActiveRecord
{

    const ACTIVE = 1;
    const INACTIVE = 0;


    public static function getLabelStatus()
    {
        return [
            self::ACTIVE => 'Включен',
            self::INACTIVE => 'Отключен',
        ];
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
    public static function tableName()
    {
        return 'promocod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promocode','size'], 'required'],
            [['size'], 'integer'],
            [['active'], 'string'],
            [['promocode', 'date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promocode' => 'Промокод',
            'date' => 'Дата',
            'size' => 'Размер Скидки',
            'active' => 'Статус',
        ];
    }
}
