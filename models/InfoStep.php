<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "info_step".
 *
 * @property int $id
 * @property int $info_id
 * @property string $content
 * @property string $date
 * @property string $type_step
 */
class InfoStep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

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



    const STATUS_FORM = "form";
    const STATUS_FORM_FILE = "formandfile";
    const STATUS_FILE = "file";
    const STATUS_NONE = "none";

    public static function getLabelStatus()
    {
        return [
            self::STATUS_FORM => "форма",
            self::STATUS_FORM_FILE => "форма и файл",
            self::STATUS_FILE => "файл",
            self::STATUS_NONE => "пустой"
        ];
    }


    public static function tableName()
    {
        return 'info_step';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'content'], 'required'],
            [['info_id', 'sort'], 'integer'],
            [['content'], 'string'],
            [['date', 'type_step', 'time', 'img'], 'string', 'max' => 255],
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
        ];
    }

    public function getCheck()
    {
        return StepUserChek::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['step_id' => $this->id])->one();
    }

    public static function checkData($id)
    {
        return StepUserChek::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['step_id' => $id])->one();
    }

    public function getProduct(){
        return $this->hasOne(Product::class, ['id' => 'info_id']);
    }
}