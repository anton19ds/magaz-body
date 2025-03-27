<?php
namespace app\controllers;

use app\models\AccessInfoProduct;
use app\models\Cart;
use app\models\Delivery;
use app\models\Gpwebpay;
use app\models\MailMessage;
use app\models\MessageSendOrder;
use app\models\Orders;
use app\models\OrdersMeta;
use app\models\UserReport;
use app\models\ViewDelivery;
use Yii;
use app\models\Product;
use app\models\ProductMeta;
use app\models\Promocod;
use app\models\PromoUser;
use app\models\User;
use app\models\UserActivePromo;
use app\models\UserAdress;
use Exception;
use yii\bootstrap5\BootstrapAsset;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\web\Controller;

class CartController extends Controller
{
    public $promocode = null;

    public $currensy = null;

    public function beforeAction($action)
    {
        $request = Yii::$app->request->get();
        if (isset($request['lang'])) {
            $this->currensy = $request['lang'];
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        if (!Yii::$app->user->isGuest) {
            if (UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->exists()) {
                $userActivePromo = UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
                if (PromoUser::find()->where(['id' => $userActivePromo->promo_id])->exists()) {
                    $promoUser = PromoUser::find()->where(['id' => $userActivePromo->promo_id])->one();
                    $cart['promocode'] = $promoUser->name;
                    $session->set('cart', $cart);

                }
            }
        }
        if (empty($cart['data'])) {
            return $this->goHome();
        }
        $product = Product::find()->where(['id' => array_keys($cart['data'])])->all();
        return $this->render('cart-index', [
            'cart' => $cart,
            'currensy' => $this->currensy,
            'product' => $product
        ]);
    }

    public function actionOrder()
    {
        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        //$session->remove('cart');
        // $cart = $session->get('cart');
        if (!isset($cart['data']) || empty($cart['data'])) {
            return $this->goHome();
        }

        $product = Product::find()->where(['id' => array_keys($cart['data'])])->all();
        if (!empty($promocodeArray)) {
            $this->promocode = $promocodeArray['promo'];
        }
        if (Yii::$app->user->isGuest) {
            return $this->render('order-page', [
                'cart' => $cart,
                'currensy' => $this->currensy,
                'promocode' => $this->promocode,
                'lang' => $this->currensy,
                'product' => $product
            ]);
        } else {
            $user_id = Yii::$app->user->identity->id;
            $user = User::findOne($user_id);

            if (isset($cart['promocode'])) {
                $promocode = PromoUser::find()->where(['name' => $cart['promocode']])->asArray()->one();
                if ($promocode['user_id'] == Yii::$app->user->identity->id) {
                    unset($cart['promocode']);
                    $result = $this->updateCart($cart);
                    $cart = $result['cart'];
                    $session->set('cart', $cart);
                }
            }
            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post();
                if ($data['activeAdress'] != 'newAdress') {
                    $dataUser = $data['activeAdress'];
                } else {
                    $dataUser = [
                        'country' => $data['country'],
                        'postcode' => $data['postcode'],
                        'city' => $data['city'],
                        'area' => $data['area'],
                        'street' => $data['street'],
                        'house' => $data['house'],
                        'surname' => $data['surname'],
                        'name' => $data['name'],
                        'lastname' => $data['lastname'],
                        'phone' => $data['phone'],
                        'comment' => $data['comment'],
                        'email' => $data['email'],
                    ];
                }
                $cart['user'] = $dataUser;
                $session->set('cart', $cart);
                $this->redirect(['/' . $this->currensy . '/' . 'delivery']);
            }
            return $this->render('order-page-user', [
                'user' => $user,
                'cart' => $cart,
                'currensy' => $this->currensy,
                'lang' => $this->currensy,
                'product' => $product
            ]);
        }
    }
    public function actionDelivery()
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        if (Yii::$app->request->isAjax) {
            //$session = Yii::$app->session;
            //$cart = $session->get('cart');
            $data = Yii::$app->request->post();
            //debug($data);
            $dataArray = ArrayHelper::map($data["form"], "name", "value");
            //debug($dataArray);
            $cart['delivery'] = $dataArray['del'];
            $cart['delivery_summ'] = Cart::getSummType()[$dataArray['del']];
            $session->set('cart', $cart);
                return true;
        }

        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);
        
        if (empty($cart) || empty($cart['data'])) {
            return $this->goHome();
        }
        $productType = [];
        foreach ($cart['data'] as $key => $value) {
            $productType[] = Product::getTypeInProduct($key);
        }
        
        $product = Product::find()->where(['id' => array_keys($cart['data'])])->all();
        $viewDelivery = ViewDelivery::find()->asArray()->all();
        $resViewDelivery = [];
        foreach ($viewDelivery as $rt => $ty) {
            $resViewDelivery[$ty['data']][$ty['meta']] = $ty['value'];
        }
        return $this->render('delivery', [
            'currensy' => $this->currensy,
            'user' => $this->normalizeUser($cart['user']),
            'cart' => $cart,
            'product' => $product,
            'resViewDelivery' => $resViewDelivery,
            'productType' => $productType
        ]);
    }

    public function actionPayment()
    {
        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);

        $session = Yii::$app->session;
        $cart = $session->get('cart');
        //debug($cart);
        if (!$cart) {
            return $this->goHome();
        }
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if (!isset($data['pay']) || empty($data['pay'])) {
                return $this->refresh();
            }
            $cart['pay'] = $data['pay'];
            $session->set('cart', $cart);
            return $this->redirect('/' . $this->currensy . '/final-payment');
        }
        $product = Product::find()->where(['id' => array_keys($cart['data'])])->all();
        return $this->render('payment', [
            'product' => $product,
            'currensy' => $this->currensy,
            'user' => $this->normalizeUser($cart['user']),
            'cart' => $cart,
        ]);
    }

    protected function normalizeUser($userId)
    {
        if (isset($userId['activeAdress']) && $userId['activeAdress'] != 'newAdress') {
            $userId = $userId['activeAdress'];
            $user = UserAdress::find()->where(['id' => $userId])->asArray()->one();
            $dataUser = User::find()->where(['id' => Yii::$app->user->identity->id])->asArray()->one();
            $user['email'] = $dataUser['email'];
            $user['phone'] = $dataUser['phone'];
            $user['house'] = $user['flat'];
            return $user;
        } else {
            return $userId;
        }
    }
    public function actionFinalPayment()
    {

        $session = Yii::$app->session;
        $request = Yii::$app->request->get();
        $cart = $session->get('cart');
        if (empty($cart) || empty($cart['data'])) {
            return $this->goHome();
        }
        if (!Yii::$app->user->isGuest) {
            if (is_array($cart['user'])) {
                $user = User::findOne(Yii::$app->user->identity->id);

                $userId = $user->updateUser($this->normalizeUser($cart['user']));
                $userAdress = new UserAdress();
                if (isset($cart['user']['activeAdress']) && UserAdress::find()->where(['id' => $cart['user']['activeAdress']])->exists()) {
                    $adressId = $cart['user']['activeAdress'];
                } else {
                    $name = [
                        'surname' => $cart['user']['surname'],
                        'name' => $cart['user']['name'],
                        'lastname' => $cart['user']['lastname']
                    ];

                    $adressId = $userAdress->updateAdress($this->normalizeUser($cart['user']), $userId, $name);
                }

                $data = $this->createNewOrder($cart['data'], $user_id = Yii::$app->user->identity->id, $cart, $adressId, $request['lang']);
                $this->AccessInfocurse($cart['data'], $data, $userId);
            } else {
                $userAdress = UserAdress::find()
                    ->where(['id' => $cart['user']])
                    ->asArray()
                    ->one();
                $user = User::find()
                    ->where(['id' => Yii::$app->user->identity->id])
                    ->asArray()
                    ->one();

                $data = $this->createNewOrder($cart['data'], $user_id = Yii::$app->user->identity->id, $cart, $adressId = $cart['user'], $request['lang']);
                $this->AccessInfocurse($cart['data'], $data, $userId = Yii::$app->user->identity->id);
                $infoArray = [];
            }
        } else {
            $newPassword = uniqid();
            $user = new User([
                'username' => $cart['user']['email'],
                'password' => $newPassword,
                'email' => $cart['user']['email'],
                'firstName' => $cart['user']['surname'],
                'LastName' => $cart['user']['name'],
                'secondName' => $cart['user']['lastname'],
                'phone' => $cart['user']['phone'],
                'lang' => $request['lang']
            ]);
            $message = MailMessage::SendRegistration($this->currensy, $cart['user']['email'], $newPassword);
            if ($user->save()) {
                $userAdress = new UserAdress([
                    'postcode' => $cart['user']['postcode'],
                    'city' => $cart['user']['city'],
                    'country' => $cart['user']['country'],
                    'user_id' => $user->id,
                    'area' => $cart['user']['area'],
                    'flat' => $cart['user']['house'],
                    'street' => $cart['user']['street'],
                    'name' => $cart['user']['name'],
                    'surname' => $cart['user']['surname'],
                    'lastname' => $cart['user']['lastname']
                ]);


                if (!$userAdress->save()) {
                    return '3';
                }
                $user->login();
                $data = $this->createNewOrder($cart['data'], $user_id = $user->id, $cart, $adressId = $userAdress->id, $request['lang']);
                $this->AccessInfocurse($cart['data'], $data, $userId = $user->id);
            }
        }
        //debug($data);
        if ($cart['pay'] == 'card') {
            $this->redirect(['/' . $this->currensy . '/' . "payment-card-succes?orderId={$data['uiid']}"]);
        }
        if ($cart['pay'] == 'inteleckt') {
            MailMessage::TelegramMessage($data['id']);
            $this->redirect(['/' . $this->currensy . '/' . "intellect-payment?orderId={$data['uiid']}"]);
        }
        if ($cart['pay'] == 'trisby') {
            $this->redirect(['/' . $this->currensy . '/' . "payment-trisby-succes?orderId={$data['uiid']}"]);
        }
        if ($cart['pay'] == 'yandex') {
            $this->redirect(['/' . $this->currensy . '/' . "yandex?orderId={$data['uiid']}"]);
        }
        if ($cart['pay'] == 'webpay') {
            $this->redirect(['/' . $this->currensy . '/' . "webpay?orderId={$data['uiid']}"]);
        }
    }



    public function actionWebpay($orderId = null)
    {
        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);
        $session = Yii::$app->session;
        $session->remove('cart');
        $request = Yii::$app->request->get();
        $order = Orders::find()
            ->where(['uuid' => $request['orderId']])
            ->with('ordersMeta')
            ->with('user')
            ->one();
        $this->getView()->registerCssFile("@web/css/page-success.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $product = Product::find()->where(['id' => array_keys(unserialize($order->data_order))])->all();
        $orderList = unserialize($order->data_order);
        $viewData = [];
        foreach ($product as $item) {
            $priceData = Product::getPriceProductbyId($item->id, $this->currensy);
            $type = $item->getParam('type', null);
            $image = $item->getParam('image', null);
            $link = $item->getParam('link', $this->currensy);
            $name = $item->getParam('shortName', $this->currensy);
            if ($orderList[$item->id]['count'] == 1) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-1']['sale']) && $priceData['productPac']['pricePac-1']['sale']) {
                    $price = $priceData['productPac']['pricePac-1']['sale'];
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            } else if ($orderList[$item->id]['count'] == 2) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-2']['sale']) && $priceData['productPac']['pricePac-2']['sale']) {
                    $price = $priceData['productPac']['pricePac-2']['sale'];
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            } else if ($orderList[$item->id]['count'] >= 3) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-3']['sale']) && $priceData['productPac']['pricePac-3']['sale']) {
                    $price = $priceData['productPac']['pricePac-3']['sale'];
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            }
            $sert = [
                'id' => $item->id,
                'name' => $name,
                'count' => $orderList[$item->id]['count'],
                'prose' => $price
            ];
            $viewData['product'][] = $sert;
        }
        ;
        if (!empty($order->ordersMeta->coupon)) {
            $viewData['coup'] = [
                'name' => $order->ordersMeta->coupon_name,
                'sum' => $order->ordersMeta->coupon_summ
            ];
        }

        if (!empty($order->ordersMeta->promocode)) {
            $viewData['promo'] = [
                'name' => $order->ordersMeta->promoUser->name,
                'sum' => Cart::PromocodeSizeSale(['data' => $orderList], $product, $order->cyrrency, $order->ordersMeta->promocode, true)
            ];
        }

        if (!empty($order->ordersMeta->shiping_type) && $order->ordersMeta->shiping_type != 'info') {
            $viewData['del'] = $order->getShipingSumm();
        }
        $viewData['total'] = Cart::totalSumm(
            ['data' => $orderList],
            $product,
            $this->currensy,
            $order->ordersMeta->coupon_name,
            $order->ordersMeta->promocode,
            $order->ordersMeta->shiping_type,
            true,
            $order->id,
            $order->ordersMeta->userAdress->postcode
        );
        $attr = array(
            'order_id' => $order->id,
            'lastname' => $order->ordersMeta->userAdress->surname,
            'name' => $order->ordersMeta->userAdress->name,
            'surname' => $order->ordersMeta->userAdress->lastname,
            'phone' => $order->user->phone,
            'email' => $order->user->email,
            'postcode' => $order->ordersMeta->userAdress->postcode,
            'country' => $order->ordersMeta->userAdress->country,
            'city' => $order->ordersMeta->userAdress->city,
            'area' => $order->ordersMeta->userAdress->area,
            'home' => $order->ordersMeta->userAdress->street,
            'flat' => $order->ordersMeta->userAdress->flat,
            'comment' => $order->ordersMeta->comment,
            'viewData' => $viewData,
            'username' => $order->user->email,
        );
        $setSale = 0;
        
        if (isset($viewData['promo']) && !empty($viewData['promo']) && isset($viewData['promo']['sum']) && !empty($viewData['promo']['sum'])) {
            $setSale = $viewData['promo']['sum'] / count($viewData['product']);
        }

        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);
        $session = Yii::$app->session;
        $session->remove('cart');
        $request = Yii::$app->request->get();
        $order = Orders::find()
            ->where(['uuid' => $request['orderId']])
            ->with('ordersMeta')
            ->with('user')
            ->one();
        $product = Product::find()->where(['id' => array_keys(unserialize($order->data_order))])->all();
        $orderList = unserialize($order->data_order);
        $cart = array();
        $setData = Orders::find()->where(['uuid' => $orderId])->one();
        $cartMeta = OrdersMeta::find()->where(['order_id' => $setData->id])->one();
        $user = User::find()->where(['id' => $setData->user_id])->asArray()->one();
        $userAdress = UserAdress::find()->where(['id' => $cartMeta->adress_shipig])->asArray()->one();
        $this->getView()->registerCssFile("@web/css/page-success.css", [
            'depends' => [BootstrapAsset::class],
        ]);


        //MailMessage::TelegramMessage($order->id);
        

       $totalSumm = Cart::totalSumm(
            ['data' => $orderList],
            $product,
            $this->currensy,
            $order->ordersMeta->coupon_name,
            $order->ordersMeta->promocode,
            $order->ordersMeta->shiping_type,
            true,
            $order->id,
            $order->ordersMeta->userAdress->postcode
       );
       $linkPayment =  Gpwebpay::genLink($totalSumm);
        return $this->render('prew-view-webpay', [
            'cartMeta' => $cartMeta,
            'cart' => $cart,
            'user' => $user,
            'userAdress' => $userAdress,
            'data' => $orderId,
            'currency' => $this->currensy,
            'order' => $order,
            'linkPayment' => $linkPayment,
            'product' => $product,
            'orderList' => $orderList,
        ]);
    }






    public function actionYandex($orderId)
    {
        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);
        $session = Yii::$app->session;
        $session->remove('cart');
        $request = Yii::$app->request->get();
        $order = Orders::find()
            ->where(['uuid' => $request['orderId']])
            ->with('ordersMeta')
            ->with('user')
            ->one();
        $this->getView()->registerCssFile("@web/css/page-success.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $product = Product::find()->where(['id' => array_keys(unserialize($order->data_order))])->all();
        $orderList = unserialize($order->data_order);
        $viewData = [];
        foreach ($product as $item) {
            $priceData = Product::getPriceProductbyId($item->id, $this->currensy);
            $type = $item->getParam('type', null);
            $image = $item->getParam('image', null);
            $link = $item->getParam('link', $this->currensy);
            $name = $item->getParam('shortName', $this->currensy);
            if ($orderList[$item->id]['count'] == 1) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-1']['sale']) && $priceData['productPac']['pricePac-1']['sale']) {
                    $price = $priceData['productPac']['pricePac-1']['sale'];
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            } else if ($orderList[$item->id]['count'] == 2) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-2']['sale']) && $priceData['productPac']['pricePac-2']['sale']) {
                    $price = $priceData['productPac']['pricePac-2']['sale'];
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            } else if ($orderList[$item->id]['count'] >= 3) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-3']['sale']) && $priceData['productPac']['pricePac-3']['sale']) {
                    $price = $priceData['productPac']['pricePac-3']['sale'];
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            }
            $sert = [
                'id' => $item->id,
                'name' => $name,
                'count' => $orderList[$item->id]['count'],
                'prose' => $price
            ];
            $viewData['product'][] = $sert;
        }
        ;
        if (!empty($order->ordersMeta->coupon)) {
            $viewData['coup'] = [
                'name' => $order->ordersMeta->coupon_name,
                'sum' => $order->ordersMeta->coupon_summ
            ];
        }

        if (!empty($order->ordersMeta->promocode)) {
            $viewData['promo'] = [
                'name' => $order->ordersMeta->promoUser->name,
                'sum' => Cart::PromocodeSizeSale(['data' => $orderList], $product, $order->cyrrency, $order->ordersMeta->promocode, true)
            ];
        }

        if (!empty($order->ordersMeta->shiping_type) && $order->ordersMeta->shiping_type != 'info') {
            $viewData['del'] = $order->getShipingSumm();
        }

        $viewData['total'] = Cart::totalSumm(
            ['data' => $orderList],
            $product,
            $this->currensy,
            $order->ordersMeta->coupon_name,
            $order->ordersMeta->promocode,
            $order->ordersMeta->shiping_type,
            true,
            $order->id,
            $order->ordersMeta->userAdress->postcode
        );
        $attr = array(
            'order_id' => $order->id,
            'lastname' => $order->ordersMeta->userAdress->surname,
            'name' => $order->ordersMeta->userAdress->name,
            'surname' => $order->ordersMeta->userAdress->lastname,
            'phone' => $order->user->phone,
            'email' => $order->user->email,
            'postcode' => $order->ordersMeta->userAdress->postcode,
            'country' => $order->ordersMeta->userAdress->country,
            'city' => $order->ordersMeta->userAdress->city,
            'area' => $order->ordersMeta->userAdress->area,
            'home' => $order->ordersMeta->userAdress->street,
            'flat' => $order->ordersMeta->userAdress->flat,
            'comment' => $order->ordersMeta->comment,
            'viewData' => $viewData,
            'username' => $order->user->email,
        );

        $setSale = 0;
        if (isset($viewData['promo']) && !empty($viewData['promo']) && isset($viewData['promo']['sum']) && !empty($viewData['promo']['sum'])) {
            $setSale = $viewData['promo']['sum'] / count($viewData['product']);

        }
        $yaItems = [];
        $total = 0;
        foreach ($viewData['product'] as $elem) {
            $total = $total + (isset($setSale) && !empty($setSale) ? ($elem['prose'] * $elem['count']) - $setSale : $elem['prose'] * $elem['count']);
            $yaItems[] = [
                "productId" => "{$elem['id']}",
                "quantity" => [
                    "count" => $elem['count']
                ],
                "title" => $elem['name'],
                "total" => (isset($setSale) && !empty($setSale) ? ($elem['prose'] * $elem['count']) - $setSale : $elem['prose'] * $elem['count'])
            ];
        }
        if (isset($viewData['del']) && !empty($viewData['del'])) {
            $total = $total + $viewData['del'];
            $yaItems[] = [
                "productId" => "del-product",
                "quantity" => [
                    "count" => "1"
                ],
                "title" => "Доставка",
                "total" => $viewData['del']
            ];
        }
        $array = [
            "currencyCode" => "RUB",
            "orderId" => "{$order->id}",
            "redirectUrls" => [
                "onAbort" => "https://anticandida.com/ru/payment/ya-abort",
                "onError" => "https://anticandida.com/ru/payment/ya-error",
                "onSuccess" => "https://anticandida.com/ru/payment/ya-success"
            ],
            "cart" => [
                "externalId" => "{$order->id}",
                "items" => $yaItems,
                "total" => [
                    "amount" => $total
                ]
            ],
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pay.yandex.ru/api/merchant/v1/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($array),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Api-Key fef97f1f7b12445c9edee7e0547c8662.UauLU3UVW00OQR_n9-2WEw7B6J4we-RK',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);
        $session = Yii::$app->session;
        $session->remove('cart');
        $request = Yii::$app->request->get();
        $order = Orders::find()
            ->where(['uuid' => $request['orderId']])
            ->with('ordersMeta')
            ->with('user')
            ->one();
        $product = Product::find()->where(['id' => array_keys(unserialize($order->data_order))])->all();
        $orderList = unserialize($order->data_order);
        $cart = array();
        $setData = Orders::find()->where(['uuid' => $orderId])->one();
        $cartMeta = OrdersMeta::find()->where(['order_id' => $setData->id])->one();
        $user = User::find()->where(['id' => $setData->user_id])->asArray()->one();
        $userAdress = UserAdress::find()->where(['id' => $cartMeta->adress_shipig])->asArray()->one();
        $this->getView()->registerCssFile("@web/css/page-success.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        MailMessage::TelegramMessage($order->id);
        return $this->render('prew-view-yandex', [
            'cartMeta' => $cartMeta,
            'cart' => $cart,
            'user' => $user,
            'userAdress' => $userAdress,
            'data' => $orderId,
            'currency' => $this->currensy,
            'order' => $order,
            'product' => $product,
            'orderList' => $orderList,
            'response' => $response
        ]);
    }




    public function actionIntellectPayment($orderId)
    {

        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);
        $session = Yii::$app->session;
        $session->remove('cart');
        $request = Yii::$app->request->get();
        $order = Orders::find()
            ->where(['uuid' => $request['orderId']])
            ->with('ordersMeta')
            ->with('user')
            ->one();
        $product = Product::find()->where(['id' => array_keys(unserialize($order->data_order))])->all();
        $orderList = unserialize($order->data_order);
        $cart = array();
        $setData = Orders::find()->where(['uuid' => $orderId])->one();
        $cartMeta = OrdersMeta::find()->where(['order_id' => $setData->id])->one();
        $user = User::find()->where(['id' => $setData->user_id])->asArray()->one();
        $userAdress = UserAdress::find()->where(['id' => $cartMeta->adress_shipig])->asArray()->one();
        $this->getView()->registerCssFile("@web/css/page-success.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        return $this->render('prew-view-intelect', [
            'cartMeta' => $cartMeta,
            'cart' => $cart,
            'user' => $user,
            'userAdress' => $userAdress,
            'data' => $orderId,
            'currency' => $this->currensy,
            'order' => $order,
            'product' => $product,
            'orderList' => $orderList
        ]);
    }


    public function actionPaymentTrisbySucces($orderId)
    {
        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);
        $session = Yii::$app->session;
        $session->remove('cart');
        $request = Yii::$app->request->get();
        $order = Orders::find()
            ->where(['uuid' => $request['orderId']])
            ->with('ordersMeta')
            ->with('user')
            ->one();
        $product = Product::find()->where(['id' => array_keys(unserialize($order->data_order))])->all();
        $orderList = unserialize($order->data_order);
        $cart = array();
        $setData = Orders::find()->where(['uuid' => $orderId])->one();
        $cartMeta = OrdersMeta::find()->where(['order_id' => $setData->id])->one();
        $user = User::find()->where(['id' => $setData->user_id])->asArray()->one();
        $userAdress = UserAdress::find()->where(['id' => $cartMeta->adress_shipig])->asArray()->one();
        $this->getView()->registerCssFile("@web/css/page-success.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $data = MailMessage::TelegramMessage($order->id);
        $messageSendOrder = MailMessage::SendNewOrder($this->currensy, null, $order->user->email, $order->id);
        return $this->render('prew-view-trisby', [
            'cartMeta' => $cartMeta,
            'cart' => $cart,
            'user' => $user,
            'userAdress' => $userAdress,
            'data' => $orderId,
            'currency' => $this->currensy,
            'order' => $order,
            'product' => $product,
            'orderList' => $orderList
        ]);
    }

    public function actionPaymentIntelecktSucces($orderId)
    {

        $request = Yii::$app->request->get();
        $lang = $request['lang'];
        $order = Orders::find()
            ->where(['uuid' => $orderId])
            ->with('ordersMeta')
            ->with('user')
            ->one();
        $product = Product::find()->where(['id' => array_keys(unserialize($order->data_order))])->all();
        $orderList = unserialize($order->data_order);

        $totalSumm = Cart::totalSumm(
            ['data' => $orderList],
            $product,
            $lang,
            $order->ordersMeta->coupon_name,
            $order->ordersMeta->promocode,
            $order->ordersMeta->shiping_type,
            true,
            $order->id
        );
        $date = new \DateTime('+1 days');
        $dateS = $date->format('Y-m-d H:i:s');
        $chekArray = array(
            "inn" => Yii::$app->params['dataInn'],
            "group" => "Main",
            "content" => [
                "type" => 1,
                "positions" => array(
                    [
                        "price" => $totalSumm,
                        "text" => "Заказ №{$order->id}",
                        "tax" => 6,
                        "quantity" => 1
                    ]
                ),
                "customerContact" => "info@body-balance.com"
            ]
        );

        $serviceName = "Оплата заказа №{$order->id}";
        $shopId = Yii::$app->params['shopId'];
        $secretKey = Yii::$app->params['secretKey'];
        $hash = md5("{$shopId}::{$order->id}::{$serviceName}::{$totalSumm}::RUB::{$secretKey}");
        $asdData = [
            "eshopId" => Yii::$app->params['shopId'],
            "orderId" => $order->id,
            "serviceName" => $serviceName,
            "recipientAmount" => $totalSumm,
            "recipientCurrency" => "RUB",
            "user_email" => $order->user->email,
            "userName" => $order->user->firstName . " " . $order->user->LastName . " " . $order->user->secondName,
            "successUrl" => "https://anticandida.com/ru/shop/payment-success",
            "failUrl" => "https://anticandida.com/ru/shop/payment-fail",
            "expireDate" => $date->format('Y-m-d H:i:s'),
            "merchantReceipt" => json_encode($chekArray),
            "UserField_1" => $lang,
            "hash" => $hash
        ];
        //debug($asdData);
        $client = new Client(['baseUrl' => 'https://merchant.intellectmoney.ru/ru/']);
        $response = $client->createRequest()
            ->setMethod('POST')
            ->addHeaders(['content-type' => 'application/json'])
            ->setData(
                $asdData
            )
            ->send();
        return $response->content;
    }
    public function actionPaymentCardSucces()
    {

        Yii::$app->language = mb_strtolower($this->currensy) . "-" . mb_strtoupper($this->currensy);
        $session = Yii::$app->session;
        $session->remove('cart');

        $request = Yii::$app->request->get();
        //debug($_GET);
        $order = Orders::find()
            ->where(['uuid' => $request['orderId']])
            ->with('ordersMeta')
            ->with('user')
            ->one();
        $this->getView()->registerCssFile("@web/css/page-success.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $product = Product::find()->where(['id' => array_keys(unserialize($order->data_order))])->all();
        $orderList = unserialize($order->data_order);
        $viewData = "<ul>";
        foreach ($product as $item) {
            $priceData = Product::getPriceProductbyId($item->id, $this->currensy);
            $type = $item->getParam('type', null);
            $image = $item->getParam('image', null);
            $link = $item->getParam('link', $this->currensy);
            $name = $item->getParam('shortName', $this->currensy);
            $viewData .= "<li><span>";
            $viewData .= $name;
            $viewData .= " × ";
            $viewData .= $orderList[$item->id]['count'] . " - ";
            if ($orderList[$item->id]['count'] == 1) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-1']['sale']) && $priceData['productPac']['pricePac-1']['sale']) {
                    $price = $priceData['productPac']['pricePac-1']['sale'];
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            } else if ($orderList[$item->id]['count'] == 2) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-2']['sale']) && $priceData['productPac']['pricePac-2']['sale']) {
                    $price = $priceData['productPac']['pricePac-2']['sale'];
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            } else if ($orderList[$item->id]['count'] >= 3) {
                if (isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-3']['sale']) && $priceData['productPac']['pricePac-3']['sale']) {
                    $price = $priceData['productPac']['pricePac-3']['sale'];
                } else {
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                }
            }
            $viewData .= number_format($price, 0, '', ' ') . " " . Yii::t('app', 'currency-symbol');
            $viewData .= "</span><span></span></li>";
        }
        ;
        if (!empty($order->ordersMeta->coupon)) {
            $viewData .= "<li>" . Yii::t('app', 'coupon-txt') . " " . $order->ordersMeta->coupon_name . ": " . $order->ordersMeta->coupon_summ . " " . Yii::t('app', 'currency-symbol') . "</li>";
        }
        if (!empty($order->ordersMeta->promocode)) {
            $viewData .= "<li>" . Yii::t('app', 'discount-using-promo-code') . " " . $order->ordersMeta->promoUser->name . ": " . Cart::PromocodeSizeSale(['data' => $orderList], $product, $order->cyrrency, $order->ordersMeta->promocode) . "</li>";
        }
        if (!empty($order->ordersMeta->shiping_type) && $order->ordersMeta->shiping_type != 'info') {
            $viewData .= "<li>" . Yii::t('app', 'delivery-txt') . ": " . number_format($order->getShipingSumm(), 0, '', ' ') . " " . Yii::t('app', 'currency-symbol') . "</li>";
        }
        $viewData .= "<li>" . Yii::t('app', 'total') . ": " .
            number_format(Cart::totalSumm(
                ['data' => $orderList],
                $product,
                $this->currensy,
                $order->ordersMeta->coupon_name,
                $order->ordersMeta->promocode,
                $order->ordersMeta->shiping_type,
                true,
                $order->id,
                $order->ordersMeta->userAdress->postcode
            ), 0, '', ' ') .
            " " . Yii::t('app', 'currency-symbol') . "</li></ul>";

        $attr = array(
            'order_id' => $order->id,
            'lastname' => $order->ordersMeta->userAdress->surname,
            'name' => $order->ordersMeta->userAdress->name,
            'surname' => $order->ordersMeta->userAdress->lastname,
            'phone' => $order->user->phone,
            'email' => $order->user->email,
            'postcode' => $order->ordersMeta->userAdress->postcode,
            'country' => $order->ordersMeta->userAdress->country,
            'city' => $order->ordersMeta->userAdress->city,
            'area' => $order->ordersMeta->userAdress->area,
            'home' => $order->ordersMeta->userAdress->street,
            'flat' => $order->ordersMeta->userAdress->flat,
            'comment' => $order->ordersMeta->comment,
            'viewData' => $viewData,
            'paymnet-link' => 'https://anticandida.com/ru/shop/payment-card-succes?orderId=' . $request['orderId'],
            'delivery' => Yii::t('app', 'del-' . $order->ordersMeta->shiping_type),
            'payment' => Yii::t('app', 'pay-card-mess'),
            'password' => $order->user->password,
            'username' => $order->user->email,

        );
        $messageSendOrder = MailMessage::SendNewOrder($this->currensy, $attr, $order->user->email);
        //var_dump($messageSendOrder); 
        MailMessage::TelegramMessage($order->id);
        return $this->render('payment-card-succes', [
            'viewData' => $viewData,
            'orderList' => $orderList,
            'order' => $order,
            'currency' => $this->currensy,
            'product' => $product,
            'orderUiid' => $request['orderId']
        ]);
    }




    protected function createNewOrder($product, $user_id, $cart, $adressId, $lang)
    {
        

        $product = Product::find()->where(['id' => array_keys($cart['data'])])->all();
        $promoId = null;
        if (isset($cart['promocode']) && !empty($cart['promocode'])) {
            $userPromo = PromoUser::find()->where(['name' => $cart['promocode']])->one();
            $promoId = $userPromo->id;
        }
        $uuid = uniqid();
        $server = $_SERVER;
        $order = new Orders([
            'data_order' => serialize($cart['data']),
            'user_id' => $user_id,
            'uuid' => $uuid,
            'cyrrency' => $lang,
            'ip' => (isset($server['HTTP_CF_CONNECTING_IP']) ? $server['HTTP_CF_CONNECTING_IP'] : null),
            'country' => (isset($server['HTTP_CF_IPCOUNTRY']) ? $server['HTTP_CF_IPCOUNTRY'] : null),
            'user_agent' => (isset($server['HTTP_SEC_CH_UA']) ? $server['HTTP_SEC_CH_UA'] : (isset($server['HTTP_USER_AGENT']) ? $server['HTTP_USER_AGENT'] : null)),
        ]);
        if ($order->save()) {
            $orderMeta = new OrdersMeta([
                'order_id' => $order->id,
                'shiping_type' => $cart['delivery'],
                'payment_type' => $cart['pay'],
                'order_summ' => Cart::totalSummProduct($cart, $product, $lang),
                'adress_shipig' => $adressId,
                'shiping_summ' => Delivery::getInstance()->getDelSumm($cart['delivery'], $lang, UserAdress::getPostcodeUserAdress($adressId)),
                'comment' => $cart['comment']
            ]);
            if (isset($cart['insurance']) && !empty($cart['insurance']) && $cart['insurance']) {
                $orderMeta->insurance = '1';
            }
            if (isset($cart['coupon']) && !empty($cart['coupon'])) {
                if (Promocod::find()->where(['promocode' => $cart['coupon']])->exists()) {
                    $coupon = Promocod::find()->where(['promocode' => $cart['coupon']])->asArray()->one();
                    $orderMeta->coupon = $coupon['id'];
                    $orderMeta->coupon_name = $coupon['promocode'];
                    $orderMeta->coupon_summ = $coupon['size'];
                }
            }
            if (!empty($promoId)) {
                $orderMeta->promocode = $promoId;
                if (!UserActivePromo::find()->where(['user_id' => $user_id])->andWhere(['promo_id' => $promoId])->exists()) {
                    $userActivePromo = new UserActivePromo([
                        'user_id' => $user_id,
                        'promo_id' => $promoId
                    ]);
                    if (!$userActivePromo->save()) {
                        return $userActivePromo->getErrors();
                    }
                }

            }
            if ($orderMeta->save()) {
                return [
                    'uiid' => $order->uuid,
                    'id' => $order->id,
                ];
            } else {
                return $orderMeta->getErrors();
            }
        } else {
            return false;
        }
    }

    public function actionSendOrder()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $data = Yii::$app->request->post();
            $session = Yii::$app->session;
            $cart = $session->get('cart');
            $res = [];
            foreach ($data['data'] as $key => $value) {
                if ($value['name'] != '_csrf') {
                    $res[$value['name']] = $value['value'];
                }
            }
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if (User::find()->where(['email' => $res['email']])->orWhere(['phone' => $res['phone']])->exists()) {
                if (Yii::$app->user->isGuest) {
                    return $response->data = [
                        'message' => 'user-invalid',
                    ];
                } else {
                    if ($res['activeAdress'] == 'newAdress') {
                        $cart['user'] = $res;
                    } else {
                        $cart['user'] = [
                            'activeAdress' => $res['activeAdress']
                        ];
                    }
                    $cart['comment'] = $data['comment'];
                    $session->set('cart', $cart);
                    return $response->data = [
                        'message' => 'user-valid'
                    ];
                }
            } else {
                $cart['user'] = $res;
                $cart['comment'] = $data['comment'];
                $session->set('cart', $cart);
                return $response->data = [
                    'message' => 'user-new'
                ];
            }
        }
    }


    public function actionAddCart()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $data = Yii::$app->request->post();
            $session = Yii::$app->session;
            $cart = $session->get('cart');

            // if(Cart::checkInfocurs($data['id'])){
            //     $response = Yii::$app->response;
            //     $response->format = \yii\web\Response::FORMAT_JSON;
            //         return $response->data = [
            //         'message' => false,
            //         'info' => Yii::t('app', 'error-add-info')
            //         ];
            // }
            $cart['data'][$data['id']]['count'] = isset($cart['data'][$data['id']]['count']) ? $cart['data'][$data['id']]['count'] + $data['count'] : $data['count'];
            //debug($cart);
            $session->set('cart', $cart);
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            return $response->data = [
                'message' => true,
                'info' => Yii::t('app', 'error-add-info')
            ];
        }
    }

    public function CartView($prodList)
    {
        return $this->renderPartial('cart-view', [
            'prodList' => $prodList
        ]);
    }

    protected function addInfoProduct($array, $uuid, $user_id): void
    {
        // if (!empty($array)) {
        //     foreach ($array as $key => $item) {
        //         $model = new AccessInfoProduct([
        //             'user_id' => $user_id,
        //             'product_id' => $item,
        //             'uuid' => $uuid
        //         ]);
        //         $model->save();
        //     }

        // }
    }

    protected function newAdress($data, $user_id)
    {
        $model = new UserAdress([
            'country' => $data['country'],
            'postcode' => $data['postcode'],
            'area' => $data['area'],
            'city' => $data['city'],
            'street' => $data['street'],
            'flat' => $data['flat'],
            'user_id' => $user_id
        ]);
        if ($model->save()) {
            return $model->id;
        }
    }

    protected function AdressUpdate($user_id, $userAdress)
    {
        $model = new UserAdress([
            'postcode' => $userAdress['postcode'],
            'city' => $userAdress['city'],
            'country' => $userAdress['country'],
            'user_id' => $user_id,
            'area' => $userAdress['area'],
            'flat' => $userAdress['flat'],
            'street' => $userAdress['street'],
        ]);
        if ($model->save()) {
            return $model->id;
        } else {
            return false;
        }
    }

    public function actionRemoveTovarFromCart()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $session = Yii::$app->session;
            $cart = $session->get('cart');
            if (isset($cart['data'][$data['id']])) {
                unset($cart['data'][$data['id']]);
            }
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $session->set('cart', $cart);
            return true;
        }
    }

    public function actionPlusTov()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            try {
                $session = Yii::$app->session;
                $cart = $session->get('cart');
                if (isset($cart['data']) && isset($cart['data'][$data['id']])) {
                    $cart['data'][$data['id']]['count'] = ++$cart['data'][$data['id']]['count'];
                }
                $response = Yii::$app->response;
                $response->format = \yii\web\Response::FORMAT_JSON;
                $session->set('cart', $cart);
                return $response->data = [
                    'message' => true,
                ];
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public function actionMinusTov()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $session = Yii::$app->session;
            $cart = $session->get('cart');
            if (isset($cart['data']) && isset($cart['data'][$data['id']])) {
                $cart['data'][$data['id']]['count'] = $cart['data'][$data['id']]['count'] - 1;
            }
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $session->set('cart', $cart);
            return $response->data = [
                'message' => true,
            ];
        }
    }

    public function actionPromocod()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $promocod = Promocod::find()->where(['promocode' => $data['promocod']])->one();
            if ($promocod && $promocod->active == "1") {
                $session = Yii::$app->session;
                $cart = $session->get('cart');
                $cart['promocod'] = $promocod->id;
                $cart->set('cart', $cart);
                return $response->data = [
                    'dataStr' => $dataStr,
                    'promocod' => $promocod->size,
                    'result' => $result . ' ' . $symbol
                ];

            }
        }
    }

    public function actionAddPromocode()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $session = Yii::$app->session;
            $promocode = $data['promocode_partner'];
            $cart = $session->get('cart');
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;

            if (Yii::$app->user->isGuest) {
                if (!PromoUser::find()->where(['name' => $promocode])->exists()) {
                    return false;
                } else {
                    $promo_id = PromoUser::find()->where(['name' => $promocode])->asArray()->one();
                    UserReport::newReport($promo_id['id']);
                }
            } else {
                if (PromoUser::find()->where(['name' => $promocode])->andWhere(['!=', 'user_id', Yii::$app->user->identity->id])->exists()) {
                    $promo_id = PromoUser::find()->where(['name' => $promocode])->asArray()->one();
                    UserReport::newReport($promo_id['id']);
                } else {
                    return false;
                }
            }
            $cart['promocode'] = $promocode;
            $session->set('cart', $cart);
            return $response->data = [
                'message' => true
            ];
        }
    }


    protected function updateCart($cart)
    {
        $newCartData = Cart::updateCartPromocode($cart['data'], (isset($cart['promocode']) ? $cart['promocode'] : null));
        $cart['data'] = $newCartData['cart'];
        $cart['totalData'] = $newCartData['totalData'];
        $setPriceData = number_format($cart['totalData']['salePrice'], 0, '', ' ') . ' ' . ($cart['cyrrency'] == 'ru' ? "₽" : $cart['cyrrency']);
        return [
            'cart' => $cart,
            'setPriceData' => $setPriceData
        ];
    }

    protected function AccessInfocurse($cart, $uuid, $userId)
    {
        // $infoArray = [];
        // $product = Product::find()->where(['id' => array_keys($cart)])->all();
        // foreach ($product as $item) {
        //     $type = $item->getParam('type', null);
        //     if ($type == 'info') {
        //         if (!AccessInfoProduct::find()->where(['user_id' => $userId])->andwhere(['product_id' => $item->id])->exists()) {
        //             $AccessInfoProduct = new AccessInfoProduct([
        //                 'user_id' => $userId,
        //                 'product_id' => $item->id,
        //                 'uuid' => $uuid
        //             ]);
        //             $AccessInfoProduct->save();
        //         }
        //         $infoArray[] = $item->id;
        //     }
        // }
    }
    public function actionCoupon()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (Promocod::find()->where(['promocode' => $data['coupon']])->exists()) {
                $session = Yii::$app->session;
                $cart = $session->get('cart');
                $cart['coupon'] = $data['coupon'];
                $session->set('cart', $cart);
                return true;
            }
        }
    }
}


