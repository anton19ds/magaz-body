<?php
use app\models\Cart;
use app\models\Delivery;
use app\models\Insurance;
use app\models\Promocod;

?>
<div class="data-card-order-data">
    <ul>
        <?php if (isset($cart['promocode'])): ?>
            <li><span>Товар</span><span>
                    <?= number_format($cart['totalData']['salePrice'], 0, '', ' ') ?> <?= Yii::t('app', '[currency-symbol]'); ?>
                </span></li>
        <?php endif; ?>
        <?php if (isset($cart['delivery']) && !empty($cart['delivery']) && isset($cart['delivery_summ']) && !empty($cart['delivery_summ'])): ?>
            <li>
                <span>
                    Доставка
                </span>
                <span>
                    <?= number_format(Delivery::getInstance()->getDelSumm($cart['delivery'], $currensy), 0, '', ' ') ?>
                    <?= Yii::t('app', '[currency-symbol]'); ?>
                </span>
            </li>
        <?php endif; ?>
        <?php if (isset($cart['insurance']) && $cart['insurance']): ?>
            <li>
                <span class="in-promo">
                    <?= Yii::t('app', '[insurance-txt]') ?>:
                </span>
                <span>
                    <?= number_format(Insurance::getInstance()->getSumm($currensy), 0, '', ' ') ?>
                    <?= Yii::t('app', '[currency-symbol]') ?>
                </span>
            </li>
        <?php endif; ?>
        <?php if (!empty($cart['promocode'])): ?>
            <li>
                <span class="in-promo">Скидка по промокоду “
                    <?= $cart['promocode'] ?>”:
                </span><span>
                    <?= number_format($cart['totalData']['saleSizePrice'], 0, '', ' ') ?>
                    <?= Yii::t('app', '[currency-symbol]'); ?>
                </span>
            </li>
        <?php endif; ?>
        <?php if (!empty($cart['coupon'])): ?>
            <li>
                <span class="in-promo">
                    <?= Yii::t('app', '[coupon-txt]') ?> “
                    <?= $cart['coupon'] ?>”:
                </span><span>
                <?= Promocod::getSize($cart, $currensy)?>
                    <?= Yii::t('app', '[currency-symbol]'); ?>
                </span>
            </li>
        <?php endif; ?>
        <li class="final">
            <span>
                <?= Yii::t('app', '[total]') ?>:
            </span>
            <span>
                <?php $summData = Cart::getInstance()->getOurSummCart($currensy);
                if (isset($cart['delivery']) && isset($cart['delivery_summ']) && !empty($cart['delivery_summ'])) {
                    $summData = $summData + Delivery::getInstance()->getDelSumm($cart['delivery'], $currensy);
                }
                ?>
                <?= number_format($summData, 0, '', ' '); ?>
                <?= Yii::t('app', '[currency-symbol]'); ?>
            </span>
        </li>
    </ul>
</div>