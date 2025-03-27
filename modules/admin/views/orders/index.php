<?php

use app\models\Cart;
use app\models\Currencies;
use app\models\Orders;
use app\models\OrdersMeta;
use app\models\OrderStatus;
use app\models\UserAdress;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sort-block">
    <?php echo $this->render('sort-block') ?>
</div>

<style>
    .app-block {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .list-filter0type li {
        border-right: 1px solid;
        padding: 0 10px;
    }

    .list-filter0type li:first-child {
        padding-left: 0;
        /* font-weight: 600; */
    }

    .list-filter0type li:last-child {
        border-right: 0px solid;
    }
    .list-filter0type li.active{
        font-weight: 600;
    }
    .sderty{
        display: flex;
        align-items: center;
    }
    .sderty input{
        margin-right: 8px;
    }
    
</style>
<ul class="list-filter0type" style="display: flex; list-style-type: none; padding: 0; margin: 20px 0 10px 0;">

    <?php
    
    foreach ($status as $elem => $key): ?>
    
        <?php
        $link = '/admin';
        $active = 'no-active';
        if ($elem == 'Архив') {
            if($sort == 'arcive' ){
                $active = 'active';
            }
            $link = '?sort=arcive';

        }else if($elem == 'Ожидает оплаты'){
            if($sort == 'nopay' ){
                $active = 'active';
            }
            $link = '?sort=nopay';
        }else if($elem == 'Обрабатывается'){
            if($sort == 'pay' ){
                $active = 'active';
            }
            $link = '?sort=pay';
        }else if($elem == 'Завершен'){
            if($sort == 'close' ){
                $active = 'active';
            }
            $link = '?sort=close';
        }else if($elem == 'Отменен'){
            if($sort == 'failed' ){
                $active = 'active';
            }
            $link = '?sort=failed';
        }else if($elem == 'Возврат'){
            if($sort == 'return' ){
                $active = 'active';
            }
            $link = '?sort=return';
        }

        
        ?>
        <li class="<?= $active?>"><span><a style="text-decoration: none; color: inherit;" href="<?= $link ?>"><?= $elem ?></span>
            <?= ($key != 0 ? "(" . $key . ")" : '') ?></a></li>
    <?php endforeach; ?>
</ul>
<?php if($sort == 'arcive' ):?>
    <a href="#" id="insendOrderInArch" class="btn btn-warning mb-3">Из архива</a>
    <?php else:?>
    <a href="#" id="sendOrderInArch" class="btn btn-warning mb-3">В архив</a>
<?php endif;?>

<div class="orders-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "<div class='app-block'>{summary}{pager}</div>\n{items}\n{pager}",
        'summary' => ' ',
        'columns' => [
            [
                'attribute' => 'Заказ',
                'format' => 'raw',
                'value' => function ($model) {
                if (isset($model->user)) {


                    $meta = $model->Metas();
                    if ($meta) {
                        $ship = UserAdress::find()->where(['id' => $meta['adress_shipig']])->asArray()->one();
                        $ship_adress = '';
                        if ($ship) {
                            $ship_adress = $ship['name'] . " " . $ship['surname'];
                        }
                        return '<div class="sderty"><input type="checkbox" class="active_status" id="id' . $model->id . '" data-id="' . $model->id . '"><a href="/admin/orders/update?id=' . $model->id . '" style="white-space: nowrap;font-size: 13px;text-decoration: none;"> #' . $model->id . ' <span>' . $ship_adress . '</span>' . '</a></div>';
                    }
                } else {
                    return '';
                }

            }
            ],
            [
                'attribute' => 'Дата',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width:150px'],
                'value' => function ($model) {
                return '<span style="white-space: nowrap;font-size: 13px;">' . date('d M Y', $model->date) . ' (' . date('H:s', $model->date) . ')</span>';
            }
            ],
            [
                'attribute' => 'Статус',
                'format' => 'raw',
                'value' => function ($model) {
                return $this->render('selectStatus', [
                    'model' => $model
                ]);
            }
            ],
            [
                'attribute' => 'Доставка',
                'format' => 'raw',
                'value' => function ($model) {
                $meta = $model->Metas();
                if ($meta) {
                    //debug($meta['adress_shipig']);
                    $ship = UserAdress::find()->where(['id' => $meta['adress_shipig']])->asArray()->one();
                    $ship_adress = '';
                    if ($ship) {
                        $ship_adress = $ship['postcode'] . ", " . $ship['country'] . ", " . $ship['area'] . ", " . $ship['city'] . ", " . $ship['street'] . ", " . $ship['flat'] . ", " . $ship['surname'] . " " . $ship['name'] . " " . $ship['lastname'] . " (" . (isset($model->user->phone) ? $model->user->phone : '') . ")";
                    }
                    return '<span style="font-size:12px;max-width: 273px;display: block;">' . $ship_adress . '<br><b>' . Cart::getLabelType()[$meta['shiping_type']] . '</b></span>';
                }
            }
            ],
            [
                'attribute' => 'Итого',
                'format' => 'raw',
                'value' => function ($model) {
                $meta = $model->Metas();
                try{
                    return '<span style="font-size:12px">' . number_format($model->getOrderSumm(), 0, '', ' ') . ' ' . Currencies::getIcon($model->cyrrency) . '<br>' . OrdersMeta::getLabelPayDesc()[$meta['payment_type']] . '</span>';
                }catch(Exception $e){

                }
                
            }
            ],
            [
                'attribute' => 'Промокод',
                'value' => function ($model) {
                try {
                    return $model->ordersMeta->promoUser->name;
                } catch (Exception $e) {
                    return null;
                }

            }
            ],
            [
                'label' => 'Трек-номер',
                'format' => 'raw',
                'value' => function ($model) {
                return "<input value='{$model->del_track}' type='text' data-id='{$model->id}' class='trak-update'>";
            }
            ]
        ],
    ]); ?>
</div>

<style>
    .list-tovar-order {
        padding: 0;
        margin: 0;
        list-style-type: none;
    }

    .list-tovar-order li {
        margin-bottom: 10px;

    }
</style>

<?php $this->registerJs('
$(".trak-update").on("change", function(e){
    var id = $(this).data("id");
    var val = $(this).val();
    var obj = $(this);
    $.post("/admin/orders/trak-update", {id: id, val: val}, function Success(data){
      if(data){
        obj.css("border", "1px solid #51e751");
      }else{
        obj.css("border", "1px solid red");
      }
    });
  })

$("#sendOrderInArch").on("click", function(e){
e.preventDefault();
var obj = [];
$(".active_status").each(function(e){
if($(this).prop("checked")){
obj.push($(this).data("id"));
}
})
$.post("/admin/orders/in-archive", {obj:obj}, function Success(data){
    document.location = document.location;
})
})

$("#insendOrderInArch").on("click", function(e){
e.preventDefault();
var obj = [];
$(".active_status").each(function(e){
if($(this).prop("checked")){
obj.push($(this).data("id"));
}
})
$.post("/admin/orders/out-archive", {obj:obj}, function Success(data){
    document.location = document.location;
})
})



') ?>