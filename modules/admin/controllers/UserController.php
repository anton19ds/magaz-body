<?php

namespace app\modules\admin\controllers;

use app\models\AccessInfoProduct;
use app\models\Currencies;
use app\models\MailMessage;
use app\models\Product;
use app\models\PromoUser;
use app\models\Reviews;
use app\models\Tasks;
use app\models\User;
use app\models\UserBalance;
use app\models\UserRequest;
use app\models\UserTasks;
use app\models\SearchUser;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\Sort;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html; 
use Yii;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends MainController
{
    /**
     * @inheritDoc
     */
    public $title;
    public $preTitle;
    public $actionType = "/admin/user/create";

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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = User::find();
        $post = null;
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if(!empty($data['search-email'])){
                $post = $data['search-email'];
                $query = $query->where(['like', 'username', $data['search-email']]);
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query->select(['user.*', 'user_lavel.user_id', 'user_lavel.lavel_id'])->leftJoin('user_lavel', 'user_lavel.user_id = user.id'),
            'sort' => [
                'attributes' => 
                    [  'user_lavel.lavel_id' => [
                        'asc' => ['user_lavel.lavel_id' => SORT_ASC],
                        'desc' => ['user_lavel.lavel_id' => SORT_DESC],
                        'default' => SORT_DESC,
                    ]
                ],
            ],

                  
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);
        $searchModel = new SearchUser();
        $searchFilter = $searchModel->search(Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'post' => $post
            //'searchFilter' => $searchFilter
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = User::find()->where(['id' => $id])
            ->with('orders')
            ->with('userLavel')
            ->with('promoUser')
            ->one();

        //debug($model);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->refresh();
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAdress($id)
    {
        $model = $this->findModel($id);
        $provider = new ArrayDataProvider([
            'allModels' => $model->userAdress,
            'pagination' => [
                'pageSize' => 10,
            ],
            // 'sort' => [
            //     'defaultOrder' => [
            //         'created_at' => SORT_DESC,
            //         'title' => SORT_ASC, 
            //     ]
            // ],
        ]);
        $this->title = 'Список адресов';
        return $this->render('set-layot', [
            'view' => 'adress',
            'model' => $model,
            'provider' => $provider
        ]);

    }

    public function actionBalance($id)
    {
        $model = $this->findModel($id);
        $this->actionType = false;
        $balanceUser = 0;
        if (!empty($model->userBalance)) {
            foreach ($model->userBalance as $item) {
                ArrayHelper::multisort($dataArray, ['date'], [SORT_DESC]);
                if ($item->type == UserBalance::STATUS_REFILL) {
                    if ($item->orders->cyrrency != 'ru') {
                        $balanceUser = $balanceUser + ($item->orders->Reward() / Currencies::getCode($item->orders->cyrrency));
                    } else {
                        $balanceUser = $balanceUser + $item->orders->Reward();
                    }
                } else if ($item->type == UserBalance::STATUS_DEBIT) {
                    if ($item->cyrrency != 'ru') {
                        $balanceUser = $balanceUser - ($item->summ / Currencies::getCode($item->cyrrency));
                    } else {
                        $balanceUser = $balanceUser - $item->summ;
                    }
                }
            }
        }
        //debug($balanceUser);


        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $userBalanse = new UserBalance();
            return [
                'title' => "Добавить операцию",
                'content' => $this->renderAjax('addoperation', [
                    'userBalanse' => $userBalanse,
                    'balanceUser' => $balanceUser,
                    'user_id' => $id
                ]),
                'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal", "data-bs-dismiss" => "modal"])
            ];
        }
        if (Yii::$app->request->isPost) {
            $userBalanse = new UserBalance();
            $data = Yii::$app->request->post();
            if ($userBalanse->load($data) && $userBalanse->save()) {
                return $this->refresh();
            } else {
                return var_dump($userBalanse->getErrors());
            }

        }

        $sort = new Sort([
            'attributes' => [
                'date' => [
                    'asc' => ['date' => SORT_ASC],
                    'desc' => ['date' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Дата',
                ],
                // or any other attribute
            ],
            'defaultOrder' => [
                'date' => SORT_DESC
            ]
        ]);

        $provider = new ArrayDataProvider([
            'allModels' => $model->userBalance,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => $sort
        ]);
        $this->title = 'Операции с балансом';
        return $this->render('set-layot', [
            'view' => 'balance',
            'model' => $model,
            'provider' => $provider,
            'balanceUser' => $balanceUser
        ]);
    }

    public function actionOrders($id)
    {
        $model = $this->findModel($id);
        $provider = new ArrayDataProvider([
            'allModels' => $model->orders,
            'pagination' => [
                'pageSize' => 10,
            ],
            // 'sort' => [
            //     'defaultOrder' => [
            //         'created_at' => SORT_DESC,
            //         'title' => SORT_ASC, 
            //     ]
            // ],
        ]);
        $this->title = 'Операции с балансом';
        return $this->render('set-layot', [
            'view' => 'orders',
            'model' => $model,
            'provider' => $provider
        ]);
    }

    public function actionInfocurs($id)
    {
        $model = $this->findModel($id);
        $infoCurs = Product::find()->
            leftJoin("product_meta", "product_meta.product_id=product.id")->
            where(["product_meta.meta" => "type"])->
            andWhere(["product_meta.value" => "info"])->
            with('productMeta')->
            asArray()->
            all();
        foreach ($infoCurs as &$item) {
            $item['productMeta'] = ArrayHelper::map($item['productMeta'], 'meta', 'value');
        }
        // debug($infoCurs);
        $provider = new ArrayDataProvider([
            'allModels' => $infoCurs,
            'pagination' => [
                'pageSize' => 10,
            ],
            // 'sort' => [
            //     'defaultOrder' => [
            //         'created_at' => SORT_DESC,
            //         'title' => SORT_ASC, 
            //     ]
            // ],
        ]);

        return $this->render('set-layot', [
            'view' => 'infocurs',
            'model' => $model,
            'provider' => $provider
        ]);
    }

    public function actionPartners($id)
    {
        $model = $this->findModel($id);
        $provider = new ArrayDataProvider([
            'allModels' => $model->promoUser,
            'pagination' => [
                'pageSize' => 10,
            ],
            // 'sort' => [
            //     'defaultOrder' => [
            //         'created_at' => SORT_DESC,
            //         'title' => SORT_ASC, 
            //     ]
            // ],
        ]);
        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $data;
            debug($data);
        }
        $this->title = 'промокоды';
        return $this->render('set-layot', [
            'view' => 'partners',
            'model' => $model,
            'provider' => $provider
        ]);
    }

    public function actionUpdatePartners($id)
    {
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = PromoUser::findOne($id);
            $model->name = $data['PromoUser']['name'];
            $model->save();
            return [
                'forceReload' => '#set-pajax-table',
                'title' => "Изменить промокод #" . $id,
                'content' => $this->renderAjax('update-partners', [
                    'model' => $model
                ]),

                'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal", "data-bs-dismiss" => "modal"]) .
                    Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Изменить промокод #" . $id,
                'content' => $this->renderAjax('update-partners', [
                    'model' => PromoUser::findOne($id)
                ]),
                'footer' => Html::button('Закрыть', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal", "data-bs-dismiss" => "modal"]) .
                    Html::button('Сохранить', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        }
    }

    public function actionUserTasks($id)
    {

        $model = $this->findModel($id);

        $sort = new Sort([
            'attributes' => [
                'date' => [
                    'asc' => ['date' => SORT_ASC],
                    'desc' => ['date' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Дата',
                ],
                // or any other attribute
            ],
            'defaultOrder' => [
                'date' => SORT_DESC
            ]
        ]);


        $provider = new ArrayDataProvider([
            'allModels' => $model->userTasks,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => $sort
            // 'sort' => [
            //     'defaultOrder' => [
            //         'created_at' => SORT_DESC,
            //         'title' => SORT_ASC, 
            //     ]
            // ],
        ]);
        // if(Yii::$app->request->isPost){
        //     debug(Yii::$app->request->post());
        // }

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $data;
        }
        return $this->render('set-layot', [
            'view' => 'user-tasks',
            'model' => $model,
            'provider' => $provider
        ]);
    }

    public function actionUpdateTasksStatus($id)
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = UserTasks::findOne($id);
            $task = Tasks::find()->where(['id' => $model->tasks_id])->one();
            $user = User::findOne($model->user_id);
            if ($data['UserTasks'][$data['editableKey']]['status'] == 2) {
                MailMessage::NewMessage($model->lang, 10, $user->username, ['name' => Yii::$app->user->identity->username, 'task-name' => $task->name]);
            } else if ($data['UserTasks'][$data['editableKey']]['status'] == 1) {
                MailMessage::NewMessage($model->lang, 11, $user->username, [
                    'name' => Yii::$app->user->identity->username,
                    'username' => Yii::$app->user->identity->username,
                    'task-name' => $task->name,
                    'task-link' => 'https://anticandida.com/' . $model->lang . '/user/bonus'
                ]);
            }
            $model->status = $data['UserTasks'][$data['editableKey']]['status'];
            if ($model->save()) {
                return true;
            }
        }
    }

    public function actionUpdateBalanseStatus($id, $user_id)
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = UserBalance::findOne($id);
            $user = User::find()->where(['id' => $user_id])->one();
            $model->status = $data['UserBalance'][$data['editableKey']]['status'];
            if ($model->save()) {
                if($data['UserBalance'][$data['editableKey']]['status'] == 1){
                    MailMessage::NewMessage($user->lang, 16, $user->username, [
                        'name' => $user->username,
                        'username' => $user->username,
                    ]);
                    MailMessage::BalanseSuccess($user->id);
                }else if($data['UserBalance'][$data['editableKey']]['status'] == 2){
                    MailMessage::NewMessage($user->lang, 17, $user->username, [
                    'name' => $user->username,
                    'username' => $user->username,
                ]);
                }

                return true;
            }
        }
    }



    public function actionUpdateRequestStatus($id)
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = UserRequest::findOne($id);
            $model->status = $data['UserRequest'][$data['editableKey']]['status'];
            if ($model->save()) {
                return true;
            }
            //$model = UserTasks::findOne($id);
            //$model->status = $data['UserTasks'][$data['editableKey']]['status'];
            // if ($model->save()) {
            //     return true;
            // }
        }
    }




    public function actionUserRequest($id)
    {
        $model = $this->findModel($id);

        $sort = new Sort([
            'attributes' => [
                'date' => [
                    'asc' => ['date' => SORT_ASC],
                    'desc' => ['date' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Дата',
                ],
                // or any other attribute
            ],
            'defaultOrder' => [
                'date' => SORT_DESC
            ]
        ]);

        $provider = new ArrayDataProvider([
            'allModels' => $model->userRequest,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => $sort
        ]);
        return $this->render('set-layot', [
            'view' => 'user-request',
            'model' => $model,
            'provider' => $provider
        ]);
    }

    public function actionUpdateLavel()
    {
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();

            $model = $this->findModel($data['userId']);
            $lavel = $model->userLavel;
            if ($lavel->lavel_id > $data['id']) {
                $user = User::findOne($data['userId']);
                MailMessage::NewMessage($user->lang, 14, $user->username, [
                    'name' => $user->username,
                    'username' => $user->username,
                    'partner-link' => 'https://anticandida.com/' . $user->lang . '/user/affiliate-program',
                    'password' => $user->password
                ]);
            } else if ($lavel->lavel_id < $data['id']) {
                $user = User::findOne($data['userId']);
                MailMessage::NewMessage($user->lang, 13, $user->username, [
                    'name' => $user->username,
                    'username' => $user->username,
                    'password' => $user->password,
                    'partner-link' => 'https://anticandida.com/' . $user->lang . '/user/affiliate-program'
                ]);
            }
            $lavel->lavel_id = $data['id'];




            if ($lavel->save()) {
                return true;
            } else {
                return false;
            }
            ;
        }
    }

    /**
     * Deletes an existing User model.
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

    public function actionDeleteRequest()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (UserRequest::find()->where(['id' => $data['id']])->exists()) {
                $model = UserRequest::findOne($data['id']);
                if ($model->delete()) {
                    return true;
                }
                ;
            }
            //Yii::$app->response->format = Response::FORMAT_JSON;
            return false;
            //return '123';
        }

        //return $this->refresh();
    }


    //removeRivers

    public function actionDeleteRivers()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (Reviews::find()->where(['id' => $data['id']])->exists()) {
                $model = Reviews::findOne($data['id']);
                if ($model->delete()) {
                    return true;
                }
                ;
            }
            return false;
        }
    }


    public function actionUpdateRiwersStatus($id)
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (Reviews::find()->where(['id' => $id])->exists()) {
                $model = Reviews::findOne($id);
                $model->status = $data['Reviews'][$data['editableKey']]['status'];
                if ($model->save()) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return 'ok';
                }
            }
        }
    }


    public function actionDeleteUserTasks()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (UserTasks::find()->where(['id' => $data['id']])->exists()) {
                $model = UserTasks::findOne($data['id']);
                if (!empty($model->file)) {
                    $arrayFile = unserialize($model->file);
                    foreach ($arrayFile as $key => $value) {
                        if (file_exists(Yii::getAlias('@webroot/uploads/') . $value)) {
                            unlink(Yii::getAlias('@webroot/uploads/') . $value);
                        }
                    }
                }
                if ($model->delete()) {
                    return true;
                }
            }
            return false;
        }
    }

    public function actionUserRivers($id)
    {
        $sort = new Sort([
            'attributes' => [
                'date' => [
                    'asc' => ['date' => SORT_ASC],
                    'desc' => ['date' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Дата',
                ],
                // or any other attribute
            ],
            'defaultOrder' => [
                'date' => SORT_DESC
            ]
        ]);

        $model = $this->findModel($id);
        $provider = new ArrayDataProvider([
            'allModels' => $model->userRivers,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => $sort
        ]);
        return $this->render('set-layot', [
            'view' => 'user-rivers',
            'model' => $model,
            'provider' => $provider
        ]);
    }
    public function actionOpenUserInfo($id, $user_id)
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (AccessInfoProduct::find()->where(['user_id' => $user_id])->andWhere(['product_id' => $id])->exists()) {
                $sta = AccessInfoProduct::find()->where(['user_id' => $user_id])->andWhere(['product_id' => $id])->one();
                if ($sta->delete()) {
                    return true;
                }
            } else {
                $sta = new AccessInfoProduct([
                    'user_id' => $user_id,
                    'product_id' => $id,
                ]);
                if ($sta->save()) {
                    return true;
                } else {
                    var_dump($sta->getErrors());
                }

            }

        }
        //return true;
    }

    public function actionMessageUserInfo($id, $user_id)
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $user = User::find()->where(['id' => $user_id])->one();
            $username = $user->email;
            $email = $user->email;
            $lang = $data['type'];
            $product = Product::findOne($id);
            MailMessage::OpenInfo($lang, $email, $attr = [
                'name' => $user->email,
                'username' => $user->email,
                'password' => $user->password,
                'infoproduct-name' => $product->getParam('productName', $lang),
                'infoproduct-link' => 'https://anticandida.com/' . $lang . '/user/info-product/' . $product->getParam('link', $lang)
            ]);
            return true;
        }
    }
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
