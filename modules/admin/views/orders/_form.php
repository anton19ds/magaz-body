<?php

use app\models\Cart;
use app\models\OrdersMeta;
use app\models\OrderStatus;
use app\models\Product;
use app\models\UserAdress;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="orders-form">
    <div class="row">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-header">
                    <div class="card-title">Параметры заказа от <?= date("Y-m-d H:s", $model->date); ?></div>
                    <div class="set-block">

                        <?= Html::dropDownList('status', $model->getStatus(), OrderStatus::getLabelStatus(), ['data-id' => $model->id, 'class' => 'selected-status form-control ' . $model->getStatus()]) ?>
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>

                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'del_track')->textInput() ?>
                </div>
                <div class="card-body">


                    <?php foreach ($product as $item): ?>
                        <?php $priceData = Product::getPriceProductbyId($item->id, $model->cyrrency);
                        $name = $item->getParam('shortName', $model->cyrrency); ?>
                        <div>
                            <p class="order_line__goodname"><?= $name ?> × <?= $dataOrder[$item->id]['count'] ?> - 
                            <?php
                                $prodPrice = (isset($priceData['summ']) && !empty($priceData['summ']) ? $priceData['summ'] : $priceData['price']);
                                $presProde = (int) $prodPrice * (int) $dataOrder[$item->id]['count'];
                                echo number_format($presProde, 0, '', ' ') ?>
                                <?= $icon ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                    <p>Сумма доставки: <?= $model->meta->shiping_summ?> <?= $icon ?></p>
                    <p><strong>Итого: </strong><?php echo number_format($model->getOrderSumm($model->cyrrency), 0, '', ' ')?> <?= $icon ?></p>
                    <hr>
                    <label for="">
                        Заказчик:
                    </label>
                    <p>
                        <?php echo $model->meta->userAdress->surname ?>
                        <?php echo $model->meta->userAdress->name ?>
                        <?php echo $model->meta->userAdress->lastname ?>
                        <br>
                        <a href="/admin/user/update?id=<?= $model->user->id?>"><?= (isset($model->user->email) ? $model->user->email : ''); ?></a>
                        <br>
                        <?= (isset($model->user->phone) ? $model->user->phone : ''); ?>
                    </p>
                    <hr>

                    <?= OrdersMeta::getLabelPayDesc()[$model->meta->payment_type] ?>
                    <br>
                    <?= OrdersMeta::getLabelStatus()[$model->meta->shiping_type]; ?>
                    
                    <?= $model->meta->promocode; ?>
                    <hr>
                    <?php
                    $adress = UserAdress::findOne($model->meta->adress_shipig);
                    ?>
                    <label for="">
                        Адрес:
                    </label>
                    <p>
                        <?= $adress->postcode; ?> <?= $adress->country; ?> <?= $adress->city; ?> <?= $adress->area; ?>
                        <?= $adress->flat; ?> <?= $adress->street; ?>
                    </p>
                    <textarea name="comment_for_user" id="comment_for_user" placeholder="Коментарий к заказу"
                        class="form-control"></textarea>
                    <br>
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
                    <br>
                    <br>
                    <br>
                    <?php if ($dataProvider): ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                'id',
                                'text',
                                'date'
                                // [
                                //     'attribute' => 'Статус',
                                //     'format' => 'raw',
                                //     'value' => function ($model) {
                    
                                //             return $this->render('selectStatus', [
                                //                 'model' => $model
                                //             ]);
                                //         }
                                // ],
                            ],
                        ]); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
<style>
    .card-header {
        display: flex;
        align-items: center;
    }

    .set-block {
        display: flex;
        margin-left: 50px;
        width: 100%;
    }

    .selected-status.form-control {
        width: 100%;
        margin-right: 20px;
    }

    .card-title {
        white-space: nowrap;
    }
</style>