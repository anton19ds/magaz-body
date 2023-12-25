<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int|null $col
 * @property int|null $price
 * @property string|null $date
 * @property string $active
 * @property string|null $sale
 *
 * @property ProductMeta[] $productMetas
 */
class Product extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const STATUS_ACTIVE = 1;
    const STATUS_CLOSE = 2;

    const UPSALE_ACTIVE = '1';
    const UPSALE_DEACTIVE = '0';

    const TYPE_SIMPLE = 'simple';
    const TYPE_INFO = 'info';

    public static function getLabelType()
    {
        return [
            self::TYPE_SIMPLE => 'Простой продукт',
            self::TYPE_INFO => 'Инфопродукт',
        ];
    }

    public static function getLabelStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_CLOSE => 'Закрыт',
        ];
    }

    public static function getUpsaleStatus()
    {
        return [
            self::UPSALE_ACTIVE => 'Активный',
            self::UPSALE_DEACTIVE => 'Закрыт',
        ];
    }
    public $productName;
    public $shortName;
    public $link;
    public $image;
    public $description;
    public $shortDescription;
    public $size;
    public $stock;
    public $sort;
    public $content;

    public static function tableName()
    {
        return 'product';
    }


    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
            [['col', 'price', 'raite'], 'integer'],
            [['active'], 'string'],
            [['price'], 'required'],
            [['date', 'sale', 'updated_at'], 'string', 'max' => 255],
            ['upsale', 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'col' => 'Количество',
            'price' => 'Цена',
            'date' => 'Дата',
            'updated_at' => 'Изменен',
            'active' => 'Статус',
            'sale' => 'Скидка',
            'productName' => 'Наименование',
            'shortName' => 'Короткое Наименование',
            'link' => 'Постоянная Ссылка',
            'description' => 'Описание',
            'shortDescription' => 'Короткое Описание',
            'raite' => 'Рейтинг',
            'sort' => 'Позиция',
            'content' => 'Статья товара'
        ];
    }

    /**
     * Gets query for [[ProductMetas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductMetas()
    {
        return $this->hasMany(ProductMeta::class, ['product_id' => 'id']);
    }

    public function getProductMeta()
    {
        return $this->hasMany(ProductMeta::class, ['product_id' => 'id']);
    }

    public function getInfoStep()
    {
        return $this->hasMany(InfoStep::className(), ['info_id' => 'id']);
    }

    public function getProductMetaLang()
    {
        return $this->hasMany(ProductMetaLang::class, ['product_id' => 'id']);
    }


    public function getParam($type, $currency = null)
    {
        if ($currency === null || $currency == 'ru') {
            $model = ProductMeta::find()->where(['product_id' => $this->id])->andWhere(['meta' => $type])->asArray()->one();
        } else {
            $model = ProductMetaLang::find()->where(['product_id' => $this->id])->andWhere(['meta' => $type])->andWhere(['tag' => $currency])->asArray()->one();
        }
        if (!empty($model)) {
            return $model['value'];
        }
        return null;
    }

    public function getProductFoto($stat = true)
    {
        $model = ProductMeta::find()->where(['product_id' => $this->id])->andWhere(['meta' => 'image'])->asArray()->one();
        if (!empty($model) && !empty($model['value'])) {
            $data = json_decode($model['value'], true);
            if ($data['array'][1]['value']) {
                if ($stat) {
                    return '<div class="img-write"><img src="' . $data['array'][1]['value'] . '" style="max-width:80px"></div>';
                } else {
                    return $data['array'][1]['value'];
                }
            }
        }
        return '<div class="img-write"><img src="/adminStyle/assets/img/no-image.png" style="max-width:80px"></div>';
    }

    public function saveData($data)
    {
        var_dump($data);
    }

    public function getProductSimpleList()
    {
        $product = Product::find()->
            select("product.id")->
            leftJoin("product_meta", "product_meta.product_id=product.id")->
            where(["product_meta.meta" => "type"])->
            andWhere(["!=", "product_meta.value", "made"])->
            asArray()->
            all();
        $arrayList = ArrayHelper::getColumn($product, 'id');
        $productMeta = ProductMeta::find()->where(["product_id" => $arrayList])->andWhere(["meta" => "productName"])->asArray()->all();
        if (!empty($productMeta)) {
            $map = ArrayHelper::map($productMeta, "product_id", "value");
            return $map;
        }
        return null;
    }

    public function getImageProductList(): array
    {
        $array = ProductMeta::find()->where(['product_id' => $this->id])->andWhere(['meta' => 'image'])->asArray()->one();
        if (!empty($array['value'])) {
            return json_decode($array['value'], true);
        }
        return [];

    }

    public function getPrice()
    {
        $currency = Currencies::find()->asArray()->all();
        if (!empty($currency)) {
            $dataPrice = array();
            foreach ($currency as $item) {
                $dataPrice[$item['tag']] = round($this->price * $item['code']);
            }
            return $dataPrice;
        }
        return null;
    }

    public function getCategory()
    {
        $productMeta = ProductMeta::find()->where(["product_id" => $this->id])->andWhere(["meta" => "category"])->asArray()->one();
        if (!empty($productMeta)) {
            $category = Category::find()->where(['id' => $productMeta['value']])->asArray()->one();
            if (!empty($category)) {
                return $category['title'];
            }
        }
    }

    public static function getPriceProductbyId($id, $currency = null){
        $model = self::findOne($id);
        if ($currency && $currency != 'ru') {
            $currency = Currencies::find()->where(['tag' => $currency])->one();
            $symbol = $currency->tag;
            $symbolCode = $currency->tag;
            $prise = round($model->price * $currency->code);
        } else {
            $prise = $model->price;
            $symbol = 'RUB';
            $symbolCode = '₽';
        }
        if ($model->sale) {
            if(stristr($model->sale, '%') === FALSE) {
                $summ = round($prise - $model->sale);
            }else{
                $summ = round($prise - ($prise / 100 * $model->sale));
            }
        } else {
            $summ = null;
        }
        $htmlStr = "<ul><li><s style='color:red'>" . $prise . "  " . $symbol . "</s></li><li>" . $summ . "  " . $symbol . "</li></ul>";
        $arrayResult = array(
            'symbol' => $symbol,
            'price' => $prise,
            'summ' => $summ,
            'html' => $htmlStr,
            'symbolCode' => $symbolCode
        );
        return $arrayResult;
    }
    public function getPriceProduct($currency = null)
    {
        if ($currency && $currency != 'ru') {
            $currency = Currencies::find()->where(['tag' => $currency])->one();
            $symbol = $currency->tag;
            $symbolCode = $currency->tag;
            $prise = round($this->price * $currency->code);
        } else {
            $prise = $this->price;

            $symbol = 'RUB';
            $symbolCode = '₽';
        }
        if ($this->sale) {
            $summ = round($prise - ($prise / 100 * $this->sale));
        } else {
            $summ = null;
        }
        $htmlStr = "<ul><li><s style='color:red'>" . $prise . "  " . $symbol . "</s></li><li>" . $summ . "  " . $symbol . "</li></ul>";
        $arrayResult = array(
            'symbol' => $symbol,
            'price' => $prise,
            'summ' => $summ,
            'html' => $htmlStr,
            'symbolCode' => $symbolCode
        );
        return $arrayResult;
    }

    public static function priceData($id, $currency)
    {
        $product = self::find()->where(['id' => $id])->asArray()->one();
        if ($currency && $currency != 'ru') {
            $currency = Currencies::find()->where(['tag' => $currency])->one();
            $symbol = $currency->tag;
            $symbolCode = $currency->tag;
            $prise = round($product['price'] * $currency->code);
        } else {
            $prise = round($product['price']);
            $symbol = 'RUB';
            $symbolCode = '₽';
        }
        if ($product['sale']) {
            $summ = round($prise - ($prise / 100 * $product['sale']));
        } else {
            $summ = null;
        }
        if (!empty($summ)) {
            $htmlStr = "<div class='apccels-rating-price'>"
                . number_format($summ, 0, " ", " ")
                . "  "
                . $symbol
                . "<span> "
                . number_format(round($prise), 0, " ", ".")
                . "  "
                . $symbol
                . "</span></div>";
        } else {
            $htmlStr = "<div class='apccels-rating-price'>"
                . number_format($prise, 0, " ", " ")
                . "  "
                . $symbol
                . "</div>";
        }
        $arrayResult = array(
            'symbol' => $symbol,
            'price' => $prise,
            'summ' => $summ,
            'html' => $htmlStr,
            'symbolCode' => $symbolCode
        );
        return $arrayResult;
    }

    public function arrayMeta($currency = null)
    {
        if ($currency && $currency != 'ru') {
            $model = ProductMetaLang::find()->where(['product_id' => $this->id])->andWhere(['tag' => $currency])->asArray()->all();
        } else {
            $model = ProductMeta::find()->where(['product_id' => $this->id])->asArray()->all();
        }
        return ArrayHelper::map($model, 'meta', 'value');
    }

    public static function getProduct($id, $cyrrensy)
    {
        $product = self::findOne($id);
        return $product;
    }

    public function title()
    {
        $title = ProductMeta::find()->where(['meta' => 'productName'])->andWhere(['product_id' => $this->id])->one();
        return $title->value;
    }

    public function getType()
    {
        $type = ProductMeta::find()->where(['product_id' => $this->id])->andWhere(['meta' => 'type'])->asArray()->one();
        if ($type) {
            return $type['value'];
        }
        return null;
    }

    

    public function accessCurs($user_id){
        
        $model = AccessInfoProduct::find()->where(['user_id'=> $user_id])->andWhere(['product_id' => $this->id])->one();

        if(!empty($model)){
            $infoCurs = OrderStatus::find()->
            leftJoin("orders", "order_status.order_id=orders.id")->
            where(["orders.uuid"=> $model->uuid])->
            andWhere(["or",["order_status.status" => OrderStatus::STATUS_CLOSE], ["order_status.status" => OrderStatus::STATUS_PAY]])
            ->one();
            if($infoCurs){
                return true;
            }
        }
        return false;
        
    }

    
}