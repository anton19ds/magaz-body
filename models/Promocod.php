<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "promocod".
 *
 * @property int $id
 * @property string $promocode
 * @property string $date
 * @property int $size
 * @property string $active
 */
class Promocod extends ActiveRecord
{

    const ACTIVE = 1;
    const INACTIVE = 0;


    public static function getLabelStatus()
    {
        return [
            self::ACTIVE => 'Включен',
            self::INACTIVE => 'Отключен',
        ];
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
    public static function tableName()
    {
        return 'promocod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promocode','size'], 'required'],
            [['active'], 'string'],
            [['promocode', 'date','size'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promocode' => 'Промокод',
            'date' => 'Дата',
            'size' => 'Размер Скидки',
            'active' => 'Статус',
        ];
    }

    public static function getSize($cart, $lang, $coupon = null){ 
        if(isset($cart['coupon']) || $coupon){
            if(!empty($coupon)){
                if(self::find()->where(['id' => $coupon])->asArray()->exists()){
                    $model = self::find()->where(['id' => $coupon])->asArray()->one();
                }else{
                    $model = self::find()->where(['promocode' => $coupon])->asArray()->one();
                }
                
            }else{
                $model = self::find()->where(['promocode' => $cart['coupon']])->asArray()->one();
            }
            if($lang != 'ru' && Currencies::find()->where(['tag' => $lang])->exists()){
                $currensy = Currencies::find()->where(['tag' => $lang])->asArray()->one();
                return round($model['size'] * $currensy['code']);
            }else{
                return $model['size'];
            }
        }else{
            return null;
        }
    }

    public static function getName($cart, $lang, $coupon = null){
        if(isset($cart['coupon']) || $coupon){
            if($coupon){
                $model = self::find()->where(['promocode' => $coupon])->asArray()->one();
            }else{
                $model = self::find()->where(['promocode' => $cart['coupon']])->asArray()->one();
            }
            return $model['promocode'];
        }else{
            return null;
        }
    }
}
