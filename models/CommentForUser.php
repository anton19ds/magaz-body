<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class CommentForUser extends ActiveRecord
{

    public static function tableName()
    {
        return 'comment_for_user';
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

    public function rules()
    {
        return [
            [['order_id'], 'integer'],
            [['lang', 'date'], 'string', 'max' => 255],
            [['text'], 'string'],
        ];
    }

}

