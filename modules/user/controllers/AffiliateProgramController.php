<?php

namespace app\modules\user\controllers;

use app\models\Cart;
use app\models\Currencies;
use app\models\MailMessage;
use app\models\Orders;
use app\models\OrdersMeta;
use app\models\OrderStatus;
use app\models\Product;
use app\models\PromoUser;
use app\models\PromoUserSize;
use app\models\User;
use app\models\UserActivePromo;
use app\models\UserAdress;
use app\models\UserBalance;
use app\models\UserReport;
use app\models\UserRequest;
use Exception;
use Yii;
use yii\bootstrap5\BootstrapAsset;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `user` module
 */

class AffiliateProgramController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        $request = Yii::$app->request->get();
                        return $action->controller->redirect('/' . $request['lang'] . '/login');
                    } else {
                        return $action->controller->goHome();
                    }
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'modal-show', 'order', 'balance', 'report', 'send-form-benefit', 'delete-promo', 'analytics'],
                        'roles' => ['user', 'administrator'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $userPromo = PromoUser::find()->where(['user_id' => $user->id])->all();
        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if (isset($data['newPromocode']) && !empty($data['newPromocode'])) {
                $newUserPromocode = $this->newUserPromocode($data['newPromocode'], $user);
            } else {
                foreach ($data['simple'] as $key => $item) {
                    //2
                    $PromoUserSize = PromoUserSize::find()
                        ->where(['promo_user_id' => $data['id']])
                        ->andWhere(['category_promo_id' => 2])
                        ->andWhere(['type' => $key])
                        ->one();
                    $PromoUserSize->size = $item;
                    if (!$PromoUserSize->save()) {
                        return debug($PromoUserSize->getErrors());
                    }
                }
                

                foreach ($data['services'] as $key => $item) {
                    //3
                    $PromoUserSize = PromoUserSize::find()
                        ->where(['promo_user_id' => $data['id']])
                        ->andWhere(['category_promo_id' => 3])
                        ->andWhere(['type' => $key])
                        ->one();
                    $PromoUserSize->size = $item;
                    if (!$PromoUserSize->save()) {
                        return debug($PromoUserSize->getErrors());
                    }
                }


                foreach ($data['info'] as $key => $item) {
                    //2
                    $PromoUserSize = PromoUserSize::find()
                        ->where(['promo_user_id' => $data['id']])
                        ->andWhere(['category_promo_id' => 1])
                        ->andWhere(['type' => $key])
                        ->one();
                    $PromoUserSize->size = $item;
                    if (!$PromoUserSize->save()) {
                        return debug($PromoUserSize->getErrors());
                    }
                }
                $promo = PromoUser::findOne($data['id']);
                $promo->lavel_id = $user->userLavel->lavel_id;
                if (!$promo->save()) {
                    return debug($promo->getErrors());
                }
            }
            return $this->refresh();
        }

        if ($user->userLavel->lavel_id == 1) {
            return $this->render('index', [
                'lang' => $request['lang'],
                'user' => $user,
                'userPromo' => $userPromo,

            ]);
        } else {
            return $this->render('lavel', [
                'lang' => $request['lang'],
                'user' => $user,
                'userPromo' => $userPromo,

            ]);
        }
    }
    protected function newUserPromocode(array $data, $user): mixed
    {
        
        $model = new PromoUser([
            'name' => $data['name_new_promocode'],
            'link' => $data['link_new_promocode'],
            'user_id' => Yii::$app->user->identity->id,
            'lavel_id' => $user->userLavel->lavel_id
        ]);
        if (!$model->save()) {
            return $model->getErrors();
        }
        $promoId = $model->id;
        foreach ($data['simple'] as $key => $val) {
            $promoSizeSimple = new PromoUserSize([
                'promo_user_id' => $promoId,
                'category_promo_id' => 2,
                'size' => $val,
                'type' => $key
            ]);
            if (!$promoSizeSimple->save()) {
                return $promoSizeSimple->getErrors();
            }
        }
        foreach ($data['info'] as $key => $val) {
            $promoSizeInfo = new PromoUserSize([
                'promo_user_id' => $promoId,
                'category_promo_id' => 1,
                'size' => $val,
                'type' => $key
            ]);
            if (!$promoSizeInfo->save()) {
                return $promoSizeInfo->getErrors();
            }
        }

        foreach ($data['services'] as $key => $val) {
            $promoSizeServices = new PromoUserSize([
                'promo_user_id' => $promoId,
                'category_promo_id' => 3,
                'size' => $val,
                'type' => $key
            ]);
            if (!$promoSizeServices->save()) {
                return $promoSizeServices->getErrors();
            }
        }
        return true;
    }
    public function actionReport()
    {
        $request = Yii::$app->request->get();
        // debug($request);
        $promoUser = PromoUser::find()->select(['id', 'name'])->where(['user_id' => Yii::$app->user->identity->id])->asArray()->all();
        $ordersPromoData = [];
        if($promoUser){
            $userReport = UserReport::find()->where(['promocode_id' => ArrayHelper::getColumn($promoUser , 'id')])->asArray()->all();
            $userPeomoOrders = OrdersMeta::find()->where(['promocode' => ArrayHelper::getColumn($promoUser , 'id')])
                ->with('orders')
                ->with('status')
                ->asArray()
                ->all();

            foreach($userPeomoOrders as $item){
                $ordersPromoData[] = [
                    'data' => $item['orders']['date'],
                    'ip' => $item['orders']['ip'],
                    'count' => $item['orders']['country'],
                    'user_agent' => $item['orders']['user_agent'],
                    'promocode' => $item['promocode'],
                    'order_summ' => $item['order_summ'],
                    'order_id' => $item['order_id'],
                    'status' => $item['status']['status']
                ];
            }
        }

        $result = array_merge($ordersPromoData, $userReport);
        //debug($result);

        //debug($result);

        ArrayHelper::multisort($result, ['data'], [SORT_DESC]);
        $countData = [];

        foreach($result as $key => $item){
            $countData[$item['count']] = $key;
        }


        $provider = new ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 50,
            ],
            // 'sort' => [
            //     'attributes' => ['id', 'name'],
            // ],
        ]);


        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        return $this->render('report', [
            'userReport' => $userReport,
            'lang' => $request['lang'],
            'result' => $result,
            'provider' => $provider,
            'countData' => $countData,
            'request' => $request
        ]);
    }

    public function actionBalance()
    {
        $request = Yii::$app->request->get();
        $user = $this->findModel();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        $query = (new \yii\db\Query())->from('user_balance')->where(['user_id' => $user->id]);
        if ($request['lang'] == 'ru') {
            $minSumm = 3000;
        } else if($request['lang'] == 'cs'){
            $minSumm = 250;
        }else{
            $minSumm = 60;
        }

        $dataArray = [];
        $balanceUser = 0;
        if(Yii::$app->user->identity->id == 66){
            $balanceUser = 5000;
        }
        $namePromocode = [];
        if (!empty($user->userBalance)) {
            foreach ($user->userBalance as $item) {
                if(
                    isset($item->orders->ordersMeta->promoUser->name)
                    && !in_array($item->orders->ordersMeta->promoUser->name, $namePromocode)
                    ){
                    $namePromocode[] = $item->orders->ordersMeta->promoUser->name;
                }
                $dataArray[] = [
                    'name_promo' => (isset($item->orders->ordersMeta->promoUser->name) ? $item->orders->ordersMeta->promoUser->name : ''),
                    'type' => $item->type,
                    'summ_order' => (isset($item->orders->orderSumm) ? $item->orders->orderSumm : ''),
                    'summ_prom' => (isset($item->orders) ? $item->orders->Reward() : $item->summ),
                    'cyrrency' => (isset($item->orders->cyrrency) ? $item->orders->cyrrency : ''),
                    'order_id' => (isset($item->orders->id) ? $item->orders->id : $item->order_id),
                    'date' => $item->date,
                    'icon' => (isset($item->orders) ? Currencies::getIcon($item->orders->cyrrency) : Currencies::getIcon($item->cyrrency))
                ];
                ArrayHelper::multisort($dataArray, ['date'], [SORT_DESC]);
                if ($item->type == UserBalance::STATUS_REFILL) {
                    if (isset($item->orders->cyrrency) && $item->orders->cyrrency != 'ru') {
                        $balanceUser = $balanceUser + ($item->orders->Reward() / Currencies::getCode($item->orders->cyrrency));
                    } else {
                        $balanceUser = $balanceUser + $item->orders->Reward();
                    }
                } else if ($item->type == UserBalance::STATUS_DEBIT && $item->status != 2) {
                    if (isset($item->cyrrency) &&  $item->cyrrency != 'ru') {
                        $balanceUser = $balanceUser - ($item->summ / Currencies::getCode($item->cyrrency));
                    } else {
                        $balanceUser = $balanceUser - $item->summ;
                    }
                }
            }
        }
        if ($request['lang'] != 'ru') {
            $balanceUser = $balanceUser * Currencies::getCode($request['lang']);
        }
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
             $model = new UserBalance([
                'user_id' => Yii::$app->user->identity->id,
                'summ' => $data['summ'],
                'type' => UserBalance::STATUS_DEBIT,
                'cyrrency' => $request['lang'],
                'data' => $data['data'],
                'link' => $data['link']
            ]);
            MailMessage::NewMessage($user->lang, 15, Yii::$app->user->identity->username, [
                'name' => Yii::$app->user->identity->username,
                'username' => Yii::$app->user->identity->username,
            ]);
            if ($model->save()) {
                return $this->refresh();
            };
        }
        
        $start = '';
        if(isset($request['start_filter']) && !empty($request['start_filter'])){
            try{
                $dtime = \DateTime::createFromFormat("d/m/Y", $request['start_filter']);
                if(!empty($dtime)){
                    $start = $dtime->getTimestamp();
                }
                
            }catch(Exception $e){
            }
        }

        $finish = '';
        if(isset($request['finish_filter']) && !empty($request['finish_filter'])){
            try{
                $dtime = \DateTime::createFromFormat("d/m/Y", $request['finish_filter']);
                if(!empty($dtime)){
                    $finish = $dtime->getTimestamp();
                }
                
            }catch(Exception $e){
            }
        }

        $newSetArray = [];
        if(!empty($start)){
            foreach($dataArray as $d){
                    if($d['date'] > $start){
                        $newSetArray[] = $d;
                    }
            }
            $dataArray = $newSetArray;
        }

        $finishSetArray = [];
        if(!empty($finish)){
            foreach($dataArray as $d){
                    if($d['date'] < $finish){
                        $finishSetArray[] = $d;
                    }
            }
            $dataArray = $finishSetArray;
        }

        if(isset($request['filter_reports__link']) && $request['filter_reports__link'] != 0){
            $newArray = [];
            foreach($dataArray as $item => $el){
                if($el['name_promo'] == $request['filter_reports__link']){
                    $newArray[] = $el;
                }
            }
            $dataArray = $newArray;
        }
        //debug($request);
        // $d1 = strtotime('10/06/2024');

        return $this->render('balance', [
            'balanceUser' => $balanceUser,
            'lang' => $request['lang'],
            'user' => $user,
            'dataArray' => $dataArray,
            'minSumm' => $minSumm,
            'namePromocode' => $namePromocode,
            'request'=> $request
        ]);
    }

    public function actionSendFormBenefit()
    {
        $request = Yii::$app->request->get();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            //debug($data);
            $array = ArrayHelper::map($data['data'], 'name', 'value');
            $model = new UserRequest([
                'text' => $array['why_benefit'],
                'user_id' => Yii::$app->user->identity->id,
                'type' => 1
            ]);
            MailMessage::NewMessage($data['lang'], 12, Yii::$app->user->identity->username, [
                'name' => Yii::$app->user->identity->username,
                'username' => Yii::$app->user->identity->username,
            ]);

            if (!$model->save()) {
                return debug($model->getErrors());
            }
            ;
        }
        return true;
    }

    public function actionDeletePromo()
    {
        if (Yii::$app->request->isAjax) {
            try {
                $data = Yii::$app->request->post();
                $model = PromoUser::findOne($data['id']);
                $model->delete();
                $modelArray = PromoUserSize::find()->where(['promo_user_id' => $data['id']])->all();
                foreach ($modelArray as $a => $b) {
                    $b->delete();
                }
                $activeUserPromo = UserActivePromo::find()->where(['promo_id' => $data['id']])->all();
                foreach ($activeUserPromo as $e => $c) {
                    $c->delete();
                }
                return true;
            } catch (Exception $e) {
                return false;
            }


        }
    }

    public function actionAnalytics( $sort = null){
        $dateStart = 0;
        $dateEnd = date('Y-m-d');
        if($sort == 1){
            $dateAt = strtotime('-1 MONTH', strtotime($dateEnd));
        }
        if($sort == 3){
            $dateAt = strtotime('-3 MONTH', strtotime($dateEnd));
        }
        if($sort == 4){
            $dateAt = strtotime('-6 MONTH', strtotime($dateEnd));
        }
        if($sort == 5){
            $dateAt = strtotime('-12 MONTH', strtotime($dateEnd));
        }
        if($sort == 2){
            $dateAt = strtotime('-1 MONTH', strtotime($dateEnd));
        }

        $request = Yii::$app->request->get();
        Yii::$app->language = mb_strtolower($request['lang']) . "-" . mb_strtoupper($request['lang']);
        $user = User::findOne(Yii::$app->user->identity->id);
        $noPayOrder = [];
        $payOrder = [];
        $profit = 0;
        $promoId = ArrayHelper::getColumn($user->promoUser, 'id');
        foreach($user->promoUser as $item){
            foreach($item->ordersMeta as $elem){
                if($elem->status->status == OrderStatus::STATUS_NEW){
                    $noPayOrder[] = $elem; 
                }
                if($elem->status->status == OrderStatus::STATUS_PAY || $elem->status->status == OrderStatus::STATUS_CLOSE){
                    $payOrder[] = $elem;
                }
                
            }
            
        }

        $userBalanse = UserBalance::find()->where(['user_id' => $user->id])->andWhere(['type' => UserBalance::STATUS_REFILL])->asArray()->all();
        $summBalansce = 0;
        foreach($userBalanse as $data){
            $summBalansce = $summBalansce + $data['summ'];
        }
        if($request['lang'] != 'ru'){
            $cyrr = Currencies::find()->where(['tag' => $request['lang']])->asArray()->one();
            $summBalansce = $summBalansce * $cyrr['code'];
        }
        $userReport = UserReport::find()->where(['promocode_id' => $promoId])->count();


        $conversion = 0;
        if($userReport != 0 && count($payOrder)!=0){
            $conversion = count($payOrder)/($userReport/100);
            $conversion = round($conversion, 2);
        }

        $averageBill = 0;
        $userOrderData = UserBalance::find()->select('order_id')->where(['user_id' => $user->id])->andWhere(['type' => UserBalance::STATUS_REFILL])->andWhere(['!=','order_id', 0])->asArray()->all();

        $ordersList = Orders::find()->where(['id' => ArrayHelper::getColumn($userOrderData, 'order_id')])->select('data_order')->asArray()->all();
        
        $dataOurSumm = 0;
        foreach($ordersList as $elem){
            foreach(unserialize($elem['data_order']) as $def => $rty){
                $price = Product::getPriceProductbyId($def, $request['lang'], $type = null);
                if(isset($price['productPac']['pricePac-1']) && !empty($price['productPac']['pricePac-1']) && (int)$rty['count'] == 1){
                    $dataOurSumm = $dataOurSumm + ((isset($price['productPac']['pricePac-1']['sale']) && !empty($price['productPac']['pricePac-1']['sale']) ? (int)$price['productPac']['pricePac-1']['sale'] : (int)$price['productPac']['pricePac-1']['prise']) * (int)$rty['count']);
                }
                else if(isset($price['productPac']['pricePac-2']) && !empty($price['productPac']['pricePac-2']) && (int)$rty['count'] == 2){
                    $dataOurSumm = $dataOurSumm + ((isset($price['productPac']['pricePac-2']['sale']) && !empty($price['productPac']['pricePac-2']['sale']) ? (int)$price['productPac']['pricePac-2']['sale'] : (int)$price['productPac']['pricePac-2']['prise']) * (int)$rty['count']);
                }
                else if(isset($price['productPac']['pricePac-3']) && !empty($price['productPac']['pricePac-3']) && (int)$rty['count'] <= 3){
                    $dataOurSumm = $dataOurSumm + ((isset($price['productPac']['pricePac-3']['sale']) && !empty($price['productPac']['pricePac-3']['sale']) ? (int)$price['productPac']['pricePac-3']['sale'] : (int)$price['productPac']['pricePac-3']['prise']) * (int)$rty['count']);
                }else{
                    if(isset($price['summ']) && !empty($price['summ'])){
                        $dataOurSumm = $dataOurSumm + ($price['summ'] * (int)$rty['count']);
                    }else{
                        $dataOurSumm = $dataOurSumm + ($price['price'] * (int)$rty['count']);
                    }
                }
            }
        }
        
        if($summBalansce != 0){
            $averageBill = $summBalansce / count($userBalanse);
        }
        return $this->render('analytics', [
            'lang' => $request['lang'],
            'payOrder' => $payOrder,
            'noPayOrder' => $noPayOrder,
            'summBalansce' => $summBalansce,
            'userReport' => $userReport,
            'conversion' => $conversion,
            'averageBill' => $averageBill,
            'dataOurSumm' => $dataOurSumm
        ]);
    }

    protected function findModel()
    {
        if (($model = User::findOne(['id' => Yii::$app->user->identity->id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}