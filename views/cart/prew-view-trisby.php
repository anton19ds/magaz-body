<?php
use app\models\Cart;
use app\models\Currencies;
use app\models\Product;
use app\models\SettingData;
?>
<div class="pay-success-bg">
    <div class="block-data">
        <div class="title-set">
            <?= Yii::t('app', 'pyment-page-block-title') ?>
        </div>
        <div class="block-text">
            <div class="lb-s" style="
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
    height: auto;
">
                <p style="margin-bottom:2px">Po <span class="seconds-block">3</span> sekundách budete přesměrováni na platební stránku.</p>
                <p>Pokud se tak nestane, klikněte na tlačítko "Zaplatit".</p>
                <?php $sumPay = Cart::totalSumm(
                            ['data' => $orderList],
                            $product,
                            $currency,
                            $order->ordersMeta->coupon_name,
                            $order->ordersMeta->promocode,
                            $order->ordersMeta->shiping_type,
                            true,
                            $order->id,
                            $order->ordersMeta->userAdress->postcode
                );
                if($currency == 'ru'){
                    $dataSetF = Currencies::find()->where(['tag'=> 'cs'])->asArray()->one();
                    $sumPay = $sumPay * $dataSetF['code'];
                }else if($currency == 'en'){
                    $dataSetFCs = Currencies::find()->where(['tag'=> 'cs'])->asArray()->one();
                    $dataSetFEn = Currencies::find()->where(['tag'=> 'en'])->asArray()->one();
                    $sumPay = round($sumPay / $dataSetFEn['code'] * $dataSetFCs['code']);
                }
                ?>
                <a class="result_pay_info__email" href="https://pay.trisbee.com/bodybalanceclinic/<?= $sumPay?>" target="_blank">
                    <?= Yii::t('app', 'pay');?>
                </a>
            </div>
            <div class="rt-s">
                <h2>
                    <?= Yii::t('app', 'order') ?> №
                    <?= $order->id ?>
                    <?= Yii::t('app', 'from') ?>
                    <?= date('d.m.Y', $order->date) ?>
                </h2>
                <?= Yii::t('app', 'statys') ?>: “
                <?= Yii::t('app', 'status-new') ?>”
                <?php //= $viewData; ?>
                <ul class="prod-list">
                    <li>
                        <span>
                            <?= Yii::t('app', 'product-tt') ?>:
                        </span>
                        <span><?php if (!empty($order->ordersMeta->promocode)): ?><?= Yii::t('app', 'sale')?>: <?php endif; ?></span>
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
                                    -<?= $order->productDiscountPromoCode($type, $price) ?>
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
                        <?php if($currency == 'ru' || $currency == 'en'):?>
                            (<?= $sumPay?> Kč)
                        <?php endif;?>
                    </li>
                </ul>
                <h3>
                    <?= Yii::t('app', 'placeholder-adress-delivey') ?>:
                </h3>
                <p class="card-adress-data">
                    <span><?= $order->ordersMeta->userAdress->postcode ?>,
                        <?= $order->ordersMeta->userAdress->country ?>,
                        <?= $order->ordersMeta->userAdress->area ?>,
                    </span>
                    <span>
                        <?= $order->ordersMeta->userAdress->city ?>,
                        <?= $order->ordersMeta->userAdress->flat ?>,
                        <?= $order->ordersMeta->userAdress->street ?>
                    </span>
                </p>
                <?= $order->user->phone; ?><br>
                <?= $order->user->email; ?>
            </div>
        </div>
        <div class="em-bl">
            <a href="">info@body-balance.com</a>
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