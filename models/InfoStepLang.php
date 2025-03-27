<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "info_step_lang".
 *
 * @property int $id
 * @property int $info_id
 * @property string $content
 * @property string|null $date
 * @property string|null $type_step
 * @property string|null $time
 * @property string|null $img
 * @property string|null $title
 * @property int|null $sort
 * @property string|null $tag
 */
class InfoStepLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'info_step_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'content'], 'required'],
            [['info_id', 'sort', 'parent_id', 'category_id'], 'integer'],
            [['content', 'date', 'type_step', 'time', 'img', 'tag'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info_id' => 'Info ID',
            'content' => 'Content',
            'date' => 'Date',
            'type_step' => 'Type Step',
            'time' => 'Time',
            'img' => 'Img',
            'title' => 'Title',
            'sort' => 'Sort',
            'tag' => 'Tag',
        ];
    }
    public function getCategory(){
        return $this->hasOne(CategoryInfoproduct::class, ['id' => 'category_id']);
    }
}
