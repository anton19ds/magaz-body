<?php 
use app\widgets\Apsell;
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
                    <div id="cart-element-data">

                    </div>
                </div>
                <?= Apsell::widget(['title' => 'Лучший выбор покупателей']) ?>
            </div>
            <div class="cart-header bottom-set">
                <div class="currents">
                    <div class="def-itog">Итого</div>
                    <div class="def-prise">
                        <span id="end-resutl"></span>
                    </div>
                </div>
                <div class="action-btn">
                    <div class="remove-cart close-cart">Продолжить</div>
                    <div class="in-cart"> <a href="/<?= $lang ?>/cart">Перейти в корзину</a></div>
                </div>
            </div>
        </div>
    </div>
</div>