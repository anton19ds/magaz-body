<?php

use app\models\Orders;
use app\widgets\Apsell;

?>
<div id="page-magazin">

    <div class="left-block">
        <div class="header-block-cart">
            <div class="logo">
                <img src="/img/Logo.svg" alt="">
            </div>
            <div class="stepblock">
                <div class="step step-cart">Корзина</div>
                <div class="step step-contact">Контактная информация</div>
                <div class="step step-del">Способ доставки</div>
                <div class="step step-pay active">Способ оплаты</div>
            </div>
            <div class="data-tovar">
                <?php $arraySet = unserialize($order['data_order']) ?>
                <?php $product = Orders::getTovarList($order['data_order']); ?>
                <?php
                //debug($addres);
                

                ?>
                <div class="adress-shiping">
                    <label for="">Адпесс доставки</label><br>
                    <?php
                    echo $addres->postcode . " " .
                        $addres->city . " " .
                        $addres->country . " " .
                        $addres->area . " " .
                        $addres->flat . " " .
                        $addres->street;
                    ?>

                </div>
                <?php
                $summ = 0;
                foreach ($arraySet as $tots) {
                    $summ = $summ + ($tots['price'] * $tots['count']);
                } ?>
                <div class="list-tovar">
                    <?php foreach ($product as $item): ?>
                        <?php $price = $item->getPriceProduct($currency = null) ?>
                        <?php $meta = $item->arrayMeta($lang) ?>
                        <div class="element-list-tovar-serty">
                            <div class="img-tovar">
                                <?php echo $item->getProductFoto($stat = true) ?>
                            </div>
                            <div class="tovar-param-cart">
                                <div class="title-price-cart">
                                    <div class="tt-cart">
                                        <?= $meta['productName'] ?>
                                    </div>
                                    <div class="price-tovar">
                                        <?= $arraySet[$item->id]['price']; ?> ₽
                                    </div>
                                </div>
                            </div>
                            <div class="data-cart-prise">
                                <div class="summ">
                                    <span class="summ-m">
                                        <?= $arraySet[$item->id]['count'] ?>шт. /
                                        <?= $arraySet[$item->id]['price'] * $arraySet[$item->id]['count'] ?> ₽
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="summ-right">
                    <span>
                        Итого к оплате:
                    </span>
                    <span>
                        <?= $summ ?>
                    </span>
                </div>
            </div>
            <div class="payment-final-card">
                <p>
                    Для оплаты сделайте перевод по указаным ниже реквизитам:
                </p>
                <p>
                    <?= $text->descript ?>
                </p>
                <p>
                    После оплаты, передайте чек потверждения в чат администратору
                </p>
            </div>
            <div class="data_user_con" contenteditable="false">
                <label for="">Чат с администратором</label>
                <ul>
                    <li><a href=""><img src="/icon/facebook.svg"></a></li>
                    <li><a href=""><img src="/icon/Group.svg"></a></li>
                    <li><a href=""><img src="/icon/odnoklassniki 2.svg"></a></li>
                    <li><a href=""><img src="/icon/vk.svg"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="right-block">
        <?= Apsell::widget(['title' => 'Лучший выбор покупателей', 'lang' => $lang]) ?>
    </div>
</div>