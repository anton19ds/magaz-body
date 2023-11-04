<?php

namespace app\controllers;

use app\models\AccessInfoProduct;
use app\models\Orders;
use app\models\OrdersMeta;
use app\models\OrderStatus;
use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\PaymentType;
use app\models\Product;
use app\models\ProductMeta;
use app\models\Promocod;
use app\models\User;
use app\models\UserAdress;
use yii\helpers\ArrayHelper;

class CartController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request->get();
        $currensy = $request['lang'];
        $cart = $this->Cart();
        if (empty($cart)) {
            return $this->goHome();
        }
        foreach ($cart as $key => &$item) {
            if ($key != 'promocod' && $key != 'size') {
                $item['product'] = Product::find()->where(['id' => $item['id']])->one();
            }
        }
        return $this->render('index', [
            'cart' => $cart,
            'currensy' => $currensy
        ]);
    }
    public function actionAddCart()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $data = $request->post();
            $session = Yii::$app->session;
            $cart = $session->get('cart');
            $typeProduct = ProductMeta::find()->where(['meta' => 'type'])->andWhere(['product_id' => $data['id']])->asArray()->one();
            if(!Yii::$app->user->isGuest){
                if ($typeProduct['value'] == Product::TYPE_INFO) {
                    $product = Product::findOne($data['id']);
                    if($product->accessCurs(Yii::$app->user->identity->id)){
                        $response = Yii::$app->response;
                        $response->format = \yii\web\Response::FORMAT_JSON;
                        return $response->data = [
                            'message' => false,
                            'info' => 'Инфокурс вы уже преобрели'
                        ];
                    };
                }
            }
            // accessCurs($user_id)
            if (empty($cart)) {
                $cart = array();
                $cart[$data['id']] = $data;
                $cart[$data['id']]['count'] = 1;
                $cart[$data['id']]['count'] = 1;
                $session->set('cart', $cart);
            } else {
                if ($typeProduct['value'] == Product::TYPE_INFO) {
                    if (isset($cart[$data['id']])) {
                        $response = Yii::$app->response;
                        $response->format = \yii\web\Response::FORMAT_JSON;
                        return $response->data = [
                            'message' => false,
                            'info' => 'Инфокурс уже есть в корзине'
                        ];

                    }
                }


                if (array_search($data['symbol'], array_column($cart, 'symbol')) !== false) {
                    if (array_key_exists($data['id'], $cart)) {
                        $cart[$data['id']]['count'] = $cart[$data['id']]['count'] + 1;
                    } else {
                        $cart[$data['id']] = $data;
                        $cart[$data['id']]['count'] = 1;
                    }
                    $session->set('cart', $cart);
                } else {
                    $cart = array();
                    $cart[$data['id']] = $data;
                    $cart[$data['id']]['count'] = 1;
                    $session->set('cart', $cart);
                }
            }
            $idData = Product::find()->where(['id' => ArrayHelper::getColumn($cart, 'id')])->all();
            $dataTovar = [];
            $summSet = 0;
            foreach ($idData as $item) {
                if (!empty($item->getImageProductList())) {
                    foreach ($item->getImageProductList() as $elem) {
                        $img = reset($elem);
                        $image = $img['value'];

                    }
                } else {
                    $image = "/adminStyle/assets/img/no-image.png";
                }
                $priceData = $item->getPriceProduct($data['cyrrency']);
                $dataTovar[$item->id] = [
                    'img' => $image,
                    'count' => $cart[$item->id]['count'],
                    'id' => $item->id,
                    'price' => ($priceData['summ'] ? $priceData['summ'] : $priceData['price']) * $cart[$item->id]['count'],
                    'symbol' => $priceData['symbolCode'],
                    'name' => $item->getParam('productName')
                ];
                $summSet = $summSet + ($priceData['summ'] ? $priceData['summ'] : $priceData['price']) * $cart[$item->id]['count'];

            }
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            return $response->data = [
                'data' => $this->renderAjax('cart-mob', [
                    'dataTovar' => $dataTovar,
                ]),
                'message' => true,
                'summSet' => $summSet
            ];
        }
    }
    public function CartView($prodList)
    {
        return $this->renderPartial('cart-view', [
            'prodList' => $prodList
        ]);
    }

    public function actionOrder()
    {

        $request = Yii::$app->request->get();
        $currensy = $request['lang'];
        $cart = $this->Cart();
        if (!$cart) {
            return $this->goHome();
        }
        $infoCursList = [];


        foreach ($cart as $key => $item) {
            if ($key != 'promocod' && $key != 'size') {
                $infoMeta = ProductMeta::find()->where(['product_id' => $item['id']])->andWhere(['value' => 'info'])->one();
                if ($infoMeta) {
                    $infoCursList[] = $infoMeta->product_id;
                }
            }
        }
        $model = new Orders();
        $ordersMeta = new OrdersMeta();
        $userAdressData = null;
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            if (Yii::$app->user->isGuest) {
                $result = $this->newOrderNewUser($data);
                $uuid = $result['messege'];
                return $this->redirect(['cart/payment', 'lang' => $currensy, 'uuid' => $result['messege'], 'ad' => $result['adress']]);
            } else {

                if (isset($data['User']['phone']) && !empty($data['User']['phone'])) {
                    $userSavePhone = User::findOne(Yii::$app->user->identity->id);
                    $userSavePhone->savePhone($data['User']['phone']);
                }

                if ($data['activeAdress'] == 'newAdress') {
                    $adress_id = $this->newAdress($data['UserAdress'], Yii::$app->user->identity->id);
                } else {
                    $adress_id = $data['activeAdress'];
                }

                $result = $this->newOrder(Yii::$app->user->identity->id, $data);
                $uuid = $result['messege'];
                if ($result['data'] != 'Error') {
                    $this->addInfoProduct($infoCursList, $uuid, Yii::$app->user->identity->id);
                    return $this->redirect(['cart/payment', 'lang' => $currensy, 'uuid' => $result['messege'], 'ad' => $adress_id]);
                }
            }
            if ($result['data'] == 'Error') {
                Yii::$app->session->setFlash('error', $result['messege']);
            } else {
                debug($result);
            }
        }


        if (Yii::$app->user->isGuest) {
            $user = new User();
            $userAdress = new UserAdress();
            return $this->render('order', [
                'model' => $model,
                'cart' => $cart,
                'ordersMeta' => $ordersMeta,
                'user' => $user,
                'userAdress' => $userAdress,
                'userAdressData' => $userAdressData,
                'currensy' => $currensy
            ]);
        } else {
            $user_id = Yii::$app->user->identity->id;
            $user = User::findOne($user_id);
            $model = new Orders();
            return $this->render('order-log', [
                'user' => $user,
                'model' => $model,
                'cart' => $cart,
                'currensy' => $currensy
            ]);
        }
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
            if (isset($cart[$data['id']])) {
                unset($cart[$data['id']]);
            }
            $session->set('cart', $cart);
            $sumSett = $this->sumSet();
            return $sumSett;
        }
    }

    public function actionPlusTov()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            $session = Yii::$app->session;
            $cart = $session->get('cart');

            if (isset($cart[$data['id']])) {
                ++$cart[$data['id']]['count'];
                $setTovar = $cart[$data['id']]['count'] * $cart[$data['id']]['price'];
            }
            $session->set('cart', $cart);
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            return $response->data = [
                'summ' => $this->sumSet(),
                'count' => $cart[$data['id']]['count'],
                'setTovar' => number_format($setTovar, 0, " ", " ") . " " . $cart[$data['id']]['symbol']
            ];
        }
    }

    public function actionMinusTov()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $session = Yii::$app->session;
            $cart = $session->get('cart');
            if (isset($cart[$data['id']]) && $cart[$data['id']]['count'] != 1) {
                --$cart[$data['id']]['count'];
                $setTovar = $cart[$data['id']]['count'] * $cart[$data['id']]['price'];
            } else {
                return false;
            }
            $session->set('cart', $cart);
            if ($cart[$data['id']]['count'] > 0 && $cart[$data['id']]['count'] != 0) {
                $response = Yii::$app->response;
                $response->format = \yii\web\Response::FORMAT_JSON;
                return $response->data = [
                    'summ' => $this->sumSet(),
                    'count' => $cart[$data['id']]['count'],
                    'setTovar' => number_format($setTovar, 0, " ", " ") . " " . $cart[$data['id']]['symbol']
                ];
            } else {
                return false;
            }

        }
    }

    protected function sumSet()
    {
        $cart = $this->Cart();
        $setSum = 0;
        $symbol = '';
        if (!empty($cart)) {
            foreach ($cart as $value) {
                $setSum = $setSum + ($value['count'] * $value['price']);
                $symbol = $value['symbol'];
            }
            return number_format($setSum, 0, " ", " ") . " " . $symbol;
        }
        return $setSum;

    }


    public function actionPayment()
    {
        $request = Yii::$app->request->get();
        $currensy = $request['lang'];
        $uuid = $request['uuid'];
        $adress = $request['ad'];
        $userId = Yii::$app->user->identity->id;
        $order = Orders::find()->where(['uuid' => $uuid])->andWhere(['user_id' => $userId])->asArray()->one();
        $data_order = unserialize($order['data_order']);
        $dataSumm = 0;
        foreach ($data_order as $elem => $item) {
            if ($elem != 'promocod' && $elem != 'size') {
                $dataSumm = $dataSumm + ($item['price'] * $item['count']);
            }
        }
        $userAdress = UserAdress::find()->where(['id' => $adress])->asArray()->one();
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->asArray()->one();
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            if (!isset($data['pay-type']) || empty($data['pay-type'])) {
                Yii::$app->session->setFlash('error', 'Укажите тип оплаты');
                return $this->refresh();
            }

            $userId = Yii::$app->user->identity->id;
            if (Orders::find()->where(['uuid' => $uuid])->andWhere(['user_id' => $userId])->exists()) {
                $ordersModel = Orders::find()->where(['uuid' => $uuid])->andWhere(['user_id' => $userId])->one();
                if (!OrdersMeta::find()->where(['order_id' => $ordersModel->id])->exists()) {
                    $modelOrdersMeta = new OrdersMeta([
                        'order_id' => $ordersModel->id,
                        'shiping_type' => OrdersMeta::POCHTA,
                        'payment_type' => $data['pay-type'],
                        'order_summ' => $dataSumm,
                        'adress_shipig' => $adress,
                        'promocode' => ''
                    ]);
                    if ($modelOrdersMeta->save()) {
                        $orderStatys = new OrderStatus([
                            'order_id' => $ordersModel->id,
                            'status' => OrderStatus::STATUS_NEW
                        ]);
                        if (!$orderStatys->save()) {
                            return debug($orderStatys->getErrors());
                        }
                        return $this->redirect([
                            '/cart/payment-final',
                            'lang' => $request['lang'],
                            'uuid' => $request['uuid']
                        ]);
                    } else {
                        return debug($modelOrdersMeta->getErrors());
                    }
                } else {
                    return debug('111');
                }
            } else {
                return debug('234');
            }
        }
        return $this->render('payment', [
            'currensy' => $currensy,
            'user' => $user,
            'userAdress' => $userAdress,
            'order' => $order
        ]);
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

    public function actionPaymentFinal()
    {
        $request = Yii::$app->request->get();
        if (Yii::$app->user->isGuest) {
            if (isset($request['lang'])) {
                $se = '/' . $request['lang'];
            } else {
                $se = '/';
            }
            return $this->redirect([$se]);
        }
        $user = Yii::$app->user->identity->id;
        $order = Orders::find()->where(['uuid' => $request['uuid']])->andWhere(['user_id' => $user])->asArray()->one();
        $orderMeta = OrdersMeta::find()->where(['order_id' => $order['id']])->asArray()->one();
        $orderStatus = OrderStatus::find()->where(['order_id' => $order['id']])->asArray()->one();
        $userAdress = UserAdress::find()->where(['id' => $orderMeta['adress_shipig']])->asArray()->one();
        if ($orderStatus['status'] == OrderStatus::STATUS_NEW) {
            if ($orderMeta['payment_type'] == OrdersMeta::Inteleckt) {
                return $this->render('payment-final-intelect', [
                    'lang' => $request['lang']
                ]);
            }
            $addres = UserAdress::findOne($orderMeta['adress_shipig']);
            if ($orderMeta['payment_type'] == OrdersMeta::CARD) {
                $text = PaymentType::findOne(1);
                return $this->render('payment-final-card', [
                    'text' => $text,
                    'lang' => $request['lang'],
                    'userAdress' => $userAdress,
                    'orderStatus' => $orderStatus,
                    'orderMeta' => $orderMeta,
                    'order' => $order,
                    'addres' => $addres
                ]);
            }
            if ($orderMeta['payment_type'] == OrdersMeta::TRISBY) {
                return $this->render('payment-final-trisby', [
                    'lang' => $request['lang'],
                ]);
                // echo 'Вы будете перенаправлены на страницу оплаты';
            }
        }
        return $this->render('payment-final', [
            'lang' => $request['lang']
        ]);
    }

    protected function Cart()
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart');
        if ($cart) {
            return $cart;
        }
        return null;
    }

    public function actionCartData()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $data = $request->post();
            $session = Yii::$app->session;
            $cart = $session->get('cart');

            $idData = Product::find()->where(['id' => ArrayHelper::getColumn($cart, 'id')])->all();
            $dataTovar = [];
            $summSet = 0;
            foreach ($idData as $item) {
                if (!empty($item->getImageProductList())) {
                    foreach ($item->getImageProductList() as $elem) {
                        $img = reset($elem);
                        $image = $img['value'];

                    }
                } else {
                    $image = "/adminStyle/assets/img/no-image.png";
                }

                $priceData = $item->getPriceProduct('ru');

                $dataTovar[$item->id] = [
                    'img' => $image,
                    'count' => $cart[$item->id]['count'],
                    'id' => $item->id,
                    'price' => ($priceData['summ'] ? $priceData['summ'] : $priceData['price']) * $cart[$item->id]['count'],
                    'symbol' => $priceData['symbolCode'],
                    'name' => $item->getParam('productName')
                ];
                $summSet = $summSet + ($priceData['summ'] ? $priceData['summ'] : $priceData['price']) * $cart[$item->id]['count'];

            }
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            return $response->data = [
                'data' => $this->renderAjax('cart-mob', [
                    'dataTovar' => $dataTovar,
                ]),
                'summSet' => $summSet
            ];
        }
    }

}