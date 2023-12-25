<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\ProductMeta;
use app\models\ProductMetaLang;
use app\models\Reviews;
use app\models\User;
use yii\bootstrap5\BootstrapAsset;
use yii\httpclient\Client;

class ProductController extends Controller
{


    public function actionIndex($index)
    {

        $request = Yii::$app->request->get();
        $currency = $request['lang'];
        Yii::$app->language = mb_strtolower($currency) . "-" . mb_strtoupper($currency);
        if ($currency == 'ru') {
            $metaProduct = ProductMeta::find()->where(['value' => $index])->andWhere(['meta' => 'link'])->one();
        } else {
            $metaProduct = ProductMetaLang::find()->where(['value' => $index])->andWhere(['meta' => 'link'])->andWhere(['tag' => $currency])->one();
        }
        try {
            $model = Product::findOne($metaProduct->product_id);
        } catch (\Exception $e) {
            return $this->goHome();
        }
        $metaArray = $model->arrayMeta($currency);
        $url = "http://body-dev.na4u.ru/api/v1/content";
        $result = $this->CrosReqyest($model->getParam('content', $currency), $url);

        $this->getView()->registerCssFile("@web/css/products.css", [
            'depends' => [BootstrapAsset::class],
        ]);

        $reviews = Reviews::find()


            ->select(['reviews.*', 'uid' => 'user.id', 'user.firstName', 'user.LastName', 'user.secondName'])
            ->leftJoin('user', 'reviews.user_id=user.id')
            ->where(['reviews.product_id' => $model->id])
            ->groupBy('reviews.id')
            ->asArray()
            ->all();

        $this->getView()->registerCssFile("@web/css/main-page.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $reviewsForm = new Reviews();


        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if ($reviewsForm->load($data)) {
                if ($reviewsForm->save()) {
                    return $this->refresh();
                } else {
                    debug($reviewsForm->getErrors());
                }
            } else {
                debug($reviewsForm->getErrors());
            }

        }
        return $this->render('index', [
            'reviewsForm' => $reviewsForm,
            'model' => $model,
            'result' => $result,
            'currency' => $currency,
            'metaArray' => $metaArray,
            'reviews' => $reviews
        ]);
    }

    private function CrosReqyest($id, $url)
    {
        $client = new Client(['baseUrl' => $url]);
        $response = $client->createRequest()
            ->setMethod('POST')
            ->addHeaders(['content-type' => 'application/json'])
            ->addHeaders(['apikey' => 'yii2-magaz-hash'])
            ->setData(['post_id' => $id])
            ->send();
        return $response->data;
    }
}