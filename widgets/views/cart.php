<?php
use app\widgets\ApsellCart;
use app\widgets\Raite;
use yii\widgets\Pjax;

?>
<div class="cart-modal" style="display:none">

    <div class="cart-wraper">
        <div class="cart">
            <div class="cart-header">
                <div class="img-logo">
                    <img src="/img/Logo.svg" alt="" />
                </div>
                <div class="btn-close close-cart">
                    <img src="/img/close.svg" alt="" />
                </div>
            </div>
            <div class="card-body">
                <div class="card-element-list">
                    <div class="cart-element-header">
                        <span>Ваши товары</span>
                    </div>
                    <?php Pjax::begin([
                        'id' => 'pjax-cart-modal'
                    ]); ?>
                    <div id="cart-element-data">
                        <?php if (isset($cart['data'])): ?>
                            <?php foreach ($cart['data'] as $key => $item): ?>
                                <?php if ($key != 'promocod' && $key != 'size'): ?>
                                    <div class="cart-element" data-id="<?= $item['id'] ?>">
                                        <div class="img-block">
                                            <img src="<?= $item['productPhoto'] ?>" alt="">
                                        </div>
                                        <div class="data-block">
                                            <div class="list-first">
                                                <div class="title-sard-el">
                                                    <?= $item['productName'] ?>
                                                </div>
                                                <div class="delete-elem-in-cart delete-tov-cart" data-id="<?= $item['id'] ?>">
                                                    <img src="/img/close (1).svg" alt="" />
                                                </div>
                                            </div>
                                            <div class="list-next">
                                                <div class="card-product__rating flex-box">
                                                    <?= Raite::widget(['id' => $item['id'], 'view' => true]) ?>
                                                </div>
                                                <div class="data-count">
                                                    <?php if ($item['type'] != 'info'): ?>
                                                        <span data-id="<?= $item['id'] ?>"
                                                            class="minus-tov <?= ($item['count'] == 1 ? "grey" : 'active') ?> minus-tov-cart">
                                                            <img src="/img/minus.svg" alt="" />
                                                        </span>
                                                        <span class="count" data-id="<?= $item['id'] ?>">
                                                            <?= $item['count'] ?>
                                                        </span>
                                                        <span data-id="<?= $item['id'] ?>" class="plus-tov plus-tov-cart">
                                                            <img src="/img/plus.svg" alt="" />
                                                        </span>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="data-price" data-id="<?= $item['id'] ?>">
                                                    <?= number_format($item['price'], 0, '', ' ') ?>
                                                    <?= $item['symbol'] ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <?php Pjax::end(); ?>
                </div>
                <?= ApsellCart::widget(['title' => 'Лучший выбор покупателей', 'lang' => $lang]) ?>
            </div>
            <div class="cart-header bottom-set">
                <div class="currents">
                    <div class="def-itog">Итого</div>
                    <div class="def-prise">
                        <span id="end-resutl"><?= isset($cart['totalData']['salePrice']) ? number_format($cart['totalData']['salePrice'], 0, '', ' ') : '' ?></span>
                    </div>
                </div>
                <div class="action-btn">
                    <div class="remove-cart close-cart">Продолжить</div>
                    <div class="in-cart"> <a href="/<?= $lang ?>/cart" data-pjax=0>Перейти в корзину</a></div>
                </div>
            </div>
        </div>
    </div>
</div>