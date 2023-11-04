<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "translations".
 *
 * @property int $id
 * @property string|null $param
 * @property string|null $value
 * @property string|null $tag
 */
class Translations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['param', 'value', 'tag'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param' => 'Param',
            'value' => 'Value',
            'tag' => 'Tag',
        ];
    }

    public static function getTranslation($param, $tag = null)
    {
        if (!$tag) {
            $tag = 'ru';
        }
        $translation = Translations::find()->select('value')->where(['param' => $param])->andWhere(['tag' => $tag])->asArray()->one();
        if ($translation) {
            return $translation['value'];
        } else {
            return $param;
        }
    }
}