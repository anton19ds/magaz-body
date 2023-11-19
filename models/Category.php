<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string $date
 * @property int $active
 */
class Category extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }
    public function behaviors()
    {
      return [
        'timestamp' => [
          'class' => 'yii\behaviors\TimestampBehavior',
          'attributes' => [
            ActiveRecord::EVENT_BEFORE_INSERT => ['date']
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
            [['title',  'active'], 'required'],
            [['active'], 'integer'],
            [['title', 'date'], 'string', 'max' => 255],
            [['date'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование',
            'date' => 'Дата',
            'active' => 'Статус',
        ];
    }
}
