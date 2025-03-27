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

class InfoStep extends ActiveRecord
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
            [['info_id', 'sort', 'category_id', 'time', 'disc'], 'integer'],
            [['content'], 'string'],
            [['date', 'type_step', 'img', 'hourse', 'lang'], 'string', 'max' => 255],
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
            'content' => 'ID Статьй по API',
            'date' => 'Дата добавления',
            'type_step' => 'Type Step',
            'time' => 'дни активации от покупки',
            'hourse' => 'Точное время активации',
            'title' => 'Загаловок',
            'sort' => 'Позиция',
            'disc' => 'Наличие задания'
        ];
    }

    public function getCheck()
    {
        return StepUserChek::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['step_id' => $this->id])->one();
    }

    public static function checkData($id)
    {
        if (StepUserChek::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['step_id' => $id])->exists()) {
            return true;
        }
        return false;
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'info_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(CategoryInfoproduct::class, ['id' => 'category_id']);
    }

    public function getDescs()
    {
        if (StepDescUser::find()->where(['step_id' => $this->id])->andWhere(['user_id' => Yii::$app->user->identity->id])->exists()) {
            return true;
        }
        return false;
    }


    public static function getDescsStatic($id)
    {
        if (StepDescUser::find()->where(['step_id' => $id])->andWhere(['user_id' => Yii::$app->user->identity->id])->exists()) {
            return true;
        }
        return false;
    }

    public static function getDescsStaticPrevent($id)
    {
        $model = self::findOne($id);
        if ($model->sort && !empty($model->sort)) {
            $newSort = $model->sort - 1;
            if ($newSort != 0 && $newSort > 0) {

                $prev = InfoStep::find()->where(['category_id' => $model->category_id])->andWhere(['sort' => $newSort])->one();
                if ($prev) {
                    $set = self::checkData($prev->id);
                    if ($set) {
                        return 1;
                    } else {
                        return 2;
                    }
                }
                return false;
            }
        }
        return false;
    }

    public function getStatusDate()
    {
        $category = CategoryInfoproduct::findOne($this->category_id);
        $product = Product::find()
            ->where(['id' => $category->infoproduct_id])
            ->one();
        $dataProduct = AccessInfoProduct::find()->where(['product_id' => $product->id])->andWhere(['user_id' => Yii::$app->user->identity->id])->asArray()->one();
        if (isset($dataProduct['date']) && !empty($dataProduct['date'])) {
            $letTime = $dataProduct['date'];
        } else {
            $letTime = time();
        }
        $date = 0;
        $timer = time();
        $date_end = time();
        if (!empty($this->time) && $this->time != 0) {
            $date_end = strtotime('+' . $this->time . ' day', $letTime);
            $timer = time();
            $date = date("Y-m-d", $date_end);
            if (!empty($this->hourse)) {
                $date = $date . " " . $this->hourse . ":00";
            }
        }
        $d1 = strtotime($date);
        if ($timer > $d1) {
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false,
                'date_end' => $date_end
            ];
        }
        return [
            'status' => true
        ];
    }

}