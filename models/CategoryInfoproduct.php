<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category_infoproduct".
 *
 * @property int $id
 * @property string $title
 * @property int $infoproduct_id
 * @property string $tag
 * @property string|null $date
 * @property string|null $img
 */
class CategoryInfoproduct extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_infoproduct';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date'],
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
            [['title', 'infoproduct_id', 'tag'], 'required'],
            [['infoproduct_id', 'sort'], 'integer'],
            [['title', 'tag', 'img'], 'string', 'max' => 255],
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
            'infoproduct_id' => 'Инфопродукт ID',
            'tag' => 'Языка',
            'date' => 'Дата добавление',
            'img' => 'Изображение',
            'sort' => 'Позиция'
        ];
    }

    public function getStep(){
        return $this->hasMany(InfoStep::class, ['category_id'=> 'id']);
    }

    public function countStep(){
        $model = InfoStep::find()->where(['category_id'=> $this->id])->count();
        return $model;
    }

    public function getFirstStep(){
        $min = InfoStep::find()->where(['category_id'=> $this->id])->min('sort');
        $model = InfoStep::find()
            ->where(['category_id'=> $this->id])
            ->andWhere(['sort' => $min])
            ->one();
        if($model){
            return $model;
        }
        return null;
    }

}
