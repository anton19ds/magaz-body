<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_lang".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $lang
 */
class CategoryLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'lang','active'], 'required'],
            [['active'], 'integer'],
            [['category_id'], 'integer'],
            [['title', 'lang'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Name',
            'lang' => 'Lang',
        ];
    }
}
