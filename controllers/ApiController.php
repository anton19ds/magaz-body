<?php

namespace app\controllers;

use app\models\CategoryInfoproduct;
use app\models\ProductMeta;
use app\models\ProductMetaLang;
use app\models\PromoUser;
use app\models\SettingData;
use Yii;
use yii\base\Controller;
use yii\helpers\ArrayHelper;

class ApiController extends Controller
{

    public $host = "http://host.docker.internal:8202/";
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'product-data' || $action->id == 'product-info') {
            Yii::$app->request->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
    public function actionCheckPromo()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (PromoUser::find()->where(['name' => $data['nick']])->exists()) {
                return false;
            } else {
                return true;
            }
        }
    }


    public function actionProductData()
    {
        $data = Yii::$app->request->get();
        $productLink = $data['productLink'];
        $lang = $data['lang'];
        $meatArray = ['0' => null];
        if ($lang == 'ru') {
            if (ProductMeta::find()->where(['value' => $productLink])->exists()) {
                $model = ProductMeta::find()->where(['value' => $productLink])->asArray()->one();
                $meta = ProductMeta::find()->where(['product_id' => $model['product_id']])->asArray()->all();
                $meatArray = ArrayHelper::map($meta, 'meta', 'value');
            }
        } else {
            if (ProductMetaLang::find()->where(['value' => $productLink])->exists()) {
                $model = ProductMetaLang::find()->where(['value' => $productLink])->asArray()->one();
                $meta = ProductMetaLang::find()->where(['product_id' => $model['product_id']])->andWhere(['tag' => $lang])->asArray()->all();
                $image = ProductMeta::find()->where(['meta' => 'image'])->andwhere(['product_id' => $model['product_id']])->asArray()->one();

                $meatArray = ArrayHelper::map($meta, 'meta', 'value');
                if (!empty($image)) {
                    $meatArray['image'] = $image['value'];
                }
            }
        }

        // https://frame.anticandida.com/api/get-product?=123123123&lang=ru
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        return $response->data = ['message' => $meatArray];

    }

    public function actionProductInfo()
    {
        $data = Yii::$app->request->get();
        $productId = $data['productId'];
        $lang = $data['lang'];

        $category = CategoryInfoproduct::find()->where(['id' => $productId])->asArray()->one();
        $meatArray = [];
        if ($lang == 'ru') {
            $product_meta = ProductMeta::find()->where(['product_id' => $category['infoproduct_id']])->asArray()->all();
            $meatArray = ArrayHelper::map($product_meta, 'meta', 'value');
        } else {
            $product_meta = ProductMetaLang::find()
                ->where(['product_id' => $category['infoproduct_id']])
                ->andWhere(['tag' => $lang])
                ->asArray()
                ->all();
            $meatArray = ArrayHelper::map($product_meta, 'meta', 'value');
            $image = ProductMeta::find()->where(['meta' => 'image'])->andwhere(['product_id' => $category['infoproduct_id']])->asArray()->one();

            if (!empty($image)) {
                $meatArray['image'] = $image['value'];
            }
        }
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        return $response->data = ['message' => $meatArray];
    }


    public function actionInfoSnipet()
    {
        $data = Yii::$app->request->get();
        $lang = $data['lang'];
        $metaArray = [];
        $siteData = SettingData::find()
            ->where([
                'or',
                ['meta' => 'seo-title'],
                ['meta' => 'seo-desc']
            ])
            ->andWhere(['lang' => $lang])
            ->asArray()
            ->all();

        if ($siteData) {
            $metaArray = ArrayHelper::map($siteData, 'meta', 'value');
        }
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        return $response->data = ['message' => $metaArray];
    }

    public function actionMapSite()
    {
        $data = Yii::$app->request->get();
        $lang = $data['lang'];
        if ($lang == 'ru') {
            $meta = ProductMeta::find()
            ->leftJoin('view_product', 'view_product.product_id = product_meta.product_id')
                ->andWhere(['view_product.status' => 1])
                ->asArray()
                ->all();
        } else {
            $meta = ProductMetaLang::find()
                ->leftJoin('view_product', 'view_product.product_id = product_meta_lang.product_id')
                ->andWhere(['view_product.status' => 1])
                ->andWhere(['product_meta_lang.tag' => $lang])
                ->asArray()
                ->orderBy('product_meta_lang.product_id')
                ->all();
        }
        $arrayResult = [];
        foreach($meta as $item){
            $arrayResult[$item['product_id']][$item['meta']] = $item['value'];
        }
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        return $response->data = ['message' => $arrayResult];
    }
}