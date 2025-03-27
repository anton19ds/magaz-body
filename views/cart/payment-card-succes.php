<?php use app\models\Cart;
use app\models\Insurance;
use app\models\Product; ?>
<script>
    window.addEventListener('load', function () {
        varHe = document.getElementById('topBody');
        parent.postMessage({
            he : varHe.scrollHeight,
            path: document.location.pathname,
            lang: "<?= $currency?>",
            link: "payment-card-succes?orderId=<?= $orderUiid;?>"
        }, '*');
    })
</script>
<?= $this->render('../layouts/header-banner') ?>
<div class="pay-success-bg">
    <div class="block-data">
        <div class="title-set">
            <?= Yii::t('app', 'pyment-page-block-title') ?>
        </div>
        <div class="block-text">
            <div class="lb-s" id="card-sertyu">

                <h1>
                    <?= Yii::t('app', 'title-card-success') ?>
                </h1>

                <h3 style="margin-bottom: 3px;">
                    <?= Yii::t('app', 'pyment-page-block-1') ?>
                </h3>

                <h3 class="set-ps-g">
                    <?= Yii::t('app', 'desc-success-1') ?>
                </h3>

                <p style="margin-bottom: 15px;">
                    <?= Yii::t('app', 'card-data-ru') ?>
                </p>

                <h3 style="margin-bottom:0px">
                    <?= Yii::t('app', 'desc-success-3') ?>
                </h3>

                <?= Yii::t('app', 'card-data-en') ?>
                <br>
                <p style="margin-bottom: 0; margin-top: 10px;line-height:20px">
                    <?= Yii::t('app', 'desc-success-2') ?>
                </p>

            </div>
            <div class="rt-s">
                <h2>
                    <?= Yii::t('app', 'order') ?> №<?= $order->id ?> <?= Yii::t('app', 'from') ?>
                    <?= date('d.m.Y', $order->date) ?>
                </h2>
                <?= Yii::t('app', 'statys') ?>: “
                <?= Yii::t('app', 'status-new') ?>”
                <?php //= $viewData;  ?>
                <ul class="prod-list">
                    <li>
                        <span>
                            <?= Yii::t('app', 'product-tt') ?>:
                        </span>
                        <span><?php if (!empty($order->ordersMeta->promocode)): ?>Скидка:<?php endif; ?></span>
                    </li>
                    <?php foreach ($product as $item): ?>
                        <?php
                        $priceData = Product::getPriceProductbyId($item->id, $currency);
                        $type = $item->getParam('type', null);
                        $image = $item->getParam('image', null);
                        $link = $item->getParam('link', $currency);
                        $name = $item->getParam('shortName', $currency);
                        ?>
                        <li>
                            <span>
                                <?= $name ?> ×
                                <?= $orderList[$item->id]['count'] ?> -
                                <?php
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
                                ?>
                                <?= number_format($price, 0, '', ' ') ?>
                                <?= Yii::t('app', 'currency-symbol') ?>
                            </span>
                            <span>
                                <?php if (!empty($order->ordersMeta->promocode)): ?>
                                    - <?= $order->productDiscountPromoCode($type, $price) ?>
                                    <?= Yii::t('app', 'currency-symbol') ?>
                                <?php endif; ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="option-list">
                    <li>
                        <?= Yii::t('app', 'total-page-end') ?>:
                        <?= Cart::totalSumm(
                            ['data' => $orderList],
                            $product,
                            $currency,
                            $order->ordersMeta->coupon_name,
                            $order->ordersMeta->promocode,
                            $order->ordersMeta->shiping_type,
                            null,
                            $order->id,
                            $order->ordersMeta->userAdress->postcode
                        ) ?>
                    </li>
                </ul>
                <h3>
                    <?= Yii::t('app', 'placeholder-adress-delivey') ?>:
                </h3>
                <?= $order->ordersMeta->userAdress->surname; ?>
                <?= $order->ordersMeta->userAdress->name; ?>
                <?= $order->ordersMeta->userAdress->lastname; ?>
                <p class="card-adress-data">
                    <span><?= $order->ordersMeta->userAdress->postcode ?>,
                        <?= $order->ordersMeta->userAdress->country ?>,
                        <?= $order->ordersMeta->userAdress->area ?>,
                    </span>
                    <span>
                        <?= $order->ordersMeta->userAdress->city ?>,
                        <?= $order->ordersMeta->userAdress->street ?>,
                        <?= $order->ordersMeta->userAdress->flat ?>
                    </span>
                </p>
                <p style="margin-bottom: 0; line-height: 26px;">
                    <?= $order->user->phone; ?>
                    <br>
                    <?= $order->user->email; ?>
                </p>
            </div>
        </div>
        <div class="em-bl">
            <a href="<?= Yii::t('app', 'email') ?>">info@body-balance.com</a>
        </div>
        <div class="soc-chat">
            <a href="<?= Yii::t('app', "whatsapp") ?>" style="background-color: #34C456;" target="_blank"><img
                    src="/img/whatsapp.svg" alt=""></a>
            <a href="<?= Yii::t('app', "viber") ?>" style="background-color: #7B59E9;" target="_blank"><img
                    src="/img/Viber.svg" alt=""></a>
            <a href="<?= Yii::t('app', "telegram") ?>" style="background-color: #039BE5;" target="_blank"><img
                    src="/img/telegram.png" alt=""></a>
        </div>
    </div>
</div>
<style>
    .info-line,
    #criterion {
        display: none;
    }
</style>


