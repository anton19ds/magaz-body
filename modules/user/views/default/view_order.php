<?php
use app\models\Cart;
use app\models\OrdersMeta;
use app\models\OrderStatus;
use app\models\Product;
use yii\bootstrap5\Modal;

?>
<?php $cart = array(
    'data' => $dataOrder
); ?>
<div class="all_shadow"></div>
<div class="popup cancel_order_popup">
    <div class="close_popup close_popup_svg">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <g clip-path="url(#clip0_1158_108032)">
                <path
                    d="M11.1049 10L19.7712 1.33372C20.0763 1.0286 20.0763 0.533915 19.7712 0.228837C19.4661 -0.0762401 18.9714 -0.0762791 18.6663 0.228837L9.99999 8.89515L1.33372 0.228837C1.0286 -0.0762791 0.533915 -0.0762791 0.228837 0.228837C-0.0762401 0.533954 -0.0762792 1.02864 0.228837 1.33372L8.89511 9.99999L0.228837 18.6663C-0.0762792 18.9714 -0.0762792 19.4661 0.228837 19.7712C0.381376 19.9237 0.581337 20 0.781297 20C0.981258 20 1.18118 19.9237 1.33376 19.7712L9.99999 11.1049L18.6663 19.7712C18.8188 19.9237 19.0188 20 19.2187 20C19.4187 20 19.6186 19.9237 19.7712 19.7712C20.0763 19.4661 20.0763 18.9714 19.7712 18.6663L11.1049 10Z"
                    fill="black" />
            </g>
            <defs>
                <clipPath id="clip0_1158_108032">
                    <rect width="20" height="20" fill="white" />
                </clipPath>
            </defs>
        </svg>
    </div>
    <p class="title_popup">
        Отменить заказ?
    </p>
    <p class="description_popup">
        Вы действительно хотите отменить заказ №<?= $order['id'] ?>? Отменить это действие будет нельзя.
    </p>
    <div class="links_exit">
        <a href="#" class="sert-close" data-id="<?= $order['id'] ?>">Да</a>
        <a class="close_popup" href="#">Нет</a>
    </div>
</div>



<section id="history_orders">
    <div class="container">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'history'

        ]) ?>
        <div class="infoproducts__main">
            <h1><?= Yii::t('app', 'history-orders') ?></h1>
            <div class="main_order_information">
                <div class="content_order_information">
                    <h4><?= Yii::t('app', "information-about-order") ?></h4>
                    <div class="content_order__status-buttons">
                        <div class="content_order__status">
                            <p><?= Yii::t("app", 'order') ?> №<?= $order['id'] ?> <?= Yii::t('app', 'was-issued') ?>
                                <?= date('d.m.Y', $order['date']) ?>
                            </p>
                            <p class="info_track">
                                <?= Yii::t('app', 'statys') ?>:
                                <span >
                                    <?php if (OrderStatus::STATUS_NEW == $orderStatys->status): ?>
                                        <?= Yii::t('app', 'status-new') ?>
                                    <?php endif; ?>
                                    <?php if (OrderStatus::STATUS_PAY == $orderStatys->status): ?>
                                        <?= Yii::t('app', 'status-pay') ?>
                                    <?php endif; ?>
                                    <?php if (OrderStatus::STATUS_CLOSE == $orderStatys->status): ?>
                                        <?= Yii::t('app', 'status-end') ?>
                                    <?php endif; ?>
                                    <?php if (OrderStatus::STATUS_RETURN == $orderStatys->status): ?>
                                        <?= Yii::t('app', 'status-return') ?>
                                    <?php endif; ?>
                                    <?php if (OrderStatus::STATUS_FAILED == $orderStatys->status): ?>
                                        <?= Yii::t('app', 'status-close') ?>
                                    <?php endif; ?>
                                </span>
                            </p>
                            <?php if (OrderStatus::STATUS_PAY == $orderStatys->status || OrderStatus::STATUS_CLOSE == $orderStatys->status): ?>
                                <?php if($order['del_track']):?>
                                <p class="info_track">
                                    <?= Yii::t('app', 'track-number-of-the-shipment') ?>:
                                    <span class="delivery_number" data-link="<?= $order['del_track']?>" >
                                    <?= $order['del_track']?>
                                    </span>
                                    <span class="copy_icon copy_view_order">
                                        <img src="/asset/images/copy.svg" alt="">
                                        <span class="yes_copied"><?= Yii::t('app', 'copied') ?></span>
                                    </span>
                                </p>
                                <?php endif;?>
                            <?php endif; ?>
                        </div>

                        <div class="content_order__buttons">
                            <?php if (OrderStatus::STATUS_NEW == $orderStatys->status): ?>
                                <?php $urlPayment = '';
                                if ($orderMeta['payment_type'] == Cart::Inteleckt) {
                                    if ($order->paymentDataNewOreder()) {
                                        $urlPayment = "https://merchant.intellectmoney.ru/?InvoiceId=" . $order->paymentDataNewOreder()->paymentId;
                                    }
                                } else if ($orderMeta['payment_type'] == Cart::CARD) {
                                    $urlPayment = '/' . $lang . '/' . "payment-card-succes?orderId={$order->uuid}";
                                    ;
                                }
                                ?>
                                <?php if ($urlPayment): ?>
                                    <a class="orders_line__actions_pay" href="<?= $urlPayment; ?>"
                                        target="_blank"><?= Yii::t('app', 'pay') ?></a>
                                    <a class="orders_line__actions_pay close-order go_cancel_order"
                                        href="#"><?= Yii::t('app', 'close') ?></a>

                                <?php endif; ?>
                            <?php elseif (OrderStatus::STATUS_CLOSE == $orderStatys->status): ?>
                                <a href="https://gdeposylka.ru/" class="view_delivery" target="_blank"><?= Yii::t('app', 'track-your-order') ?></a>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="table_order">
                        <div class="table_order__line">
                            <div class="order_box__good-price">
                                <div>
                                    <p class="order_line__goodname"><?= Yii::t('app', 'product-tt') ?></p>
                                    <p class="order_line__price"><?= yii::t('app', 'price') ?></p>
                                </div>
                            </div>
                            <p class="order_line__sale"><?= Yii::t('app', 'sale') ?></p>
                            <p class="order_line__delivery"><?= Yii::t('app', "delivery-txt") ?></p>
                            <p class="order_line__methodpay"><?= Yii::t('app', 'payment-method') ?></p>
                            <p class="order_line__finishprice"><?= Yii::t('app', 'total') ?></p>
                        </div>
                        <div class="table_order__line real_table_order_line">
                            <div class="order_box__good-price">
                                <?php foreach ($product as $item): ?>
                                    <?php $priceData = Product::getPriceProductbyId($item->id, $order->cyrrency);
                                    $name = $item->getParam('shortName', $order['cyrrency']); ?>
                                    <div>
                                        <p class="order_line__goodname"><?= $name ?> × <?= $dataOrder[$item->id]['count'] ?>
                                        </p>
                                        <p class="order_line__price">

                                         <?php
                                         $prodPrice = (isset($priceData['summ']) && !empty($priceData['summ']) ? $priceData['summ'] : $priceData['price']);
                                         $presProde = (int)$prodPrice * (int)$dataOrder[$item->id]['count'];
                                         echo number_format($presProde, 0, '', ' ') ?>
                                            <?= $icon ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <p class="order_line__sale">
                                <?php if ($orderMeta['promocode']): ?>
                                    <?= Cart::PromocodeSizeSale($cart, $product, $order->cyrrency, $orderMeta['promocode'], null) ?>
                                <?php endif; ?>

                            </p>
                            <p class="order_line__delivery"><?= (!empty($dell) ? number_format($dell, 0, '', ' ') : 0) ?> <?= $icon ?>
                            </p>
                            <p class="order_line__methodpay">
                                <?php if ($orderMeta['payment_type'] == OrdersMeta::CARD): ?>
                                    <?= Yii::t('app', 'manual-translation'); ?>
                                <?php else: ?>
                                    <?= OrdersMeta::getLabelPayDesc()[$orderMeta['payment_type']] ?>
                                <?php endif; ?>


                            </p>
                            <p class="order_line__finishprice">

                                <?= Cart::totalSumm(
                                    $cart,
                                    $product,
                                    $order->cyrrency,
                                    $orderMeta['coupon'],
                                    $orderMeta['promocode'],
                                    $orderMeta['shiping_type'],
                                    null,
                                    $order->id,
                                    null
                                ) ?>

                            </p>
                        </div>
                    </div>
                    <p>
                        <a href="/<?= $lang ?>/user/order" class="return-order-list">
                            ← <?= Yii::t('app', 'return-1') ?>
                        </a>
                    </p>
                </div>
                <div class="delivery_addresses__list">
                    <h4><?= Yii::t('app', 'placeholder-adress-delivey') ?>:</h4>
                    <div class="delivery_address_item">
                        <p>
                        <span class="del_address__surname"><?= $user['secondName']; ?></span>
                            <span class="del_address__name"><?= $user['firstName']; ?> </span>
                            <span class="del_address__fname"><?= $user['LastName']; ?> </span>
                            
                        </p>
                        <p>
                            <span class="del_address__index"><?= $adress['postcode'] ?>,</span>
                            <span class="del_address__country"><?= $adress['country'] ?>,</span>
                            <span class="del_address__region"><?= $adress['area'] ?>,</span>
                            <span class="del_address__city"><?= $adress['city'] ?>,</span>
                            <span class="del_address__street"><?= $adress['street'] ?>,</span>
                            <span class="del_address__address"><?= $adress['flat'] ?></span>
                        </p>
                        <p>
                            <span class="del_address__phone"><?= $user['phone']; ?></span>
                        </p>
                        <p>
                            <span class="del_address__email"><?= $user['email']; ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var h2 = document.getElementById('pageSetBody').offsetHeight;
    parent.postMessage({
        heUserInfo: h2,
        top: true
    }, '*');
</script>





<?php $this->registerJs('
$(document).on("click", "a.return-order-list", function(e){
    e.preventDefault();
    var linkData = $(this).attr("href");
    parent.postMessage({
        linkData : linkData,
        path: document.location.pathname,
    }, "*");
})
')?>