<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Category;
use app\models\CategoryLang;
use app\models\MailMessage;
use app\models\SettingData;
use app\models\TelegramChatList;
use app\models\UserReport;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Product;
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



    public function beforeAction($action)
    {
        if (in_array($action->id, ['telegram'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($lang = null, $sort = null)
    {
        Yii::$app->language = mb_strtolower($lang) . "-" . mb_strtoupper($lang);
        $arraProduct = [];
        $model = Product::find()
            ->where(['active' => Product::STATUS_ACTIVE]);

        if ($sort) {
            $model = $model->where(['category' => $sort]);
        }
        $model = $model->orderBy(['sort' => SORT_DESC])->all();
        if ($lang == 'ru') {
            $category = Category::find()->orderBy(['id' => SORT_DESC])->asArray()->all();
            $category = ArrayHelper::map($category, 'id', 'title');
        } else {
            $category = CategoryLang::find()->where(['lang' => $lang])->orderBy(['category_id' => SORT_DESC])->asArray()->all();
            $category = ArrayHelper::map($category, 'category_id', 'title');
        }
        $upsale = Product::find()
            ->with('productMeta')
            ->where(['product.active' => Product::STATUS_ACTIVE])
            ->andWhere(['product.upsale' => Product::UPSALE_ACTIVE])
            ->asArray()
            ->all();
        $promocode = null;
        if (Yii::$app->user->isGuest) {
        } else {
            if (UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->exists()) {
                $promocode = UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
            }
        }
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        $mainBanner = SettingData::find()->where(['meta' => 'main-banner'])->asArray()->one();
        $mainImag = null;
        if(isset($mainBanner) && isset($mainBanner['value']) && !empty($mainBanner['value'])){
            $arrayImg = json_decode($mainBanner['value'], true);
            $mainImag = $arrayImg['array'][1]['value'];
        }
        return $this->render('main',[
            'model' => $model,
            'currency' => $lang,
            'category' => $category,
            'sort' => $sort,
            'mainImag' => $mainImag
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



    public function actionPromocode()
    {
        $server = $_SERVER;
        
        $request = Yii::$app->request->get();
        $lang = $request["lang"];
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        $url = "";
        if (Yii::$app->user->isGuest) {
            if (PromoUser::find()->where(['name' => $request['promocode']])->exists()) {
                $model = PromoUser::find()->where(['name' => $request['promocode']])->one();
                if(!UserReport::find()->where(['ip' => $server['HTTP_CF_CONNECTING_IP']])->andWhere(['promocode_id' => $model->id])->exists()){
                    $userReport = new UserReport([
                        'user_data' => serialize($server),
                        'ip' => $server['HTTP_CF_CONNECTING_IP'],
                        'count' => $server['HTTP_CF_IPCOUNTRY'],
                        'promocode_id' => (string)$model->id,
                    ]);
                    if(!$userReport->save()){
                        var_dump($userReport->getErrors());
                    }
                }
                if(empty($cart['promocode'])){
                    $cart['promocode'] = $request['promocode'];
                }
                
                $session->set('cart', $cart);
                if($model->link != '/'){
                    $url = $model->link;
                }else{
                    $url = $lang;    
                }
             }else{
                $url = $lang;
             }
         } else {
            if (PromoUser::find()->where(['name' => $request['promocode']])->andWhere(['!=', 'user_id', Yii::$app->user->identity->id])->exists()) {
                $model = PromoUser::find()->where(['name' => $request['promocode']])->andWhere(['!=', 'user_id', Yii::$app->user->identity->id])->asArray()->one();
                if (!UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->exists()) {
                    if(!UserReport::find()->where(['ip' => $server['HTTP_CF_CONNECTING_IP']])->andWhere(['promocode_id' => $model['id']])->exists()){
                    $userReport = new UserReport([
                        'user_data' => serialize($server),
                        'ip' => $server['HTTP_CF_CONNECTING_IP'],
                        'count' => $server['HTTP_CF_IPCOUNTRY'],
                        'promocode_id' => (string)$model['id'],
                    ]);
                    if(!$userReport->save()){
                        var_dump($userReport->getErrors());
                    }
                }
                    $userActivePromo = new UserActivePromo([
                        'user_id' => Yii::$app->user->identity->id,
                        'promo_id' => $model['id']
                    ]);
                    if (!$userActivePromo->save()) {
                        debug($userActivePromo->getErrors());
                    };
                    $cart['promocode'] = $request['promocode'];
                    $session->set('cart', $cart);
                    $url = $model['link'];
                } else {
                    $UserActivePromo = UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
                    $promocode = PromoUser::findOne($UserActivePromo->promo_id);
                    $cart['promocode'] = $promocode['name'];
                    $session->set('cart', $cart);
                    $url = $model['link'];
                }
            } else {
                $url = $lang;
            }
        }
        return $this->render('compare', [
            'url' => $url,
            'lang' => $lang

        ]);
        //$this->getView()->registerJs("alert(123)");
    }

    public function actionHook()
    {
        
        $bot_api_key = '6249777943:AAGK4FfCtlSEfDD_72Mbi7KMVcB_CsqFefg';
        $bot_username = 'AadevMagaz_bot';
        $hook_url = 'https://frame.anticandida.com/ru/telegram';

        try {
            // Create Telegram API object
            $telegram = new Telegram($bot_api_key, $bot_username);
            // Set webhook

            $result = $telegram->setWebhook($hook_url);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {
            // log telegram errors
            echo $e->getMessage();
        }
    }

    public function actionTelegram()
    {
        $data = file_get_contents('php://input'); 
        $data = json_decode($data, true);
        if (isset($data['message']['chat']['id']) && !empty($data['message']['chat']['id'])) {
            if (!TelegramChatList::find()->where(['chat' => $data['message']['chat']['id']])->exists()) {
                $model = new TelegramChatList([
                    'chat' => $data['message']['chat']['id'],
                    'name' => $data['message']['chat']['username'],
                    'description' => 'member'
                ]);
                if ($model->save()) {
                    return true;
                } else {
                    Yii::debug(debug($model->getErrors()));
                }
            }
        }
    }

    public function updateCart()
    {
        $user = Yii::$app->user->identity->id;
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        $arrayPromo = $session->get('promo');
    }
}