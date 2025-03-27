<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mail_template".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 * @property string|null $lang
 * @property string|null $date
 * @property string|null $name
 */
class MailTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['title', 'lang', 'date', 'name', 'tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'lang' => 'Lang',
            'date' => 'Date',
            'name' => 'Name',
            'tag' => 'tag'
        ];
    }


    public function getLans(){
        return $this->hasMany(MailTemplateLang::class, ['id' => 'parent_id']);
    }
}
