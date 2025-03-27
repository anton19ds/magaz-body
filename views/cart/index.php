<?php

use app\models\Cart;
use app\models\Insurance;
use app\models\Promocod;
use app\widgets\ApsellCart;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;
use Yii;
?>
<!-- BASKET -->

<!-- insurance -->
<div class="product-wrapper">
    <?php Pjax::begin([
        'id' => 'pjax-cart'
    ]); ?>
    <?= $this->render('view-in-cart', [
        'cart' => $cart,
        'currency' => $currensy
    ]) ?>

    <div class="form flex-box">
        <input type="text" placeholder="<?= Yii::t('app', '[placeholder-coupon]') ?>" id="field-coupon" value="<?= (isset($cart['coupon']) ? $cart['coupon'] : '') ?>">
        <button type="submit" class="btn-form" id="add-coupon">
            <?= Yii::t('app', '[apply]') ?>
        </button>
    </div>
    <div class="form flex-box">
        <input type="text" placeholder="<?= Yii::t('app', '[placeholder-promocode]') ?>"
            value="<?= (isset($cart['promocode']) ? $cart['promocode'] : '') ?>" class="promocode_partner"
            <?= (isset($cart['promocode']) ? "disabled" : '') ?>>

            
        <button type="submit" class="btn-form send-promocod" <?= (isset($cart['promocode']) ? "disabled" : '') ?>>
            <?= Yii::t('app', '[apply]') ?>
        </button>
    </div>


    <ul class="checkbox">
        <li class="checkbox__item">
            <input type="checkbox" name="#" value="#" class="checkbox__select" checked>
            <label>
                <?= Yii::t('app', '[condition-block-a]') ?>
            </label>
        </li>
        <li class="checkbox__item">
            <input type="checkbox" name="#" value="#" class="checkbox__select" checked>
            <label>
                <?= Yii::t('app', '[condition-block-b]') ?>
            </label>
        </li>
        <li class="checkbox__item">
            <p class="desc-submission">
                <?= Yii::t('app', '[condition-block-c]') ?>
            </p>
        </li>
    </ul>
    <?php if (isset($cart['promocode'])): ?>
        <label class="total-value"> Товар: <input type="text"
                value="<?= number_format(round($cart['totalData']['salePrice']), 0, '', ' ') ?> ₽"></label>
        <label class="total-value"> Скидка по промокоду "
            <?= $cart['promocode'] ?>" : <input type="text"
                value="<?= number_format(round($cart['totalData']['saleSizePrice']), 0, '', ' ') ?> <?= Yii::t('app', '[currency-symbol]') ?>">
        </label>
    <?php endif; ?>

    <?php if (isset($cart['insurance'])): ?>
        <label class="total-value">
            <?= Yii::t('app', 'insurance-txt') ?>:
            <input type="text" value="<?= number_format(Insurance::getInstance()->getSumm($currensy), 0, '',' ') ?> <?= Yii::t('app', 'currency-symbol') ?>">
        </label>
    <?php endif; ?>
    
    <?php if(Promocod::getSize($cart, $currensy)):?>
        <label class="total-value">
        <?= Yii::t('app', 'coupon-txt') ?>:
        <input type="text"
            value="<?= Promocod::getSize($cart, $currensy)?> <?= Yii::t('app', 'currency-symbol') ?>">
        </label>
    <?php endif;?>

    <label class="total-value result">
        <?= Yii::t('app', 'total') ?>:

        <input type="text"
            value="<?= number_format(Cart::getInstance()->getOurSummCart($currensy), 0, '', ' ') ?> <?= Yii::t('app', 'currency-symbol') ?>">
    </label>

    <a href="/<?= $currensy ?>/order" class="btn btn_submission">
        <?= Yii::t('app', 'next-btn') ?>
    </a>
    <?php Pjax::end(); ?>
</div>
</div>
<div class="left-block">
    <?= ApsellCart::widget(['title' => Yii::t('app', 'best-product'), 'lang' => $currensy]) ?>
    <?= $this->render('../components/delay', [
        'cart' => $cart,
        'view' => false,
        'lang' => $currensy
    ]) ?>
</div>