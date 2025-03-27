<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_tasks".
 *
 * @property int $id
 * @property int $user_id
 * @property int $tasks_id
 * @property string $file
 * @property string $text
 */
class UserTasks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_tasks';
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
    public function rules()
    {
        return [
            [['user_id', 'tasks_id', 'file'], 'required'],
            [['user_id', 'tasks_id', 'status'], 'integer'],
            [['text'], 'string'],
            [['file', 'date', 'lang'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'tasks_id' => 'Номер задания',
            'file' => 'Файл',
            'text' => 'Коментарий',
            'status' => 'Статус'
        ];
    }

    public function getTasks()
    {
        return $this->hasOne(Tasks::class, ['id' => 'tasks_id']);
    }

    public function getUser(){
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
