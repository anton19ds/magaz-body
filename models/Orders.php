<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $data_order
 * @property int $user_id
 * @property string $date
 */
class Orders extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */




    public static function tableName()
    {
        return 'orders';
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
            [['data_order', 'user_id'], 'required'],
            [['data_order', 'uuid'], 'string'],
            [['user_id'], 'integer'],
            [['uuid'], 'unique',],
            [['date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data_order' => 'Данные заказа',
            'user_id' => 'Пользователь',
            'date' => 'Дата заказа',
        ];
    }

    public function getMeta()
    {
        return OrdersMeta::find()->where(['order_id' => $this->id])->one();
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function dataOrder()
    {
        if (!empty($this->data_order)) {
            return unserialize($this->data_order);
        }
        return null;
    }

    public function dataPrice()
    {
        if ($this->dataOrder()) {
            $orderArray = $this->dataOrder();

            $summ = 0;
            foreach ($orderArray as $item) {
                $summ = $summ + ($item['price'] * $item['count']);
            }
            return $summ;
        }
        return null;

    }

    public function dataCurrensy()
    {
        if ($this->dataOrder()) {
            $orderArray = $this->dataOrder();

            $symbol = '';
            foreach ($orderArray as $item) {
                $symbol = $item['symbol'];
            }
            return $symbol;
        }
        return null;
    }

    public function getTovar()
    {
        if ($this->dataOrder()) {
            $tovarList = Product::find()->where(['id' => ArrayHelper::getColumn($this->dataOrder(), 'id')])->all();
            return $tovarList;
        }
        return null;


    }


    public function getStatus()
    {
        $status = OrderStatus::find()->where(['order_id' => $this->id])->one();
        if (!$status) {
            return OrderStatus::STATUS_NEW;
        } else {
            return $status->status;
        }
    }

    public function Metas()
    {
        return OrdersMeta::find()->where(['order_id' => $this->id])->asArray()->one();
    }


    public function getOrdersUser()
    {
        return unserialize($this->data_order);

    }

    public function orderInfo()
    {
        $str = '';
        $count = 0;
        $summ = 0;
        $symbol = '';
        foreach (unserialize($this->data_order) as $item) {
            $summ = $summ + ($item['count'] * $item['price']);
            $count = $count + $item['count'];
            $symbol = $item['symbol'];
        }
        $str = $summ . " " . $symbol . " " . "за" . " " . $count . "шт";
        return $str;
    }

    public static function getTovarList($array)
    {

        $data = unserialize($array);

        $arrayId = ArrayHelper::getColumn($data, 'id');
        $model = Product::find()->where(['id' => $arrayId])->all();
        return $model;
    }

}