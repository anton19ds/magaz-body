<?php

use app\widgets\ApsellCart;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

?>
<!-- BASKET -->


<div class="product-wrapper">
    <?php Pjax::begin([
        'id' => 'pjax-cart'
    ]); ?>
    <?= $this->render('view-in-cart', [
        'cart' => $cart,
        'currency' => $currensy
    ]) ?>

    <div class="form flex-box">
        <input type="text" placeholder="Купон на скидку">
        <button type="submit" class="btn-form">Применить</button>
    </div>
    <div class="form flex-box">
        <input type="text" placeholder="Промокод партнера" value="<?= (isset($cart['promocode']) ? $cart['promocode'] : '') ?>"
            class="promocode_partner">
        <button type="submit" class="btn-form send-promocod" <?= (isset($cart['promocode']) ? "disabled" : '') ?>>Применить</button>
    </div>


    <ul class="checkbox">
        <li class="checkbox__item">
            <input type="checkbox" name="#" value="#" class="checkbox__select" checked>
            <label>
                Оформляя заказ, вы соглашаетесь с
                <a href="#">
                    правилами возврата
                </a>
                и
                <a href="#">
                    условиями обслуживания
                </a>
                .
            </label>
        </li>
        <li class="checkbox__item">
            <input type="checkbox" name="#" value="#" class="checkbox__select">
            <label>
                Оформляя заказ, вы соглашаетесь с нашей
                <a href="#">
                    политикой конфиденциальности
                </a>
                , добровольно предоставляете свои персональные данные для обработки заказа и
                уведомлений.
            </label>
        </li>
        <li class="checkbox__item">
            <p class="desc-submission">
                Персональные данные, полученные из формы обратной связи надежно хранятся в нашей базе
                данных в соответствии
                <a href="#">
                    с действующим законодательством.
                </a>
            </p>
        </li>
    </ul>
    <!-- [totalData] => Array
        (
            [saleSizePrice] => 0
            [totalPrice] => 0
            [saleCash] => 0
            [count] => 6
        ) -->

        
    
    <?php if (isset($cart['promocode'])): ?>
        <label class="total-value"> Товар: <input type="text"
            value="<?= number_format(round($cart['totalData']['salePrice']), 0, '', ' ') ?> ₽"></label>
        <label class="total-value"> Скидка по промокоду "
            <?= $cart['promocode'] ?>" : <input type="text" value="<?= number_format(round($cart['totalData']['saleSizePrice']), 0, '', ' ') ?> ₽">
        </label>
    <?php endif; ?>

    <label class="total-value result"> Итого: <input type="text"
            value="<?php if(isset($cart['totalData']['totalPrice']) && $cart['totalData']['totalPrice'] != 0){
                echo number_format(round($cart['totalData']['totalPrice']), 0, '', ' ');
            }else{
                echo number_format(round($cart['totalData']['salePrice']), 0, '', ' ');
            }  ?> ₽"></label>

    <a href="/<?= $currensy ?>/order" class="btn btn_submission">Продолжить</a>
    <?php Pjax::end(); ?>
</div>
</div>



<div class="left-block">
    <?= ApsellCart::widget(['title' => 'Лучший выбор покупателей', 'lang' => $currensy]) ?>
    <div class="block-belay">
        <p class="products-title products-title_belay">
            Приобретайте страховку, чтобы защитить свой товар на всех этапах доставки:
        </p>
        <div class="card-product">
            <div class="card-product__img">
                <img src="/img/catalog/arcticons.svg" alt="" class="img img_fill">
            </div>
            <div class="card-product__desc">
                <h5 class="card-product__title">
                    Cтраховка
                </h5>
                <p class="card-product__text">
                    Если вашу посылку потеряет почта, то мы вышлем вам новый товар.
                </p>
                <div class="card-product__details flex-box">
                    <div class="card-product-details ">
                        <div class="card-product__price">
                            <span class="price-product">
                                300 ₽
                            </span>
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
</div>