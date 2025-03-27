<?php

namespace app\models;

use Yii;

class TasksLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'name', 'tag'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Текст',
            'name' => 'Наименование',
            'parent_id' => 'parent_id',
        ];
    }

    public function getParent(){
        return $this->hasOne(Tasks::class, ['id' => 'parent_id']);
    }
}
