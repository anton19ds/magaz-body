<?php

use app\widgets\Raite;
use yii\widgets\Pjax;

?>
<?php Pjax::begin([
    'id' => 'pjax-cart-min'
]); ?>
<div class="cart-mini">
    <div class="title">Корзина</div>
    <div class="list-cart-pr">
        <?php foreach ($cart['data'] as $item): ?>

            <div class="tovar-in-cart">
                <div class="img-data">
                    <div class="img" style="
                        background-image: url('<?= $item['productPhoto'] ?>');
                      ">
                    </div>
                </div>
                <div class="info-data">
                    <span class="tt-tovar">
                        <a href=""><?= $item['productName'] ?></a>
                    </span>
                    <div class="rait">
                    <?= Raite::widget(['id' => $item['id'], 'view' => true]) ?>
                    </div>

                    <div class="prse-count">
                        <div class="pr-data">
                            <?= number_format((isset($item['productSize']) && isset($item['productSize']['sale']) && !empty($item['productSize']['sale']) ? $item['productSize']['sale'] : $item['price']), 0, '', ' ') ?>
                            <?= $item['symbol'] ?>
                        </div>
                        <div class="pr-count">
                            <?php if ($item['type'] != 'info'): ?>
                                <span class="minus-tov minus-tov-cart <?= ($item['count'] == 1 ? "grey" : 'active') ?>" data-id="<?= $item['id'] ?>"><img src="/img/minus.svg" alt="" /></span>
                                <input type="text" value="<?= $item['count'] ?>" class="inp-count" />
                                <span class="plus-tov plus-tov-cart" data-id="<?= $item['id'] ?>"><img src="/img/plus.svg" alt="" /></span>
                            <?php endif; ?>
                            <div class="delete-rs delete-tov-cart" data-id="<?= $item['id'] ?>">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13 11V16M3 6H19L17.42 20.22C17.3658 20.7094 17.1331 21.1616 16.7663 21.49C16.3994 21.8184 15.9244 22 15.432 22H6.568C6.07564 22 5.60056 21.8184 5.23375 21.49C4.86693 21.1616 4.63416 20.7094 4.58 20.22L3 6ZM6.345 3.147C6.50675 2.80397 6.76271 2.514 7.083 2.31091C7.4033 2.10782 7.77474 2 8.154 2H13.846C14.2254 1.99981 14.5971 2.10755 14.9176 2.31064C15.2381 2.51374 15.4942 2.80381 15.656 3.147L17 6H5L6.345 3.147V3.147ZM1 6H21H1ZM9 11V16V11Z"
                                        stroke="#8B8B8B" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<div class="block-belay block-dealy-order">
    <p class="products-title products-title_belay">
        Приобретайте страховку, чтобы защитить свой товар на всех этапах
        доставки:
    </p>
    <div class="card-product">
        <div class="card-product__img">
            <img src="/img/catalog/arcticons.svg" alt="" class="img img_fill" />
        </div>
        <div class="card-product__desc">
            <h5 class="card-product__title">Cтраховка</h5>
            <p class="card-product__text">
                Если вашу посылку потеряет почта, то мы вышлем вам новый
                товар.
            </p>
            <div class="card-product__details flex-box">
                <div class="card-product-details">
                    <div class="card-product__price">
                        <span class="price-product"> 300 ₽ </span>
                        <span class="price-product price-product_old">
                            700 ₽
                        </span>
                    </div>
                </div>
                <button class="btn btn_card-product btn_card-product__belay">
                    Добавить
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card-action">
    <div class="coypon">
        <div class="block-form">
            <input type="text" name="coypon" class="set-input-data" id="coypon" placeholder=" " />
            <label for="coypon"> Купон на скидку </label>
        </div>
        <div class="btn-add">
            <a href="">Добавить</a>
        </div>
    </div>
    <div class="coypon">
        <div class="block-form">
            <input type="text" name="promocode" class="set-input-data promocode_partner" id="promocode" placeholder=" " <?php if (isset($cart['promocode']))
                echo 'value="' . $cart['promocode'] . '"'; ?> />
            <label for="promocode"> Промокод </label>
        </div>
        <div class="btn-add">
            <a href="" class="send-promocod">Добавить</a>

        </div>
    </div>

    <div class="block-form checkbox">
        <div class="chekbox">
            <input type="checkbox" name="" id="" />
            <label class="useCheckbox">Оформляя заказ, вы соглашаетесь с
                <a href="">правилами возврата</a> и
                <a href="">условиями обслуживания.</a></label>
        </div>
    </div>
    <div class="block-form checkbox">
        <div class="chekbox">
            <input type="checkbox" name="" id="" />
            <label class="useCheckbox">Оформляя заказ, вы соглашаетесь с нашей
                <a href=""> политикой конфиденциальности </a>, добровольно
                предоставляете свои персональные данные для обработки заказа
                и уведомлений.</label>
        </div>
    </div>
    <div class="data-prom-user">
        <p>
            Персональные данные, полученные из формы обратной связи
            надежно хранятся в нашей базе данных в соответствии
            <a href="">с действующим законодательством</a>.
        </p>
    </div>
    <?= $this->render('our-cart-data', [
        'cart' => $cart,
    ]) ?>
</div>
<?php Pjax::end(); ?>