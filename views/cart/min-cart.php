<?php

use app\models\Cart;
use app\models\Delivery;
use app\models\Insurance;
use app\models\Product;
use app\models\Promocod;
use app\widgets\Raite;
use yii\widgets\Pjax;

Pjax::begin([
    'id' => 'pjax-cart-min'
]); ?>

<h5 class="title">
    <?= Yii::t('app', 'cart-txt') ?>
</h5>
<div class="products_in_cart">
    <?php foreach ($product as $key => $item): ?>
        <?php
        $type = $item->getParam('type', null);
        $priceData = Product::getPriceProductbyId($item->id, $currensy, $type);
        $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
        $image = $item->getParam('image', null);
        $link = $item->getParam('link', $currensy);
        $name = $item->getParam('productName', $currensy);
        ?>
        <div class="products_in_cart__item <?= $type != 'info' ? 'material_product' : '' ?>">
            <?= $this->render('product-photo', [
                'image' => $image
            ]) ?>
            <div class="mini_cart_item__char">
                <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $currensy; ?>/shop/<?= $link ?>" class="title_product_in_cart" data-set-link="<?php echo Yii::$app->params['parentUrl']?>/<?= $currensy; ?>/shop/<?= $link; ?>">
                    <?= $name ?>
                </a>
                <div class="content_mini_cart">
                    <div class="mini_cart__rate-price">
                        <div class="list_rate">
                            <div class="list_rate_table">
                                <?= Raite::widget(['id' => $item['id'], 'view' => true]) ?>
                            </div>
                        </div>

                        <?= $this->render('price_count', [
                            'priceData' => $priceData,
                            'price' => $price,
                            'item' => $item,
                            'cart' => $cart
                        ]) ?>
                    </div>
                    <div class="mini_cart__quantity-delete">
                        <?php if (isset($type) && $type != "info"): ?>
                            <?= $this->render('prc_quantity', ['item' => $item, 'cart' => $cart]) ?>
                        <?php endif; ?>
                        <div class="cart__item-delete delete-tov-cart" data-id="<?= $item->id?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M13 11V16M3 6H19L17.42 20.22C17.3658 20.7094 17.1331 21.1616 16.7663 21.49C16.3994 21.8184 15.9244 22 15.432 22H6.568C6.07564 22 5.60056 21.8184 5.23375 21.49C4.86693 21.1616 4.63416 20.7094 4.58 20.22L3 6ZM6.345 3.147C6.50675 2.80397 6.76271 2.514 7.083 2.31091C7.4033 2.10782 7.77474 2 8.154 2H13.846C14.2254 1.99981 14.5971 2.10755 14.9176 2.31064C15.2381 2.51374 15.4942 2.80381 15.656 3.147L17 6H5L6.345 3.147V3.147ZM1 6H21H1ZM9 11V16V11Z"
                                    stroke="#8B8B8B" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($type) && $type != "info"): ?>
            <?= $this->render('../components/delay', [
                'cart' => $cart,
                'view' => true,
                'item' => $item,
                'lang' => $currensy
            ]) ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>


<?= $this->render('../components/delay', [
    'cart' => $cart,
    'view' => false,
    'lang' => $currensy
]) ?>
<div class="cart_finish">
    <div class="cart_finish__promocodes">
        <div class="set_data" style="flex-direction: column;">
            <div class="block-ert" style="display: flex; width: 100%;">
                <label for="coupon_sale"
                    style="<?= (isset($cart['coupon']) && !empty($cart['coupon']) ? 'top: 3px;font-size:10px' : '') ?>">
                    <?= Yii::t('app', 'placeholder-coupon') ?>
                </label>
                <input type="text" name="coupon_sale" id="field-coupon"
                    class="<?= (isset($cart['coupon']) && !empty($cart['coupon']) ? 'input-active' : '') ?>"
                    value="<?= (isset($cart['coupon']) && !empty($cart['coupon']) ? $cart['coupon'] : '') ?>">

                <?php if (isset($cart['coupon']) && !empty($cart['coupon'])): ?>
                    <input type="submit" value="<?= Yii::t('app', 'btn-apply-set') ?>" id="add-coupon" class="active-btn">
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
                    style="<?= (isset($cart['promocode']) && !empty($cart['promocode']) ? 'top: 3px;font-size:10px' : '') ?>">
                    <?= Yii::t('app', 'placeholder-promocode') ?>
                </label>
                <input type="text" name="coupon_promocode" id="coupon_promocode" value="<?php if (isset($cart['promocode']))
                    echo $cart['promocode']; ?>"
                    class="promocode_partner <?= (isset($cart['promocode']) && !empty($cart['promocode']) ? 'input-active' : '') ?>"
                    <?= (isset($cart['promocode']) ? "disabled" : '') ?>>
                <?php if (isset($cart['promocode']) && !empty($cart['promocode'])): ?>
                    <input type="submit" value="<?= Yii::t('app', 'btn-apply-set') ?>" class="send-promocod active-btn">
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

        <?php if (!empty($cart['promocode'])): ?>
            <p class="cart_finish__total-discount">
                <span class="in-promo">
                    <?= Yii::t('app', 'discount-using-promo-code') ?> "<?= $cart['promocode'] ?>":
                </span><span>
                    <?php echo Cart::PromocodeSizeSale($cart, $product, $currensy) ?>
                </span>
            </p>
        <?php endif; ?>
        <?php if (Promocod::getSize($cart, $currensy)): ?>
            <p class="cart_finish__total-discount">
                <span>
                    <?= Yii::t('app', 'coupon-txt') ?> "<?= Promocod::getName($cart, $currensy) ?>":
                </span>
                <span>
                <?php 
                    $setSize = Promocod::getSize($cart, $currensy);
                    if(str_contains($setSize, '%')){
                        echo $setSize;
                    }else{
                        echo number_format(Promocod::getSize($cart, $currensy), 0, '', ' ');
                        echo Yii::t('app', 'currency-symbol');
                    }?>
                </span>
            </p>
        <?php endif; ?>
        <?php if (isset($cart['insurance']) && !empty($cart['insurance']) && $cart['insurance'] == 1): ?>
            <p class="cart_finish__total-discount">
                <span class="in-promo"><?= Yii::t('app', 'insurance-txt') ?>:</span>
                <span>
                    <?php echo Insurance::getInstance()->getSumm($currensy, $product) ?>
                    <?= Yii::t('app', 'currency-symbol') ?>
                </span>
            </p>
        <?php endif; ?>
        <?php if (isset($cart['delivery']) && !empty($cart['delivery']) && isset($cart['delivery_summ']) && !empty($cart['delivery_summ'])): ?>
            <p>
                <span>
                    <?= Yii::t('app', 'delivery-txt') ?>:
                </span>
                <span>
                    <?php if(isset($poctcode) && !empty($poctcode)):?>
                    <?= number_format(Delivery::getInstance()->getDelSumm($cart['delivery'], $currensy, $poctcode), 0, '', ' ') ?>
                    <?= Yii::t('app', 'currency-symbol'); ?>
                    <?php endif;?>
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
</div>
<?php Pjax::end(); ?>