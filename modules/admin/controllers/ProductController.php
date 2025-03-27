<?php

namespace app\modules\admin\controllers;

use app\assets\AdminAsset;
use app\models\Currencies;
use app\models\Product;
use app\models\ProductMeta;
use app\models\ProductMetaLang;
use app\models\ViewProduct;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `admin` module
 */
class ProductController extends MainController
{
    public $arrayData = array(
        'productName' => 'Наименование',
        'shortName' => 'Короткое Наименование',
        'shortDescription' => 'Короткое Описание',
        'link' => 'Постоянная Ссылка',
        'description' => 'Описание',
        'content' => 'Содержание',
        'with-this-product' => 'С этим товаром берут',
        'visible' => 'Видимость',
        'label' => 'Лейбл',
        'seo-descrip' => 'Снипет текст',
        'seo-title' => 'Снипет заголовок'
        
    );

    public $pricePacData = array(
        'pricePac-1' => 'pac1',
        'pricePac-2' => 'pac2',
        'pricePac-3' => 'pac3',
    );
    public function actionIndex($sort = null)
    {

        $this->title = 'Список товаров';
        $this->preTitle = 'товары магазина';
        $this->actionType = '/admin/product/create';
        if (Yii::$app->request->isPost) {
            debug(Yii::$app->request->post());
        }
        $model = Product::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => 50,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
        ]);
        $this->view->registerJsFile('/adminStyle/product.js', ['depends' => AdminAsset::className()]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'title' => $this->title,
            'preTitle' => $this->preTitle,
            'actionType' => $this->actionType,
            'pricePacData' => $this->pricePacData,
        ]);
    }

    public function actionCreate()
    {

        $this->title = 'Новый товар';
        $model = new Product();
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if ($model->load($data)) {
                if ($model->save()) {
                    $data['productMeta']['type'] = "simple";
                    $meta = $this->saveNewMeta($model->id, $data['productMeta']);
                    if ($meta) {
                        return $meta;
                    }
                }
            }
            return $this->redirect(['update', 'id' => $model->id]);
        }
        $this->view->registerJsFile('/adminStyle/product.js', ['depends' => AdminAsset::className()]);
        return $this->render('create', [
            'model' => $model,
            'arrayData' => $this->arrayData
        ]);
    }



    public function actionSetUrl()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (ProductMeta::find()->where(['value' => $data['word']])->exists()) {
                $linker = ProductMeta::find()->where(['value' => $data['word']])->max('id')->asArray()->one();
                $newid = (int) $linker['id'] + 1;
                $link = $data['word'] + $newid;
            } else {
                $link = $data['word'];
            }

            $obj = "<a href='" . $data['url'] . "/" . $link . "' target=_blank>" . $data['url'] . "/" . $link . "</a>";
            $data = [
                'obj' => $obj,
                'link' => $link
            ];
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    public function actionImageList()
    {
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            foreach ($data['array'] as $item => $el) {
                if ($el['name'] == '_csrf') {
                    unset($data['array'][$item]);
                }
            }
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;

            $response->data = [
                'data' => json_encode($data),
                'render' => $this->renderPartial('view', [
                    'data' => $data
                ])
            ];
        }
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request->get();
        $currensy = Currencies::find()->all();
        $navLangStr = '<ul><li><a href="/admin/product/update?id=' . $id . '" class="'. (!isset($request['lang']) ? 'active' : '') .'">RU</a></li>';
        foreach ($currensy as $item) {
            $navLangStr .= '<li><a href="/admin/product/update?id=' . $id . '&lang=' . $item->tag . '"   class="'. (isset($request['lang']) && $item->tag == $request['lang']? 'active' : '') .'">' . $item->tag . '</a></li>';
        }
        $navLangStr .= "</ul>";
        $this->lang = $navLangStr;
        $model = Product::findOne($id);
        if (isset($request['lang']) && $request['lang'] != 'ru') {

            $modelMeta = ProductMetaLang::find()->where(['product_id' => $id])->andWhere(['tag' => $request['lang']])->asArray()->all();
            $meta = ArrayHelper::map($modelMeta, 'meta', 'value');
            $this->view->registerJsFile('/adminStyle/product.js', ['depends' => AdminAsset::className()]);

            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post();
                $metaData = $this->saveNewMetaLang($model->id, $data['productMeta'], $request['lang']);
                if ($metaData) {
                    debug($metaData);
                }
                return $this->refresh();
            }
            return $this->render('update', [
                'model' => $model,
                'meta' => $meta,
                'arrayData' => $this->arrayData,
                'lang' => $request['lang'],
                'pricePacData' => $this->pricePacData,
            ]);
        } else {
            $modelMeta = $model->getProductMetas()->asArray()->all();
            $meta = ArrayHelper::map($modelMeta, 'meta', 'value');
            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post();
                if ($model->load($data) && $model->save()) {
                    $metaData = $this->saveNewMeta($model->id, $data['productMeta']);
                } else {
                    return var_dump($model->getErrors());
                }
                return $this->refresh();
            }
            $this->view->registerJsFile('/adminStyle/product.js', ['depends' => AdminAsset::className()]);
            return $this->render('update', [
                'model' => $model,
                'meta' => $meta,
                'arrayData' => $this->arrayData,
                'lang' => null,
                'pricePacData' => $this->pricePacData,
            ]);
        }

    }

    public function actionStapUpdate()
    {
        if (Yii::$app->request->isAjax) {
            $lang = Currencies::find()->asArray()->all();
            $lang[] = [
                'tag' => 'ru'
            ];
            $data = Yii::$app->request->post();
            $model = Product::find()->where(['id' => $data['id']])->with('viewProduct')->one();
            $LangTag = [];
            foreach($lang as $key){
                $LangTag[] = [
                    'tag' => strtoupper($key['tag'])
                ];
            }
            return $this->renderAjax('update-fast', [
                'LangTag' => $LangTag,
                'lang' => $lang,
                'data' => $data,
                'model' => $model
            ]);
        }
    }


    public function actionValideteProduct()
    {
        $request = \Yii::$app->getRequest();
        if ($request->post()) {
            $data = $request->post();
            $model = Product::findOne($data['Product']['id']);
            $model->price = $data['Product']['price'];
            $model->sale = $data['Product']['sale'];
            $model->raite = $data['Product']['raite'];
            if ($model->save()) {
                $this->saveUpdateMeta($data['Product']['id'], $data["productMeta"]);
            } else {
                var_dump($model->getErrors());
            }
            if(isset($data['View']) && !empty($data['View'])){
                foreach($data['View'] as $key => $elem){
                    if(ViewProduct::find()->where(['product_id' => $data['Product']['id']])->andWhere(['tag' => $key])->exists()){
                        $viewProduct = ViewProduct::find()->where(['product_id' => $data['Product']['id']])->andWhere(['tag' => $key])->one();
                        $viewProduct->status = $elem;
                    }else{
                        $viewProduct = new ViewProduct([
                            'product_id' => $data['Product']['id'],
                            'tag' => $key,
                            'status' => $elem
                        ]);
                    }
                    $viewProduct->save();
                }
            }
        }
        // return true;
    }


    public function saveUpdateMeta($product_id, $data)
    {
        if (isset($data['productName']) && empty($data['productName'])) {
            $data['productName'] = "Товар #" . $product_id;
        }
        if (isset($data['link']) && empty($data['link'])) {
            $data['link'] = "tovar-" . $product_id;
        }
        foreach ($data as $key => $value) {
            $lets = $this->UpsertProductMeta(['meta' => $key, 'value' => $value], $product_id);
            if ($lets) {
                return $lets;
            }
        }
        return false;
    }


    public function actionSave()
    {
        $request = \Yii::$app->getRequest();
        print_r($request->post());
    }


    public function actionDelete($id)
    {
        $model = Product::find()->where(['id' => $id])->one();
        $model->delete();
        ProductMeta::deleteAll(['product_id' => $id]);
        ProductMetaLang::deleteAll(['product_id' => $id]);
        return $this->redirect('index');
    }

    private function UpsertProductMeta(array $data, $id)
    {
        if (ProductMeta::find()->where(['product_id' => $id])->andWhere(['meta' => $data['meta']])->exists()) {
            $model = ProductMeta::find()->where(['product_id' => $id])->andWhere(['meta' => $data['meta']])->one();
            $model->value = $data['value'];
        } else {
            $model = new ProductMeta([
                'product_id' => $id,
                'meta' => $data['meta'],
                'value' => $data['value']
            ]);
        }
        if ($model->save()) {
            return false;
        } else {
            return var_dump($model->getErrors());
        }
    }

    private function saveNewMeta($product_id, $data)
    {   if(isset($data['product'])){
        $data['product'] = json_encode($data['product']);
        }
        if(isset($data['with-this-product'])){
            $data['with-this-product'] = json_encode($data['with-this-product']);
            }
        
        if(isset($data['params_text_1'])){
            $data['params_text_1'] = serialize($data['params_text_1']);
        }
        if(isset($data['params_text_2'])){
            $data['params_text_2'] = serialize($data['params_text_2']);
        }
        if (isset($data['productName']) && empty($data['productName'])) {
            $data['productName'] = "Товар #" . $product_id;
        }
        if (isset($data['link']) && empty($data['link'])) {
            $data['link'] = "tovar-" . $product_id;
        }
        foreach ($data as $key => $value) {
            if (ProductMeta::find()->where(['product_id' => $product_id])->andWhere(['meta' => $key])->exists()) {
                $model = ProductMeta::find()->where(['product_id' => $product_id])->andWhere(['meta' => $key])->one();
                $model->value = $value;
            } else {
                $model = new ProductMeta([
                    'product_id' => $product_id,
                    'meta' => $key,
                    'value' => $value
                ]);
            }

            if (!$model->save()) {
                return var_dump($model->getErrors(), $key);
            }
        }
        return false;
    }

    private function saveNewMetaLang($product_id, $data, $lang)
    {
        if(isset($data['product'])){
            $data['product'] = json_encode($data['product']);
            }
            if(isset($data['params_text_1'])){
                $data['params_text_1'] = serialize($data['params_text_1']);
            }
            if(isset($data['params_text_2'])){
                $data['params_text_2'] = serialize($data['params_text_2']);
            }
            if (isset($data['productName']) && empty($data['productName'])) {
                $data['productName'] = "Товар #" . $product_id;
            }
            if (isset($data['link']) && empty($data['link'])) {
                $data['link'] = "tovar-" . $product_id;
            }
        $productType = ProductMeta::find()->where(['product_id' => $product_id])->where(['meta' => 'type'])->one();
        $data['type'] = $productType->value;
        foreach ($data as $key => $value) {
            if (ProductMetaLang::find()->where(['product_id' => $product_id])->andWhere(['meta' => $key])->andWhere(['tag' => $lang])->exists()) {
                $model = ProductMetaLang::find()->where(['product_id' => $product_id])->andWhere(['meta' => $key])->andWhere(['tag' => $lang])->one();
                $model->value = $value;
            } else {
                $model = new ProductMetaLang([
                    'product_id' => $product_id,
                    'meta' => $key,
                    'value' => $value,
                    'tag' => $lang
                ]);
            }

            if (!$model->save()) {
                return var_dump($model->getErrors());
            }
        }
        return false;
    }
}