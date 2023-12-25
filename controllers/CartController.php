<?php
namespace app\controllers;

use app\models\AccessInfoProduct;
use app\models\Cart;
use app\models\Orders;
use app\models\OrdersMeta;
use app\models\OrderStatus;
use Yii;
use app\models\LoginForm;
use app\models\PaymentType;
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
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        if (empty($cart['data'])) {
            return $this->goHome();
        }
        $this->getView()->registerCssFile("@web/css/order.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerCssFile("@web/css/main.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->layout = "template-cart";
        return $this->render('index', [
            'cart' => $cart,
            'currensy' => $this->currensy,
        ]);
    }

    public function actionOrder()
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        if (!empty($promocodeArray)) {
            $this->promocode = $promocodeArray['promo'];
        }
        if (!isset($cart['data']) || empty($cart['data'])) {
            return $this->goHome();
        }
        $this->getView()->registerCssFile("@web/css/order.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerCssFile("@web/css/main.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->layout = "template-cart";

        if (Yii::$app->user->isGuest) {
            $this->layout = "template-cart";
            return $this->render('order', [
                'cart' => $cart,
                'currensy' => $this->currensy,
                'promocode' => $this->promocode,
            ]);
        } else {
            $user_id = Yii::$app->user->identity->id;
            $user = User::findOne($user_id);

            if(isset($cart['promocode'])){
                $promocode = PromoUser::find()->where(['name' => $cart['promocode']])->asArray()->one();
                if($promocode['user_id'] == Yii::$app->user->identity->id){
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
            return $this->render('order-log', [
                'user' => $user,
                'cart' => $cart,
                'currensy' => $this->currensy,
            ]);
        }
    }
    public function actionDelivery()
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        if (empty($cart) || empty($cart['data'])) {
            return $this->goHome();
        }
        if (is_array($cart['user'])) {
            $user = $cart['user'];
        } else {
            $user = $this->normalizeUser($cart['user']);
        }
        $this->getView()->registerCssFile("@web/css/order.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerCssFile("@web/css/main.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->layout = "template-cart";
        return $this->render('delivery', [
            'currensy' => $this->currensy,
            'user' => $user,
            'cart' => $cart,
        ]);
    }

    public function actionPayment()
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        if (is_array($cart['user'])) {
            $user = $cart['user'];
        } else {
            $user = $this->normalizeUser($cart['user']);
        }
        $this->getView()->registerCssFile("@web/css/order.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->getView()->registerCssFile("@web/css/main.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $this->layout = "template-cart";
        return $this->render('payment', [
            'currensy' => $this->currensy,
            'user' => $user,
            'cart' => $cart,
        ]);
    }

    protected function normalizeUser($userId)
    {
        $user = UserAdress::find()->where(['id' => $userId])->asArray()->one();
        $dataUser = User::find()->where(['id' => Yii::$app->user->identity->id])->asArray()->one();
        $user['email'] = $dataUser['email'];
        $user['surname'] = $dataUser['firstName'];
        $user['name'] = $dataUser['LastName'];
        $user['lastname'] = $dataUser['secondName'];
        $user['phone'] = $dataUser['phone'];
        $user['house'] = $user['flat'];
        return $user;
    }
    public function actionFinalPayment()
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        
        if (!Yii::$app->user->isGuest) {
            if (is_array($cart['user'])) {
                //обновление данных зарегестрированого пользователя
                $updateUser = User::findOne(Yii::$app->user->identity->id);
                $userId = $updateUser->updateUser($cart['user']);
                //добавление нового адресса
                $newUserAdress = new UserAdress();
                $adressId = $newUserAdress->updateAdress($cart['user'], $userId);
                $data = $this->createNewOrder($cart['data'], $user_id = Yii::$app->user->identity->id, $cart, $adressId);
                //Создание нового заказа
                // $newOrders = new Orders([
                //     'data_order' => serialize($cart['data']),
                //     'user_id' => $userId,
                //     'uuid' => uniqid()
                // ]);
                // $newOrders->save();
                // $ordersMeta = new OrdersMeta([
                //     'order_id' => $newOrders->id,
                //     'shiping_type' => $cart['delivery'],
                //     'payment_type' => $cart['pay'],
                //     'order_summ' => serialize($cart['totalData']),
                //     'adress_shipig' => $adressId,
                //     'promocode' => $cart['promocode'],
                // ]);

                // if(!$ordersMeta->save()){
                //     var_dump($ordersMeta->getErrors());
                // };
                //Добавление доступа к инфокурсу
                $this->AccessInfocurse($cart['data'], $data, $userId);
                
            } else {
                debug(222);
                $userAdress = UserAdress::find()
                    ->where(['id' => $cart['user']])
                    ->asArray()
                    ->one();
                $user = User::find()
                    ->where(['id' => Yii::$app->user->identity->id])
                    ->asArray()
                    ->one();

                $data = $this->createNewOrder($cart['data'], $user_id = Yii::$app->user->identity->id, $cart, $adressId = $cart['user']);
                $this->AccessInfocurse($cart['data'], $data, $userId = Yii::$app->user->identity->id);

                $infoArray = [];
            }
        } else {
            $newUser = new User([
                'username' => $cart['user']['email'],
                'password' => uniqid(),
                'email' => $cart['user']['email'],
                'firstName' => $cart['user']['surname'],
                'LastName' => $cart['user']['name'],
                'secondName' => $cart['user']['lastname'],
                'phone' => $cart['user']['phone'],
            ]);
            if ($newUser->save()) {
                $newUserAdress = new UserAdress([
                    'postcode' => $cart['user']['postcode'],
                    'city' => $cart['user']['city'],
                    'country' => $cart['user']['country'],
                    'user_id' => $newUser->id,
                    'area' => $cart['user']['area'],
                    'flat' => $cart['user']['house'],
                    'street' => $cart['user']['street'],

                ]);
                if (!$newUserAdress->save()) {
                    return '3';
                };
                $userLogin = new LoginForm([
                    'username' => $newUser->username,
                    'password' => $newUser->password,
                    'rememberMe' => true
                ]);
                $userLogin->login();
                $data = $this->createNewOrder($cart['data'], $user_id = $newUser->id, $cart, $adressId = $cart['user']);
                $this->AccessInfocurse($cart['data'], $data, $userId = $newUser->id);
            }
        }

        if ($cart['pay'] == 'card') {
            $this->redirect(['/' . $this->currensy . '/' . 'payment-card-succes']);
        }

        if ($cart['pay'] == 'inteleckt') {
            $this->redirect(['/' . $this->currensy . '/' . 'payment-inteleckt-succes']);
        }

        if ($cart['pay'] == 'trisby') {
            $this->redirect(['/' . $this->currensy . '/' . 'payment-trisby-succes']);
        }
    }

    public function actionPaymentTrisbySucces()
    {
        debug('trisby');
    }

    public function actionPaymentIntelecktSucces()
    {
        debug('inteleckt');
    }

    public function actionPaymentCardSucces()
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        $promo = $session->get('promo');

        $currensy = $this->currensy;
        if (empty($cart) || empty($cart['data'])) {
            return $this->goHome();
        }

        if (!is_array($cart['user'])) {
            $userAdress = UserAdress::find()->where(['id' => $cart['user']])->asArray()->one();
            $user = User::find()->where(['id' => Yii::$app->user->identity->id])->asArray()->one();
        }
        $this->getView()->registerCssFile("@web/css/page-success.css", [
            'depends' => [BootstrapAsset::class],
        ]);
        $session->set('cart', '');
        $session->set('promo', '');
        return $this->render('payment-card-succes', [
            'userAdress' => $userAdress,
            'user' => $user,
            'cart' => $cart
        ]);
    }

    protected function createNewOrder($product, $user_id, $cart, $adressId)
    {
        $dataS = openssl_random_pseudo_bytes(16, $strong);
        assert($dataS !== false && $strong);
        $uuid = $this->format_uuidv4($dataS);

        $order = new Orders([
            'data_order' => serialize($product),
            'user_id' => $user_id,
            'uuid' => $uuid
        ]);
        if ($order->save()) {
            $orderMeta = new OrdersMeta([
                'order_id' => $order->id,
                'shiping_type' => $cart['delivery'],
                'payment_type' => $cart['pay'],
                'order_summ' => serialize($cart['totalData']),
                'adress_shipig' => $adressId,
            ]);
            if ($orderMeta->save()) {
                return $order->uuid;
            } else {
                return false;
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
            if (User::find()->where(['email' => $data['email']])->orWhere(['phone' => $data['phone']])->exists()) {
                return false;
            } else {
                $session = Yii::$app->session;
                $cart = $session->get('cart');
                unset($data['_csrf']);
                $cart['user'] = $data;
                $session->set('cart', $cart);
                return true;
            }
        }
    }
    public function actionAddCart()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $data = $request->post();

            $session = Yii::$app->session;
            $cart = $session->get('cart');
            if(empty($cart)){
                $cart = [];
            }
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;

            if(UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->exists()){
                $UserActivePromo = UserActivePromo::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
                $PromoUser = PromoUser::findOne($UserActivePromo->promo_id);
                $cart['promocode'] = $PromoUser['name'];
            }

            if(!Yii::$app->user->isGuest &&
                AccessInfoProduct::find()
                ->where(['user_id' => Yii::$app->user->identity->id])
                ->andWhere(['product_id' => $data['id']])->exists()
                ){
                    return $response->data = [
                        'message' => false,
                        'info' => 'Инфокурс вы уже преобрели'
                    ];
                }
            if (!isset($cart['cyrrency']) || $cart['cyrrency'] != $data['cyrrency']) {
                $cart['cyrrency'] = $data['cyrrency'];
            }

            $typeProduct = ProductMeta::find()
                ->where(['meta' => 'type'])
                ->andWhere(['product_id' => $data['id']])
                ->asArray()
                ->one();
            if ($typeProduct['value'] == Product::TYPE_INFO) {
                if (isset($cart['data'][$data['id']])) {
                    return $response->data = [
                        'message' => false,
                        'info' => 'Инфокурс вы уже преобрели'
                    ];
                }
            }
            if (isset($cart['data'][$data['id']])) {
                ++$cart['data'][$data['id']]['count'];
            } else {
                $product = array_merge($data, [
                    'productName' => Cart::getName($data['id'], $data['cyrrency']),
                    'productPhoto' => Cart::getPhoto($data['id']),
                    'type' => Cart::type($data['id']),
                    'count' => 1
                ]);
                $cart['data'][$data['id']] = $product;
            }

            $newCartData = Cart::updateCartPromocode($cart['data'], (isset($cart['promocode']) ? $cart['promocode'] : null));
            $cart['data'] = $newCartData['cart'];
            $cart['totalData'] = $newCartData['totalData'];
            $session->set('cart', $cart);

            $setPriceData = number_format($cart['totalData']['salePrice'], 0, '', ' ') . ' ' . $cart['cyrrency'];
            return $response->data = [
                'message' => true,
                'cartTotal' => $setPriceData
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
        if (!empty($array)) {
            foreach ($array as $key => $item) {
                $model = new AccessInfoProduct([
                    'user_id' => $user_id,
                    'product_id' => $item,
                    'uuid' => $uuid
                ]);
                $model->save();
            }

        }
    }

    protected function format_uuidv4($data): string
    {
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    protected function newOrder($user_id, $data)
    {
        $str = openssl_random_pseudo_bytes(16, $strong);
        assert($str !== false && $strong);
        $uuid = $this->format_uuidv4($str);
        $newOrder = new Orders([
            'data_order' => $data['Orders']['data_order'],
            'user_id' => $user_id,
            'uuid' => $uuid
        ]);
        if ($newOrder->save()) {
            return [
                'data' => 'success',
                'messege' => $uuid,
            ];
        }

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

    protected function newOrderNewUser($data)
    {
        $user = new User();
        if ($user->load($data)) {
            $user->password = rand(0, 999) . 'a' . rand(0, 999) . 'bs' . rand(0, 999) . 'pd' . rand(0, 999) . rand(0, 999);
            if ($user->save() && $user->validate()) {
                $login = new LoginForm([
                    'username' => $user->email,
                    'password' => $user->password
                ]);
                if (!$login->login()) {
                    return var_dump($login->getErrors());
                }
                $userAddres = new UserAdress();
                if ($userAddres->load($data)) {
                    $userAddres->user_id = $user->id;
                    $userAddres->save();
                }
                $dataS = openssl_random_pseudo_bytes(16, $strong);
                assert($dataS !== false && $strong);
                $uuid = $this->format_uuidv4($dataS);
                $newOrder = new Orders([
                    'data_order' => $data['Orders']['data_order'],
                    'user_id' => $user->id,
                    'uuid' => $uuid
                ]);
                if ($newOrder->save()) {
                    return [
                        'data' => 'success',
                        'messege' => $uuid,
                        'adress' => $userAddres->id
                    ];
                } else {
                    return [
                        var_dump($newOrder->getErrors())
                    ];
                }
            } else {
                return [
                    'data' => 'Error',
                    'messege' => 'Телефон или e-mail, уже зарегистрирован',
                    'lest' => $user->getErrors()
                ];
            }
        } else {
            return [
                'data' => 'Error',
                'messege' => 'Телефон или e-mail, уже зарегистрирован',
                'lest' => $user->getErrors()
            ];
        }


    }

    protected function OrderUpdate($OrdersData, $OrdersMeta, $user_id, $adress_id)
    {
        $model = new Orders([
            'user_id' => $user_id,
            'data_order' => $OrdersData['data_order']
        ]);
        if ($model->save()) {
            $ordersMetaData = new OrdersMeta([
                'order_id' => $model->id,
                'shiping_type' => $OrdersMeta['shiping_type'],
                'payment_type' => $OrdersMeta['payment_type'],
                'order_summ' => '555',
                'adress_shipig' => $adress_id,
            ]);
            if ($ordersMetaData->save()) {
                return false;
            } else {
                var_dump($ordersMetaData->getErrors());
            }
        } else {
            var_dump($model->getErrors());
        }
    }

    protected function UserUpdate($user_id, $userData, $userAdress)
    {
        $model = User::findOne($user_id);
        $model->firstName = $userData['firstName'];
        $model->LastName = $userData['LastName'];
        $model->secondName = $userData['secondName'];
        $model->phone = $userData['phone'];
        if ($model->save()) {
            if (!isset($userAdress['id']) || empty($userAdress['id'])) {
                $data = $this->AdressUpdate($user_id, $userAdress);
                return $data;
            } else {
                return $userAdress['id'];
            }
        } else {
            return false;
        }
        ;
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
            $result = $this->updateCart($cart);
            $session->set('cart', $result['cart']);
            // return $response->data = [
            //     'message' => true,
            //     'cartTotal' => $result['setPriceData']
            // ];
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
                $result = $this->updateCart($cart);
                $session->set('cart', $result['cart']);
                return $response->data = [
                    'message' => true,
                    'cartTotal' => $result['setPriceData']
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
            $result = $this->updateCart($cart);
            $session->set('cart', $result['cart']);
            return $response->data = [
                'message' => true,
                'cartTotal' => $result['setPriceData']
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
                $cart['size'] = $promocod->size;
                $summ = 0;
                $symbol = '';
                foreach ($cart as $key => $item) {
                    if (isset($item['price']) && isset($item['count'])) {
                        $summ = $summ + ((int) $item['price'] * (int) $item['count']);
                        $symbol = $item['symbol'];
                    }
                }
                $result = round($summ - ($summ / 100 * $promocod->size));
                $dataStr = '<div class="result">' .
                    '<div class="text-res">' .
                    '<span>Скидка:</span>' .
                    '</div>' .
                    '<div class="prise-res">' .
                    '<span class="prise-sum-s">- ' . $promocod->size . '%</span>' .
                    '</div>' .
                    '</div>';
                $session->set('cart', $cart);
                $response = Yii::$app->response;
                $response->format = \yii\web\Response::FORMAT_JSON;
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
                }
            } else {
                if (PromoUser::find()->where(['name' => $promocode])->andWhere(['!=', 'user_id', Yii::$app->user->identity->id])->exists()) {
                    $promoUser = PromoUser::find()->where(['name' => $promocode])->andWhere(['!=', 'user_id', Yii::$app->user->identity->id])->one();
                } else {
                    return false;
                }
            }
            $cart['promocode'] = $promocode;
            $result = $this->updateCart($cart);
            $session->set('cart', $result['cart']);
            return $response->data = [
                'message' => true,
                'data' => 'Промокод добавлен',
                'type' => 'Внимание'
            ];
        }
    }

    public function actionSendDel()
    {
        if (Yii::$app->request->isAjax) {
            try {
                $data = Yii::$app->request->post();
                $session = Yii::$app->session;
                $cart = $session->get('cart');
                $cart['delivery'] = $data['del'];
                $session->set('cart', $cart);
                return true;
            } catch (Exception $e) {
                return false;
            }


        }
    }

    public function actionSendPay()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $form = ArrayHelper::map($data['form'], 'name', 'value');
            if (isset($form['pay'])) {
                $session = Yii::$app->session;
                $cart = $session->get('cart');
                $cart['pay'] = $form['pay'];
                $session->set('cart', $cart);
                return true;
            } else {
                return false;
            }
        }
    }

    protected function updateCart($cart)
    {
        $newCartData = Cart::updateCartPromocode($cart['data'], (isset($cart['promocode']) ? $cart['promocode'] : null));
        $cart['data'] = $newCartData['cart'];
        $cart['totalData'] = $newCartData['totalData'];
        $setPriceData = number_format($cart['totalData']['salePrice'], 0, '', ' ') . ' ' . $cart['cyrrency'];
        return [
            'cart' => $cart,
            'setPriceData' => $setPriceData
        ];
    }

    protected function AccessInfocurse($cart, $uuid, $userId){
        $infoArray = [];
        foreach($cart as $item){
            if($item['type'] == 'info'){
                if(!AccessInfoProduct::find()->where(['user_id' => $userId])->andwhere(['product_id' => $item['id']])->exists()){
                    $AccessInfoProduct = new AccessInfoProduct([
                        'user_id' => $userId,
                        'product_id' => $item['id'],
                        'uuid' => $uuid
                    ]);
                    $AccessInfoProduct->save();
                }
                $infoArray[] = $item['id'];
            }
        }
    }
}