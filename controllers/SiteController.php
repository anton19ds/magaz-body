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
use app\models\ProductMetaLang;
use app\models\User;
use yii\helpers\ArrayHelper;

class SiteController extends MainController
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($lang = null)
    {
        if ($lang == 'ru') {
            $model = Product::find()
                ->where(['active' => Product::STATUS_ACTIVE])
                ->all();
        } else {
            $query = Product::find()
                ->select('product.*,product_meta_lang.*') // make sure same column name not there in both table
                ->leftJoin('product_meta_lang', 'product_meta_lang.product_id = product.id')
                ->where(['product_meta_lang.tag' => $lang])
                ->with('productMetaLang')
                ->groupBy('product_id')
                ->asArray()
                ->all();
            $model = Product::find()->where(['id' => ArrayHelper::getColumn($query, 'product_id')])->all();
        }

        $upsale = Product::find()
            ->with('productMeta')
            ->where(['product.active' => Product::STATUS_ACTIVE])
            ->andWhere(['product.upsale' => Product::UPSALE_ACTIVE])
            ->asArray()
            ->all();
        return $this->render('index', [
            'model' => $model,
            'currency' => $lang,
            'upsale' => $upsale
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegistration()
    {
        $model = new User();
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();

            if ($model->load($data) && $model->validate()) {
                if ($data['User']['password'] === $data['User']['rePass']) {
                    if (!$model->save()) {
                        return var_dump($model->getErrors());
                    } else {
                        $login = new LoginForm([
                            'username' => $model->username,
                            'password' => $model->password,
                            'rememberMe' => $data['User']['rememberMe']
                        ]);
                        if ($login->login()) {
                            return var_dump('login');
                        } else {
                            return var_dump('no login');
                        }
                    }
                } else {
                    return var_dump('no-pass');
                }

            } else {
                return var_dump($model->getErrors());
            }
            return $this->refresh();
        }
        return $this->render('registration', [
            'model' => $model
        ]);
    }
}