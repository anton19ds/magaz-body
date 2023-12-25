<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Category;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\ProductMetaLang;
use app\models\PromoUser;
use app\models\User;
use app\models\UserActivePromo;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use yii\bootstrap5\BootstrapAsset;
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
                ],
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

        $category = Category::find()->asArray()->all();
        if ($lang == 'ru') {
            $model = Product::find()
                ->where(['active' => Product::STATUS_ACTIVE])
                ->asArray()
                ->with('productMeta')
                // ->andWhere(['or', ['>', 'product.col', '0'], []])
                ->all();

            foreach ($model as $key => &$item) {
                $item['productMeta'] = ArrayHelper::map($item['productMeta'], 'meta', 'value');
                $item['sort'] = $item['productMeta']['sort'];
            }


        } else {
            $query = Product::find()
                ->select('product.*,product_meta_lang.*') // make sure same column name not there in both table
                ->leftJoin('product_meta_lang', 'product_meta_lang.product_id = product.id')
                ->where(['product_meta_lang.tag' => $lang])
                // ->andWhere(['or', ['>', 'product.col', '0'], []])
                ->with('productMetaLang')
                ->groupBy('product_id')
                ->asArray()
                ->all();
            $model = Product::find()->where(['id' => ArrayHelper::getColumn($query, 'product_id')])->all();
        }
        ArrayHelper::multisort($model, ['sort'], [SORT_DESC]);

        $upsale = Product::find()
            ->with('productMeta')
            ->where(['product.active' => Product::STATUS_ACTIVE])
            ->andWhere(['product.upsale' => Product::UPSALE_ACTIVE])
            ->asArray()
            ->all();

        $this->getView()->registerCssFile("@web/css/main-page.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $promocode = null;
        if (Yii::$app->user->isGuest) {

        } else {
            if (UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->exists()) {
                $promocode = UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
            }
        }

        return $this->render('index', [
            'model' => $model,
            'currency' => $lang,
            'upsale' => $upsale,
            'promocode' => $promocode,
            'category' => $category
        ]);
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

    public function actionTest()
    {
        return $this->renderPartial('test');
    }

    public function actionTelegram()
    {
        $bot_api_key = '6249777943:AAGK4FfCtlSEfDD_72Mbi7KMVcB_CsqFefg';
        $bot_username = 'AadevMagaz_bot';

        try {
            // Create Telegram API object
            $telegram = new Telegram($bot_api_key, $bot_username);
            $telegram->useGetUpdatesWithoutDatabase();
            $telegram->handleGetUpdates();
            debug($telegram);
            $allowed_updates = [
                Update::TYPE_MESSAGE,
                Update::TYPE_CHANNEL_POST,
                // etc.
            ];
            $telegram->handleGetUpdates(['allowed_updates' => $allowed_updates]);
            debug($telegram);
            echo '123';
        } catch (TelegramException $e) {

            // Silence is golden!
            // log telegram errors
            echo $e->getMessage();
        }
    }

    public function actionPromocode()
    {
        $request = Yii::$app->request->get();
        $session = Yii::$app->session;
        $cart = $session->get('cart');

        if (Yii::$app->user->isGuest) {
            if (PromoUser::find()->where(['name' => $request['promocode']])->exists()) {
                $cart['promocode'] = $request['promocode'];
                if (!empty($cart)) {
                    if (!empty($cart['data'])) {
                        $newCartData = Cart::updateCartPromocode($cart['data'], $request['promocode']);
                        $cart['data'] = $newCartData['cart'];
                        $cart['totalData'] = $newCartData['totalData'];
                    }
                }
            }
            $session->set('cart', $cart);
            return $this->goHome();
        } else {


            if (PromoUser::find()->where(['name' => $request['promocode']])->andWhere(['!=', 'user_id', Yii::$app->user->identity->id])->exists()) {

                $model = PromoUser::find()->where(['name' => $request['promocode']])->andWhere(['!=', 'user_id', Yii::$app->user->identity->id])->asArray()->one();
                if (!UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->exists()) {
                    $userActivePromo = new UserActivePromo([
                        'user_id' => Yii::$app->user->identity->id,
                        'promo_id' => $model['id']
                    ]);
                    if (!$userActivePromo->save()) {
                        debug($userActivePromo->getErrors());
                    };
                    $cart['promocode'] = $request['promocode'];
                    $session->set('cart', $cart);
                    return $this->goHome();
                } else {

                    $UserActivePromo = UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
                    $promocode = PromoUser::findOne($UserActivePromo->promo_id);
                    $cart['promocode'] = $promocode['name'];
                    $session->set('cart', $cart);
                    echo "У вас есть подписка!";
                }
            } else {
                return $this->goHome();
            }
        }
    }



    public function updateCart()
    {
        $user = Yii::$app->user->identity->id;
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        $arrayPromo = $session->get('promo');
        //debug($user);
        //debug($arrayPromo);
        //debug($cart);
    }
}