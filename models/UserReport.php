<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "user_lavel".
 *
 * @property int $id
 * @property int $user_id
 * @property int $lavel_id
 */



class UserReport extends ActiveRecord 
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_report';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['data'],
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
            [['user_data', 'user_refil', 'data', 'ip', 'promocode_id', 'count'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            // 'id' => 'ID',
            // 'user_id' => 'User ID',
            // 'lavel_id' => 'Lavel ID',
        ];
    }

    public function getPromocode(){
        return $this->hasOne(PromoUser::class, ['id' => 'promocode_id']);
    }

    public static function newReport($promocode_id){
        $server = $_SERVER;
        $model = new self([
            'user_data' => serialize($server),
            'ip' => $server['HTTP_CF_CONNECTING_IP'],
            'count' => $server['HTTP_CF_IPCOUNTRY'],
            'promocode_id' => (string)$promocode_id,
        ]);
        if(!$model->save(false)){
            return $model->getErrors();
        };
        return true;
    }
}
