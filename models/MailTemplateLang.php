<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mail_template_lang".
 *
 * @property int $id
 * @property int $parent_id
 * @property string|null $content
 * @property string $lang
 * @property string|null $title
 */
class MailTemplateLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail_template_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'lang'], 'required'],
            [['parent_id'], 'integer'],
            [['content'], 'string'],
            [['lang', 'title', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'content' => 'Content',
            'lang' => 'Lang',
            'title' => 'Title',
        ];
    }

    public function getLang(){
        return $this->hasOne(MailTemplate::class, ['parent_id' => 'id']);
    }
}
