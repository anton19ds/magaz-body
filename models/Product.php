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
    const TYPE_MADE = 'made';
    const TYPE_DATA = 'data';

    public static function getLabelType()
    {
        return [
            self::TYPE_SIMPLE => 'Физический продукт',
            self::TYPE_INFO => 'Инфопродукт',
            self::TYPE_MADE => 'Сборный',
            self::TYPE_DATA => 'Услуги'
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
            [['col', 'price', 'raite', 'category', 'sort'], 'integer'],
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
            'category' => 'Категория',
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
            if (isset($data['array'][1]['value']) && $data['array'][1]['value']) {
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


    public function getProductSimpleListRef()
    {
        $product = Product::find()->
            select("product.id")->
            leftJoin("product_meta", "product_meta.product_id=product.id")->
            where(["product_meta.meta" => "type"])->
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

    public static function getPriceProductbyId($id, $currency = null, $type = null)
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        $promocode = null;
        $promouserSize = null;
        if(!empty($cart) && isset($cart['promocode']) && !empty($cart['promocode'])){
            if(PromoUser::find()->where(['name' => $cart['promocode']])->exists()){
                $promocode = PromoUser::find()->where(['name' => $cart['promocode']])->one();
                $promouserSizeModel = PromoUserSize::find()->where(['promo_user_id' => $promocode->id])->asArray()->all();
                 foreach($promouserSizeModel as $value){
                    if($value['type'] == 2){
                        $promouserSize[$value['category_promo_id']] = $value['size'];
                    }
                     
                }
            }
        }
        
        $model = self::findOne($id);
        $productPac = ProductMeta::find()->where(['product_id' => $id])->andWhere(['meta' => ['pricePac-1', 'pricePac-2', 'pricePac-3']])->all();
        if(!empty($productPac)){
            $productPac = ArrayHelper::map($productPac, 'meta', 'value');
        }
        if ($currency && $currency != 'ru') {
            $currency = Currencies::find()->where(['tag' => $currency])->one();
            $symbol = $currency->tag;
            $symbolCode = $currency->icon;
            $prise = round($model->price * $currency->code);
            if(!empty($productPac)){
                foreach($productPac as $key => &$item){
                    if($item){
                        $item = round($item * $currency->code);
                    }
                }
            }
            if($model->sale){
                $sale = $model->sale * $currency->code;
            }
        } else {
            $prise = $model->price;
            $symbol = 'RUB';
            $symbolCode = '₽';
            if($model->sale){
                $sale = $model->sale;
            }
        }
        if ($model->sale) {
            $summPac = 0;
                
            if(!empty($productPac)){
                foreach($productPac as $key => &$item){
                    if (stristr($model->sale, '%') === FALSE) {
                        if($item && $sale){
                            $summPac = round($item - $sale);
                        }
                        
                    } else {
                        $summPac = round($item - ($item / 100 * $model->sale));
                    }

                    if($type && $promouserSize){
                        if($type == CategoryPromo::TYPE_SIMPLE || $type == 'made'){
                            $summPac = $summPac - ($summPac / 100 * $promouserSize[1]);
                        }else if($type == CategoryPromo::TYPE_INFO){
                            $summPac = $summPac - ($summPac / 100 * $promouserSize[2]);
                        }else if($type == CategoryPromo::TYPE_SERVICES || $type == 'data'){
                            $summPac = $summPac - ($summPac / 100 * $promouserSize[3]);
                        }
                    }
                    $item = array(
                        'prise' => $item,
                        'sale' => $summPac,
                    );
                }
            }

            if (stristr($model->sale, '%') === FALSE) {
                $summ = round($prise - $sale );
            } else {
                $summ = round($prise - ($prise / 100 * $model->sale));
            }
        } else {
            $summ = null;
        }
        $htmlStr = "<ul><li><s style='color:red'>" . $prise . "  " . $symbol . "</s></li><li>" . $summ . "  " . $symbol . "</li></ul>";
        if($type && $promouserSize){
            if($type == CategoryPromo::TYPE_SIMPLE || $type == 'made'){
                $summ = $summ - ($summ / 100 * $promouserSize[1]);
            }else if($type == CategoryPromo::TYPE_INFO){
                $summ = $summ - ($summ / 100 * $promouserSize[2]);
            }else if($type == CategoryPromo::TYPE_SERVICES || $type == 'data'){
                $summ = $summ - ($summ / 100 * $promouserSize[3]);
            }
        }
        $arrayResult = array(
            'symbol' => $symbol,
            'price' => $prise,
            'summ' => $summ,
            'html' => $htmlStr,
            'symbolCode' => $symbolCode,
            'productPac' => $productPac,
            'promouserSize' => $promouserSize
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



    public function accessCurs($user_id)
    {
        $model = AccessInfoProduct::find()->where(['user_id' => $user_id])->andWhere(['product_id' => $this->id])->one();
        if (!empty($model)) {
            $infoCurs = OrderStatus::find()->
                leftJoin("orders", "order_status.order_id=orders.id")->
                where(["orders.uuid" => $model->uuid])->
                andWhere(["or", ["order_status.status" => OrderStatus::STATUS_CLOSE], ["order_status.status" => OrderStatus::STATUS_PAY]])
                ->one();
            if ($infoCurs) {
                return true;
            }
        }
        return false;

    }
    public static function accessEnableInfo($id, $user_id){
        $model = AccessInfoProduct::find()->where(['user_id' => $user_id])->andWhere(['product_id' => $id])->one();
        if (!empty($model)) {
            return true;
        }
        return false;
    }

    public static function accessEnable($id, $user_id)
    {
        $model = AccessInfoProduct::find()->where(['user_id' => $user_id])->andWhere(['product_id' => $id])->one();
        if (!empty($model)) {
            $infoCurs = OrderStatus::find()->
                leftJoin("orders", "order_status.order_id=orders.id")->
                where(["orders.uuid" => $model->uuid])->
                andWhere(["or", ["order_status.status" => OrderStatus::STATUS_CLOSE], ["order_status.status" => OrderStatus::STATUS_PAY]])
                ->one();
            if ($infoCurs) {
                return true;
            }
        }
        return false;

    }

    public function getViewProduct()
    {
        return $this->hasMany(ViewProduct::class, ['product_id' => 'id']);
    }

    public function getActiveProductLang($lang)
    {
        if(ViewProduct::find()->where(['tag' => $lang])->andWhere(['product_id' => $this->id])->exists()){
            $setStatus = ViewProduct::find()->where(['tag' => $lang])->andWhere(['product_id' => $this->id])->one();
            if($setStatus->status == 1){
                return true;
            }
        }
        return false;
    }

    public static function getProductLink($id, $lang = null){
        if(!$lang || $lang == 'ru'){
            $link = ProductMeta::find()->where(['meta' => 'link'])->andWhere(['product_id' => $id])->asArray()->one();
        }else{
            $link = ProductMetaLang::find()->where(['meta' => 'link'])->andWhere(['product_id' => $id])->andWhere(['tag' => $lang])->asArray()->one();
        }
        if(isset($link['value']) && !empty($link['value'])){
            return $link['value'];
        }
        return null;
    }

    public static function getPac($id, $currency, $pac){
        $meta = ProductMeta::find()->where(['meta' => $pac])->andWhere(['product_id' => $id])->asArray()->one();
        if(!empty($meta) && !empty($meta['value'])){
            if($currency != 'ru'){
                $curr = Currencies::find()->where(['tag' => $currency])->one();

                return $meta['value'] * $curr->code;
            }else{
                return $meta['value'];
            }
        }
    }

    public function dataOrdersInfoproduct(){
        $model = AccessInfoProduct::find()->where(['product_id' => $this->id])->andWhere(['user_id' => Yii::$app->user->identity->id])->one();
        if($model){
            try{
                if($model->orders){
                    return $model->orders->date;
                }
            }catch(\Exception $e){
                $model->date;  
            }
        }
        return null;
    }

    public static function getProductInProduct($id){
        $data = ProductMeta::find()->where(['product_id' => $id])->andWhere(['meta' => 'product'])->one();
        if($data){
            return json_decode($data->value, true);
        }
        return null;
    }

    public static function getTypeInProduct($id){
        $data = ProductMeta::find()->where(['product_id' => $id])->andWhere(['meta' => 'type'])->one();
        if($data){
            return $data->value;
        }
        return null;
    }

    public static function ProductGetSumm(){
        
    }


    public static function getAccessDes($id){
        $step = InfoStep::find()->where(['info_id' => $id])->andWhere(['disc' => '1'])->asArray()->one();
        if(!empty($step)){
            if(StepDescUser::find()->where(['step_id'=> $step['id']])->andWhere(['user_id' => Yii::$app->user->identity->id])->exists()){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }

    }

    public static function gehasDesk($id, $cat_id){
        $step = InfoStep::find()->where(['info_id' => $id])->andWhere(['category_id' => $cat_id])->andWhere(['disc' => '1'])->one();
        if($step){
            return true;
        }else{
            return false;
        }
    }
}