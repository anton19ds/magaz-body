<?php

namespace app\modules\admin\controllers;

use app\models\AccessInfoProduct;
use app\models\Cart;
use app\models\CommentForUser;
use app\models\Currencies;
use app\models\MailMessage;
use app\models\Orders;
use app\models\OrderStatus;
use app\models\Product;
use app\models\User;
use app\models\UserBalance;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends MainController
{
    /**
     * @inheritDoc
     */

    public $title = "Заказы";
    public $preTitle = "Заказы";
    //  public $actionType ="/admin/orders/create";
    public $actionType = "";

    public $lang;


    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex($sort = null)
    {
        $quesry = Orders::find()->where(['status' => 'active']);
        if(!empty($sort)){
            if($sort == 'arcive'){
              $quesry = Orders::find()->where(['status' => 'arhive'])->orderBy(['id' => SORT_DESC]);
            }else if($sort == 'nopay'){
                $quesry = Orders::find()
                ->select('orders.*, order_status.status')
                ->where(['orders.status' => 'active'])
                ->leftJoin('order_status', 'order_status.order_id = orders.id')
                ->andWhere(['order_status.status' => 'new']);
            }else if($sort == 'pay'){
                $quesry = Orders::find()
                ->select('orders.*, order_status.status')
                ->where(['orders.status' => 'active'])
                ->leftJoin('order_status', 'order_status.order_id = orders.id')
                ->andWhere(['order_status.status' => 'pay']);
            }else if($sort == 'close'){
                $quesry = Orders::find()
                ->select('orders.*, order_status.status')
                ->where(['orders.status' => 'active'])
                ->leftJoin('order_status', 'order_status.order_id = orders.id')
                ->andWhere(['order_status.status' => 'close']);
            }else if($sort == 'failed'){
                $quesry = Orders::find()
                ->select('orders.*, order_status.status')
                ->where(['orders.status' => 'active'])
                ->leftJoin('order_status', 'order_status.order_id = orders.id')
                ->andWhere(['order_status.status' => 'failed']);
            }else if($sort == 'return'){
                $quesry = Orders::find()
                ->select('orders.*, order_status.status')
                ->where(['orders.status' => 'active'])
                ->leftJoin('order_status', 'order_status.order_id = orders.id')
                ->andWhere(['order_status.status' => 'return']);
            }

        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $quesry,
            'pagination' => [
                'pageSize' => 30,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        

        $status = [
            'Все' =>Orders::find()
            ->select('orders.id, order_status.status')
            ->where(['orders.status' => 'active'])
            ->leftJoin('order_status', 'order_status.order_id = orders.id')
            ->count(),
            'Ожидает оплаты' => Orders::find()
            ->select('orders.id, order_status.status')
            ->where(['orders.status' => 'active'])
            ->leftJoin('order_status', 'order_status.order_id = orders.id')
            ->andWhere(['order_status.status' => 'new'])
            ->count(),
            'Обрабатывается' => Orders::find()
            ->select('orders.id, order_status.status')
            ->where(['orders.status' => 'active'])
            ->leftJoin('order_status', 'order_status.order_id = orders.id')
            ->andWhere(['order_status.status' => 'pay'])
            ->count(),
            'Завершен' => Orders::find()
            ->select('orders.id, order_status.status')
            ->where(['orders.status' => 'active'])
            ->leftJoin('order_status', 'order_status.order_id = orders.id')
            ->andWhere(['order_status.status' => 'close'])
            ->count(),
            'Отменен' => Orders::find()
            ->select('orders.id, order_status.status')
            ->where(['orders.status' => 'active'])
            ->leftJoin('order_status', 'order_status.order_id = orders.id')
            ->andWhere(['order_status.status' => 'failed'])
            ->count(),
            'Возврат' => Orders::find()
            ->select('orders.id, order_status.status')
            ->where(['orders.status' => 'active'])
            ->leftJoin('order_status', 'order_status.order_id = orders.id')
            ->andWhere(['order_status.status' => 'return'])
            ->count(),
            'Архив' => 0
        ];

        //debug($status);

        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'status' => $status,
            'sort' => $sort,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => CommentForUser::find()->where(['order_id' => $id]),
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ]
            ],
        ]);
        if ($this->request->isPost) {
            $data = Yii::$app->request->post();
            if(isset($data['comment_for_user']) && !empty($data['comment_for_user'])){
                $commentForUser = new CommentForUser([
                    'order_id' => $id,
                    'text' => $data['comment_for_user'],
                    'lang' => $model->cyrrency
                ]);
                $attr = [
                    'text' => $data['comment_for_user'],
                    'order_id' => $id,
                    'name' => $model->ordersMeta->userAdress->name
                ];
                MailMessage::NewMessage($model->cyrrency, 6, $model->user->email, $attr);
                $commentForUser->save();
            }
            if($model->load($data)){
                $model->save();
            }
            //debug($data);
             //$model->load($this->request->post()) && $model->save()
            return $this->refresh();
        }


        $dataOrder = unserialize($model->data_order);
        $product = Product::find()->where(['id' => array_keys($dataOrder)])->all();
        $icon = '₽';
        $curensy = Currencies::find()->where(['tag' => $model->cyrrency])->asArray()->one();
        //debug($curensy);
        if($model->cyrrency != 'ru'){
            $icon = $curensy['icon'];
        }



        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'product' => $product,
            'icon' => $icon,
            'dataOrder' => $dataOrder
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdateStatus()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $models = $this->findModel($data['id']);
            $modelsMeta = $models->ordersMeta;
            $statusOrders = $models->orderStatus;
            $statusOrders->status = $data['value'];

                if ($data['value'] == OrderStatus::STATUS_PAY) {
                    $user = User::find()->where(['id' => $models->user_id])->one();
                    $messageSendOrder = MailMessage::UpdateStatus($data['id'], 4);
                    $lang = $models->cyrrency;
                    $this->AddAccess($models->data_order, $models->user_id, $models->uuid, $lang, $user);
                    MailMessage::SendPaySuccess($data['id']);
                    MailMessage::NewPromo($data['id']);
                }
                if ($data['value'] == OrderStatus::STATUS_CLOSE) {
                    $messageSendOrder = MailMessage::UpdateStatus($data['id'], 5);
                }
                if ($data['value'] == OrderStatus::STATUS_FAILED) {
                    $messageSendOrder = MailMessage::UpdateStatus($data['id'], 7);
                }
            if ($statusOrders->save()) {
                if (OrderStatus::STATUS_PAY == $data['value']) {
                    if (!empty($modelsMeta->promocode)) {
                        $orderList = unserialize($models->data_order);
                        $product = Product::find()->where(['id' => array_keys(unserialize($models->data_order))])->all();
                        $summCashBack = Cart::PromocodeSizeSale(['data' => $orderList], $product, $models->cyrrency, $modelsMeta->promocode, true);
                        if (!UserBalance::find()->where(['order_id' => $models->id])->exists()) {
                            $userBalance = new UserBalance([
                                'user_id' => $modelsMeta->promoUser->user_id,
                                'summ' => $models->Reward(),
                                'type' => UserBalance::STATUS_REFILL,
                                'order_id' => $models->id
                            ]);
                            $userBalance->save();
                        }
                    } else {
                        return '123';
                    }
                }
            } else {
                debug($statusOrders->getErrors);
            }
        }
    }

    public function AddAccess($data_order, $user_id, $uuid, $lang, $user){
        $data = unserialize($data_order);
        foreach($data as $key => $value){
            if(Product::getTypeInProduct($key) == 'made'){
                $dataSet = Product::getProductInProduct($key);
                if($dataSet){
                    foreach($dataSet as $el => $item){
                        if(Product::getTypeInProduct($item) == 'info'){
                            $addAccess = AccessInfoProduct::addAccess($user_id, $item, $uuid);
                            $product = Product::findOne($item);
                            MailMessage::OpenInfo($lang, $user->email, $attr = [
                                'username' => $user->email,
                                'password' => $user->password,
                                'name' => $user->email,
                                'infoproduct-name' => $product->getParam('productName', $lang),
                                'infoproduct-link' => 'https://anticandida.com/'.$lang.'/user/info-product/' . $product->getParam('link', $lang)
                            ]);
                        };
                    }
                }
            }else{
                if(Product::getTypeInProduct($key) == 'info'){
                    $addAccess = AccessInfoProduct::addAccess($user_id, $key, $uuid);
                    $product = Product::findOne($key);
                    MailMessage::OpenInfo($lang, $user->email, $attr = [
                        'username' => $user->email,
                        'password' => $user->password,
                        'name' => $user->email,
                        'infoproduct-name' => $product->getParam('productName', $lang),
                        'infoproduct-link' => 'https://anticandida.com/'.$lang.'/user/info-product/' . $product->getParam('link', $lang)
                    ]);
                };
            }
        }
    }

    public function actionTrakUpdate(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $model = Orders::findOne($data['id']);
            $model->del_track = $data['val'];
            if($model->save()){
                return true;
            }
            return false;
        }
    }

    public function actionInArchive(){
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            foreach($data['obj'] as $key => $value){
                $model = Orders::findOne($value);
                $model->status = 'arhive';
                $model->save();
            }
            return true;
        }
    }

    public function actionOutArchive(){
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            foreach($data['obj'] as $key => $value){
                $model = Orders::findOne($value);
                $model->status = 'active';
                $model->save();
            }
            return true;
        }
    }
}
