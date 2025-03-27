<?php

namespace app\models;

use Exception;
use Yii;
use yii\base\Model;
use TelegramBot\Api\Client;
use yii\helpers\ArrayHelper;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class MailMessage extends Model
{
    public static function SendMessageUser($attr, $content, $email, $template, $title) :bool{
        $titleParse = new Shortcode($attr);
        try{
            Yii::$app->mailer->compose($template, ['content' => $content, 'attr' => $attr])
            ->setFrom('info@body-balance.com')
            ->setTo($email)
            ->setSubject($titleParse->parse($title))
            ->send();
        return true;
        }catch(Exception $e){
            return false;
        }
    }

    public static function NewMessage($lang, $template, $email, $attr): bool
    {
        if ($lang == 'ru') {
            $model = MailTemplate::find()->where(['id' => $template])->one();
        } else {
            if (MailTemplateLang::find()->where(['parent_id' => $template])->andWhere(['lang' => $lang])->exists()) {
                $model = MailTemplateLang::find()->where(['parent_id' => $template])->andWhere(['lang' => $lang])->one();
            } else {
                $model = MailTemplate::find()->where(['id' => $template])->one();
            }
        }
        $message = self::SendMessageUser($attr, $model->content, $email, 'contact/html', $model->title);
        return true;
    }

    public static function SendRegistration($lang, $email, $password)
    {
        if ($lang == 'ru') {
            $model = MailTemplate::find()->where(['id' => 1])->one();
        } else {
            if (MailTemplateLang::find()->where(['parent_id' => 1])->andWhere(['lang' => $lang])->exists()) {
                $model = MailTemplateLang::find()->where(['parent_id' => 1])->andWhere(['lang' => $lang])->one();
            } else {
                $model = MailTemplate::find()->where(['id' => 1])->one();
            }
        }
        $attr = [
            'password' => $password,
            'name' => $email,
            'lang' => $lang,
            'username' => $email,
            'userData' => $email,
        ];
        $message = self::SendMessageUser($attr, $model->content, $email, 'contact/html', $model->title);
        return true;
    }

    public static function OpenInfo($lang, $email, $attr)
    {
        if ($lang == 'ru') {
            $model = MailTemplate::find()->where(['id' => 8])->one();
        } else {
            if (MailTemplateLang::find()->where(['parent_id' => 8])->andWhere(['lang' => $lang])->exists()) {
                $model = MailTemplateLang::find()->where(['parent_id' => 8])->andWhere(['lang' => $lang])->one();
            } else {
                $model = MailTemplate::find()->where(['id' => 8])->one();
            }
        }
        try {
            $message = self::SendMessageUser($attr, $model->content, $email, 'contact/html', $model->title);
            return true;
        } catch (Exception $e) {
            echo 'Ошибка отправки';
        }
    }

    public static function SendRecoverPass($lang, $email, $newPassword)
    {
        if ($lang == 'ru') {
            $model = MailTemplate::find()->where(['id' => 2])->one();
        } else {
            if (MailTemplateLang::find()->where(['parent_id' => 2])->andWhere(['lang' => $lang])->exists()) {
                $model = MailTemplateLang::find()->where(['parent_id' => 2])->andWhere(['lang' => $lang])->one();
            } else {
                $model = MailTemplate::find()->where(['id' => 2])->one();
            }
        }
        $attr = [
            'password' => $newPassword,
            'username' => $email,
        ];
        try {
            $message = self::SendMessageUser($attr, $model->content, $email, 'contact/html', $model->title);
            return true;
        } catch (Exception $e) {
            echo 'Ошибка отправки';
        }
    }

    public static function SendNewOrder($lang, $attr, $email, $order_id = null)
    {
        if (!$attr) {
            $attr = self::AttrData($order_id);
        }
        if (MessageSendOrder::find()->where(['order_id' => $order_id])->andWhere(['type' => 'mail'])->exists()) {
            return false;
        } else {
            $model = new MessageSendOrder([
                'order_id' => (int) $order_id,
                'template_id' => 1,
                'send' => 1,
                'type' => 'mail',
            ]);
            if (!$model->save()) {
                return $model->getErrors();
            };
        }
        if ($lang != 'ru') {
            $model = MailTemplateLang::find()->where(['parent_id' => 3])->andWhere(['lang' => $lang])->one();
        } else {
            $model = MailTemplate::find()->where(['id' => 3])->one();
        }
        $message = self::SendMessageUser($attr, $model->content, $email, 'contact/html', $model->title);
        return false;
    }

    public static function UpdateStatus($order_id, $template)
    {
        $attr = self::AttrData($order_id);
        $model = MailTemplate::find()->where(['id' => $template])->one();
        $message = self::SendMessageUser($attr, $model->content, $attr['email'], 'contact/html', $model->title);
        return false;
    }

    public static function AttrData($order_id)
    {
        $order = Orders::find()
            ->where(['id' => $order_id])
            ->with('ordersMeta')
            ->with('user')
            ->one();
        Yii::$app->language = mb_strtolower($order->cyrrency) . "-" . mb_strtoupper($order->cyrrency);
        $product = Product::find()->where(['id' => array_keys(unserialize($order->data_order))])->all();
        $orderList = unserialize($order->data_order);
        $viewData = "<ul>";
        $viewArray = array();


        $iconOrder = Currencies::getIcon($order->cyrrency);
        foreach ($product as $item) {
            $priceData = Product::getPriceProductbyId($item->id, $order->cyrrency);
            $type = $item->getParam('type', null);
            $image = $item->getParam('image', null);
            $link = $item->getParam('link', $order->cyrrency);
            if ($item->getParam('shortName', $order->cyrrency)) {
                $name = $item->getParam('shortName', $order->cyrrency);
            } else {
                $name = $item->getParam('productName', $order->cyrrency);
            }
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
            $viewData .= number_format($price, 0, '', ' ') . " " . $iconOrder;
            $viewData .= "</span><span></span></li>";
            $viewArray[] = $name . " " . "×" . $orderList[$item->id]['count'] . " - " . number_format($price, 0, '', ' ') . " " . $iconOrder;
        }
        ;
        $viewArray[] = "\n" . "<b>Доп. данные:</b>";
        if (!empty($order->ordersMeta->promocode)) {
            $viewData .= "<li>" . Yii::t('app', 'discount-using-promo-code') . " " . $order->ordersMeta->promoUser->name . ": " . Cart::PromocodeSizeSale(['data' => $orderList], $product, $order->cyrrency, $order->ordersMeta->promocode) . "</li>";
            $viewArray[] = "Промокод \"" . $order->ordersMeta->promoUser->name . "\": " .
                Cart::PromocodeSizeSale(['data' => $orderList], $product, $order->cyrrency, $order->ordersMeta->promocode);
        }

        if (!empty($order->ordersMeta->coupon)) {
            $viewData .= "<li>" . Yii::t('app', 'coupon-txt') . " " . $order->ordersMeta->coupon_name . ": " . $order->ordersMeta->coupon_summ . " " . $iconOrder . "</li>";
            $viewArray[] = "Купон \"" . $order->ordersMeta->coupon_name . "\": " . $order->ordersMeta->coupon_summ . " " . $iconOrder;
        }

        if (!empty($order->ordersMeta->shiping_type) && $order->ordersMeta->shiping_type != 'info') {

            if($order->cyrrency == 'ru'){
                $summDL = $order->getShipingSumm();
            }else{
                $code = Currencies::find()->where(['tag' => $order->cyrrency])->asArray()->one();
                $summDL = $order->getShipingSumm();
                $summDL = $summDL * $code['code'];
            }

            $viewData .= "<li>" . Yii::t('app', 'delivery-txt') . " " . number_format($summDL, 0, '', ' ') . " " . $iconOrder . "</li>";
            $viewArray[] = "Доставка" . ": " . number_format($summDL, 0, '', ' ') . " " . $iconOrder;
        }

        if (!empty($order->ordersMeta->insurance) && $order->ordersMeta->insurance == '1') {
            $viewData .= "<li>" . Yii::t('app', 'insurance-txt') . ": " . Insurance::getInstance()->getSumm($order->cyrrency, null, $order->id) . " " . $iconOrder . "</li>";
            $viewArray[] = "Страховка: " . Insurance::getInstance()->getSumm($order->cyrrency, null, $order->id) . " " . $iconOrder;
        }



        $sumPayTotal = Cart::totalSumm(
            ['data' => $orderList],
            $product,
            $order->cyrrency,
            $order->ordersMeta->coupon_name,
            $order->ordersMeta->promocode,
            $order->ordersMeta->shiping_type,
            true,
            $order->id,
            $order->ordersMeta->userAdress->postcode
        );

        

        $viewData .= "<li>" . Yii::t('app', 'total') . ": " .
            number_format($sumPayTotal, 0, '', ' ') . " " . $iconOrder . "</li></ul>";
        $viewArray[] = "\n" . "<b>Итого" . ": " . number_format($sumPayTotal, 0, '', ' ') . " " . $iconOrder . "</b>";

        $paymnetLink = '';

        if ($order->ordersMeta->payment_type == Cart::TRISBY) { 


            if($order->cyrrency == 'ru'){
            $dataSetF = Currencies::find()->where(['tag'=> 'cs'])->asArray()->one();
            $sumPayTotalCs = $sumPayTotal * $dataSetF['code'];
        }else if($order->cyrrency == 'en'){
            $dataSetFCs = Currencies::find()->where(['tag'=> 'cs'])->asArray()->one();
            $dataSetFEn = Currencies::find()->where(['tag'=> 'en'])->asArray()->one();
            $sumPayTotalCs = round($sumPayTotal / $dataSetFEn['code'] * $dataSetFCs['code']);
        }else{
            $sumPayTotalCs = $sumPayTotal;
        }

            $paymnetLink = "https://pay.trisbee.com/bodybalanceclinic/" . $sumPayTotalCs;
        }
        $attr = array(
            'order_id' => $order_id,
            'lastname' => $order->user->LastName,
            'name' => $order->user->firstName,
            'surname' => $order->user->secondName,
            'phone' => $order->user->phone,
            'email' => $order->user->email,
            'postcode' => $order->ordersMeta->userAdress->postcode,
            'country' => $order->ordersMeta->userAdress->country,
            'city' => $order->ordersMeta->userAdress->city,
            'area' => $order->ordersMeta->userAdress->area,
            'home' => $order->ordersMeta->userAdress->flat,
            'comment' => $order->ordersMeta->comment,
            'street' => $order->ordersMeta->userAdress->street,
            'flat' => $order->ordersMeta->userAdress->flat,
            'viewData' => $viewData,
            'currensy' => $order->cyrrency,
            'del-track' => $order->del_track,
            'delivery' => Yii::t('app', 'del-' . $order->ordersMeta->shiping_type),
            'payment' => Yii::t('app', 'pay-' . $order->ordersMeta->payment_type . '-mess'),
            'viewArray' => $viewArray,
            'paymnet-link' => $paymnetLink,
            'password' => $order->user->password,
            'username' => $order->user->email,
        );
        return $attr;
    }


    public static function TelegramMessage($order_id)
    {
        $attr = self::AttrData($order_id);
        if (MessageSendOrder::find()->where(['order_id' => $order_id])->andWhere(['type' => 'telega'])->exists()) {
            return '123';
        } else {
            $model = new MessageSendOrder([
                'order_id' => $attr['order_id'],
                'template_id' => 1,
                'send' => 1,
                'type' => 'telega',
            ]);
            if (!$model->save()) {
                return $model->getErrors();
            }
            ;
        }

        define('TELEGRAM_TOKEN', '5389797200:AAEvyJycHQttwKzkwXz1kXpmGP7yUisVVxk');
        define('TELEGRAM_CHATID', '1270374546');
        $ch = curl_init();
        $message = '';
        $message .= "<b>Новый заказ #{$attr['order_id']} (" . strtoupper($attr['currensy']) . ")</b>" . "\n";
        $message .= "ФИО: {$attr['surname']} {$attr['name']} {$attr['lastname']}" . "\n";
        $message .= "Телефон: {$attr['phone']}" . "\n";
        $message .= "E-Mail: {$attr['email']}" . "\n" . "\n";
        $message .= "<b>Адрес доставки:</b>" . "\n";
        $message .= "Индекс: {$attr['postcode']}" . "\n";
        $message .= "Страна: {$attr['country']}" . "\n";
        $message .= "Область: {$attr['area']}" . "\n";
        $message .= "Город: {$attr['city']}" . "\n";
        $message .= "Улица: {$attr['street']}" . "\n";
        $message .= "Дом, квартира: {$attr['flat']}" . "\n" . "\n";
        if (isset($attr['comment']) && !empty($attr['comment'])) {
            $message .= "<b>Комментарий:</b>" . "\n";
            $message .= "{$attr['comment']}" . "\n" . "\n";
        }
        $message .= "<b>Товары:</b>" . "\n";
        foreach ($attr['viewArray'] as $key => $item) {
            $message .= $item . "\n";
        }
        $mh = curl_multi_init();
        $telegramArray = TelegramUser::find()->asArray()->all();
        $chatId = ArrayHelper::getColumn($telegramArray, 'chat_id');
        // $chatId = [
        //     '385322204',
        //     '1270374546'
        // ];

        foreach ($chatId as $key => $item) {
            $params = array(
                'chat_id' => $item,
                'text' => $message,
                'parse_mode' => 'HTML',
            );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage');
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_multi_add_handle($mh, $curl);
        }

        do {
            $status = curl_multi_exec($mh, $active);
            if ($active) {
                curl_multi_select($mh);
            }
        } while ($active && $status == CURLM_OK);
        curl_multi_close($mh);
    }

    public static function SendPaySuccess($order_id)
    {
        define('TELEGRAM_TOKEN', '5389797200:AAEvyJycHQttwKzkwXz1kXpmGP7yUisVVxk');
        define('TELEGRAM_CHATID', '1270374546');
        
        $telegramArray = TelegramUser::find()->asArray()->all();
        $chatId = ArrayHelper::getColumn($telegramArray, 'chat_id');

        $mh = curl_multi_init();
        foreach ($chatId as $key => $item) {
            $message = "<b>Заказ #{$order_id} оплачен.</b>";
            $params = array(
                'chat_id' => $item,
                'text' => $message,
                'parse_mode' => 'HTML',
            );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage');
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_multi_add_handle($mh, $curl);
        }
        do {
            $status = curl_multi_exec($mh, $active);
            if ($active) {
                curl_multi_select($mh);
            }
        } while ($active && $status == CURLM_OK);
        curl_multi_close($mh);

    }

    public static function NewPromo($order_id)
    {
        if (OrdersMeta::find()->where(['order_id' => $order_id])->exists()) {
            $orderMeta = OrdersMeta::find()->where(['order_id' => $order_id])->one();
            $promocode = $orderMeta->promocode;
            $userPromo = PromoUser::find()->where(['id' => $promocode])->asArray()->one();
            if ($userPromo && TelegramChatList::find()->where(['user_id' => $userPromo['user_id']])->exists()) {
                $TelegramChatList = TelegramChatList::find()->where(['user_id' => $userPromo['user_id']])->one();
                $orders = Orders::findOne($order_id);
                $message = "<b>Заказ #{$order_id}</b> " . "\n" . "По вашему партнерскому промокоду был оплачен заказ на сумму {$orders->orderSumm}" . " " . Currencies::getIcon($orders->cyrrency) . ". Ваш процент вознаграждения: {$orders->Reward()}" . " " . Currencies::getIcon($orders->cyrrency) . ".";
                $array = array(
                    "chat_id" => $TelegramChatList->chat,
                    "text" => $message,
                    'parse_mode' => 'HTML',
                );
                $token = '6249777943:AAGK4FfCtlSEfDD_72Mbi7KMVcB_CsqFefg';
                $url = "https://api.telegram.org/bot" . $token . "/sendMessage?" . http_build_query($array);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, false);
                $resultQuery = curl_exec($ch);
                curl_close($ch);
            }
        }
    }


    public static function BalanseSuccess($user_id)
    {
        if (TelegramChatList::find()->where(['user_id' => $user_id])->exists()) {
            $TelegramChatList = TelegramChatList::find()->where(['user_id' => $user_id])->one();
            $message = '';
            $message .= "Проверьте баланс вашей карты."."\n";
            $message .= "Администрация одобрила ваш запрос на вывод средств.";
            $array = array(
                "chat_id" => $TelegramChatList->chat,
                "text" => $message,
                'parse_mode' => 'HTML',
            );
            $token = '6249777943:AAGK4FfCtlSEfDD_72Mbi7KMVcB_CsqFefg';
            $url = "https://api.telegram.org/bot" . $token . "/sendMessage?" . http_build_query($array);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $resultQuery = curl_exec($ch);
            curl_close($ch);
        }
    }

}