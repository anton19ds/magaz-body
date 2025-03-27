<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "setting_data".
 *
 * @property int $id
 * @property string $meta
 * @property string|null $value
 * @property string|null $date
 * @property string|null $lang
 */
class SettingData extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting_data';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date'],
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
            [['meta'], 'required'],
            [['meta', 'value', 'lang'], 'string', 'max' => 255],
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
            'date' => 'Date',
            'lang' => 'Lang',
        ];
    }

    public static function getValue($meta){
        $model = SettingData::find()->where(['meta' => $meta])->one();
        if($model){
            return $model->value;
        }
        return null;
    }
}
