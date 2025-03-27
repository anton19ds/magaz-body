<?php
use app\models\Cart;
use app\models\Delivery;
use app\models\Insurance;
use app\models\Promocod;
use app\models\SettingData;
use app\widgets\ApsellView;
use yii\widgets\Pjax;

?>
<?= $this->render('../layouts/header-banner')?>
<main id="CartIndexPage">
    <div class="container_ordering">
        <div class="ordering__main">
            <div class="ordering_main__img">
            <?php $logo = SettingData::getValue('logo');
                    $array = json_decode($logo, true);
                    ?>
                    <img src="<?= $array['array'][1]['value']?>" alt="" />
            </div>
            <div class="ordering_main__steps">
                <span class="active"><a href="/<?= $currensy ?>/cart">
                        <?= Yii::t('app', 'cart-txt') ?>
                    </a></span>
                <span><a href="/<?= $currensy ?>/order">
                        <?= Yii::t('app', 'contact-information') ?>
                    </a></span>
                <span><a href="/<?= $currensy ?>/delivery">
                        <?= Yii::t('app', 'delivery-method') ?>
                    </a></span>
                <span><a href="/<?= $currensy ?>/payment">
                        <?= Yii::t('app', 'payment-method') ?>
                    </a></span>
            </div>
            <?php Pjax::begin([
                'id' => 'pjax-cart'
            ]); ?>
            <div class="products_in_cart">
                <h5>Корзина с вашим заказом</h5>
                <?= $this->render('view-in-cart', [
                    'cart' => $cart,
                    'currensy' => $currensy,
                    'product' => $product
                ]) ?>
            </div>
            <div class="cart_finish">
                <div class="cart_finish__promocodes">
                    <div class="set_data" style="flex-direction: column;">
                        <div class="block-ert" style="display: flex; width: 100%;">
                            <label for="coupon_sale"
                                style="<?= (isset($cart['coupon']) && !empty($cart['coupon']) ? 'top: 9px; font-size: 11px;' : '') ?>">
                                <?= Yii::t('app', 'placeholder-coupon') ?>
                            </label>
                            <input type="text" name="coupon_sale" id="field-coupon"
                                value="<?= (isset($cart['coupon']) ? $cart['coupon'] : '') ?>"
                                class="<?= (isset($cart['coupon']) && !empty($cart['coupon']) ? 'input-active' : '') ?>">

                            <?php if (isset($cart['coupon']) && !empty($cart['coupon'])): ?>
                                <input type="submit" value="<?= Yii::t('app', 'btn-apply-set') ?>" id="add-coupon"
                                    class="active-btn">
                            <?php else: ?>
                                <input type="submit" value="<?= Yii::t('app', 'apply') ?>" id="add-coupon">
                            <?php endif; ?>
                        </div>
                        <p class="error_cart_promocode">
                            <?= Yii::t('app', 'cypon-error') ?>
                        </p>
                    </div>
                    <div class="set_data" style="flex-direction: column;">
                        <div class="block-ert" style="display: flex; width: 100%;">
                            <label for="coupon_promocode"
                                style="<?= (isset($cart['promocode']) && !empty($cart['promocode']) ? 'top: 9px; font-size: 11px;' : '') ?>">
                                <?= Yii::t('app', 'placeholder-promocode') ?>
                            </label>
                            <input type="text" name="coupon_promocode" id="coupon_promocode"
                                value="<?= (isset($cart['promocode']) ? $cart['promocode'] : '') ?>"
                                class="promocode_partner <?= (isset($cart['promocode']) && !empty($cart['promocode']) ? 'input-active' : '') ?>"
                                <?= (isset($cart['promocode']) && !empty($cart['promocode']) ? 'disabled' : '') ?>>

                            <?php if (isset($cart['promocode']) && !empty($cart['promocode'])): ?>
                                <input type="submit" value="<?= Yii::t('app', 'btn-apply-set') ?>"
                                    class="send-promocod active-btn">
                            <?php else: ?>
                                <input type="submit" value="<?= Yii::t('app', 'apply') ?>" class="send-promocod">
                            <?php endif; ?>




                        </div>
                        <p class="error_cart_promocode">
                            <?= Yii::t('app', 'promocode-error') ?>
                        </p>
                    </div>
                </div>
                <div class="cart_finish__confirms">
                    <div>
                        <img src="/frontStyle/assets/images/checkbox-no-click.svg" alt="">
                        <p>
                            <?= Yii::t('app', 'condition-block-a') ?>
                        </p>
                    </div>
                    <div>
                        <img src="/frontStyle/assets/images/checkbox-no-click.svg" alt="">
                        <p>
                            <?= Yii::t('app', 'condition-block-b') ?>
                        </p>
                    </div>
                    <div>
                        <p>
                            <?= Yii::t('app', 'condition-block-c') ?>
                        </p>
                    </div>
                </div>
                <div class="cart_finish__total-summ">
                    <p>
                        <span>
                            <?= Yii::t('app', 'product-tt') ?>:
                        </span>
                        <span>
                            <?= Cart::totalSummProduct($cart, $product, $currensy) ?>
                        </span>
                    </p>
                    <?php if (isset($cart['promocode'])): ?>
                        <p class="cart_finish__total-discount">
                            <span>
                                <?= Yii::t('app', 'discount-using-promo-code') ?> "<?= $cart['promocode'] ?>":
                            </span>
                            <span>
                                <?php echo Cart::PromocodeSizeSale($cart, $product, $currensy) ?>
                            </span>
                        </p>
                    <?php endif; ?>

                    <?php if (Promocod::getSize($cart, $currensy)): ?>
                        <p class="cart_finish__total-discount">
                            <span>
                                <?= Yii::t('app', 'coupon-txt') ?> "<?= Promocod::getName($cart, $currensy)?>":
                            </span>
                            <span>
                                <?php
                                $strSearch = Promocod::getSize($cart, $currensy);
                                if(str_contains($strSearch, '%')){
                                    echo Promocod::getSize($cart, $currensy);
                                }else{
                                    number_format(Promocod::getSize($cart, $currensy), 0, '', ' ');
                                    Yii::t('app', 'currency-symbol');
                                }?>
                            </span>
                        </p>
                    <?php endif; ?>

                    <?php if (isset($cart['insurance']) && !empty($cart['insurance']) && $cart['insurance'] == 1): ?>
                        <p class="cart_finish__total-discount">
                            <span>
                                <?= Yii::t('app', 'insurance-txt') ?> :
                            </span>
                            <span>
                                <?php echo number_format(Insurance::getInstance()->getSumm($currensy, $product), 0, '', ' ') ?>
                                <?= Yii::t('app', 'currency-symbol') ?>
                            </span>
                        </p>
                    <?php endif; ?>
                    <?php if (isset($cart['delivery']) && !empty($cart['delivery']) && isset($cart['delivery_summ']) && !empty($cart['delivery_summ'])): ?>
                        <p class="cart_finish__total-discount">
                            <span>
                                <?= Yii::t('app', 'delivery-txt') ?>:
                            </span>
                            <span>
                                <?= number_format(Delivery::getInstance()->getDelSumm($cart['delivery'], $currensy), 0, '', ' ') ?>
                                <?= Yii::t('app', 'currency-symbol'); ?>
                            </span>
                        </p>
                    <?php else:?>
                        <p class="cart_finish__total-discount">
                            <span>
                                <?= Yii::t('app', 'delivery-txt') ?>:
                            </span>
                            <span>
                                0 <?= Yii::t('app', 'currency-symbol'); ?>
                            </span>
                        </p>
                    <?php endif; ?>
                    <p>
                        <span>
                            <?= Yii::t('app', 'total') ?>:
                        </span>
                        <span>
                            <?= Cart::totalSumm($cart, $product, $currensy) ?>
                        </span>
                    </p>
                </div>
                <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $currensy ?>/shop/order" class="ordering_new_step" data-lang="<?= $currensy ?>" data-link="order" id="NextStepOrder" data-pjax = 0>
                    <?= Yii::t('app', 'next-btn') ?>
                </a>
            </div>
            <?php Pjax::end(); ?>
        </div>
        <?= ApsellView::widget(['title' => Yii::t('app', 'best-user-product'), 'lang' => $currensy, 'cart' => $cart]) ?>
    </div>
</main>
<script>
    window.addEventListener('load', function () {
        parent.postMessage({
            he : document.documentElement.scrollHeight,
            path: document.location.pathname,
        }, '*');
    });
</script>
<?php $this->registerJs('
$(document).on("click","#NextStepOrder", function(e){
    e.preventDefault();
    var lang = $(this).data("lang");
    var link = $(this).data("link");
    parent.postMessage({
        lang : lang,
        link: link,
    }, "*");
})
')?>