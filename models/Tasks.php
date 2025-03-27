<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $text
 * @property int $summ
 * @property int $status
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'summ'], 'required'],
            [['text', 'name'], 'string'],
            [['summ', 'status'], 'integer'],
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
            'summ' => 'Промокод',
            'status' => 'Статус',
            'name' => 'Наименование'
        ];
    }

    public function getPromocod(){
        return $this->hasOne(Promocod::class, ['id' => 'summ']);
    }

    public function getSizeCur($lang){
        $size = $this->promocod->size;
        if(Currencies::find()->where(['tag' => $lang])->exists()){
            $cur = Currencies::find()->where(['tag' => $lang])->one();
            return $cur->code * $size;
        }
        return $size;

    }
}
