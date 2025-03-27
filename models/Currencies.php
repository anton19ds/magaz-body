<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $tag
 * @property string|null $code
 * @property string|null $status
 */
class Currencies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'tag', 'code', 'status', 'icon'], 'string', 'max' => 255],
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
            'tag' => 'Tag',
            'code' => 'Code',
            'status' => 'Status',
            'icon' => 'icon'
        ];
    }

    public static function getIcon($tag){
        if(self::find()->where(['tag' => $tag])->exists()){
            $model = self::find()->where(['tag' => $tag])->asArray()->one();
            return $model['icon'];
        }
        return '₽';
    }

    public static function getCode($tag){
        if(self::find()->where(['tag' => $tag])->exists()){
            $model = self::find()->where(['tag' => $tag])->asArray()->one();
            return $model['code'];
        }
        return 0;
    }
}
