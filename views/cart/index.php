<?php
use app\widgets\Apsell;
use yii\widgets\Pjax;

?>
<div id="page-magazin">
    <div class="left-block">
        <div class="header-block-cart">
            <div class="logo">
                <a href="/<?= $currensy ?>">
                    <img src="/img/Logo.svg" alt="">
                </a>
            </div>
            <div class="stepblock">
                <div class="step step-cart active">Корзина</div>
                <div class="step step-contact">Контактная информация</div>
                <div class="step step-del">Способ доставки</div>
                <div class="step step-pay">Способ оплаты</div>
            </div>
        </div>
        <?php Pjax::begin([
            'id' => 'list-tovar',
        ]); ?>
        <div class="tovar-list-in-cart">
            <div class="list-tovar">
                <?php $esty = 0; ?>
                <?php $symbol; ?>
                <?php foreach ($cart as $key => $item): ?>
                    <?php if ($key != "promocod" && $key != "size"): ?>
                        <?php $meta = $item['product']->arrayMeta($currency = null); ?>
                        <div class="element-list-tovar" data-id="<?= $item['id'] ?>">
                            <div class="img-tovar">
                                <?php $metaArrayPrice = $item['product']->getPriceProduct($currency = null); ?>
                                <?php if ($item['product']->getProductFoto(true) !== false): ?>
                                    <?php echo $item['product']->getProductFoto(true) ?>
                                <?php endif; ?>
                            </div>
                            <div class="tovar-param-cart">
                                <div class="title-price-cart">
                                    <div class="tt-cart">
                                        <?= $meta['productName'] ?>
                                    </div>
                                    <?php if (isset($metaArrayPrice['summ']) && !empty($metaArrayPrice['summ'])) {
                                        $priseStr = '<div class="price-tovar">' . $metaArrayPrice['summ'] . ' ' . $metaArrayPrice['symbolCode'] . '<span>' . $metaArrayPrice['price'] . ' ' . $metaArrayPrice['symbolCode'] . '</span></div>';
                                    } else {
                                        $priseStr = '<div class="price-tovar">' . $metaArrayPrice['price'] . ' ' . $metaArrayPrice['symbolCode'] . '</div>';
                                    } ?>
                                    <?= $priseStr; ?>
                                </div>
                            </div>
                            <div class="col-param-cart-data">
                                <div class="minus" data-id="<?= $item['id'] ?>">
                                    <img src="/img/minus.svg" alt="" data-id="<?= $item['id'] ?>">
                                </div>
                                <div class="col-elem" data-id="<?= $item['id'] ?>">
                                    <?= $item['count'] ?>
                                </div>
                                <div class="plus" data-id="<?= $item['id'] ?>">
                                    <img src="/img/plus.svg" alt="" data-id="<?= $item['id'] ?>">
                                </div>
                            </div>
                            <div class="data-cart-prise">
                                <div class="summ" data-id="<?= $item['id'] ?>">
                                    <?php $symbol = $metaArrayPrice['symbolCode']; ?>
                                    <span class="summ-m" data-id="<?= $item['id'] ?>">
                                        <?= $item['price'] * $item['count'] . ' ' . $metaArrayPrice['symbolCode']; ?>
                                    </span>
                                    <?php $esty = $esty + ($item['price'] * $item['count']); ?>
                                    <div class="del-in-cart" data-id="<?= $item['id'] ?>">
                                        <img src="/img/cart-del.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="form-data">
                <div class="kupon-form">
                    <input type="text" placeholder="Промокод" id="promocod">
                    <div class="btn check-promocod">Применить</div>
                </div>
            </div>

            <div class="accept-data">
                <label for="set1">
                    <input type="checkbox" id="set1" name="set1" style="display:none" checked>
                    <div class="chekbox-block">

                        <div>
                            Оформляя заказ, вы соглашаетесь
                            <a href="">с правилами возврата</a> и
                            <a href="">условиями обслуживания</a>.
                        </div>
                    </div>
                </label>
                <label for="set2">
                    <input type="checkbox" id="set2" name="set2" style="display:none" checked>
                    <div class="chekbox-block">
                        <div>
                            Оформляя заказ, вы соглашаетесь с нашей политикой
                            конфиденциальности, добровольно предоставляете свои персональные
                            данные для обработки заказа и уведомлений.
                        </div>
                    </div>
                </label>
                <p>
                    Персональные данные, полученные из формы обратной связи надежно
                    хранятся в нашей базе данных в соответствии с действующим
                    законодательством.
                </p>
            </div>
            <div class="curenncy">
                <div class="result">
                    <div class="text-res">
                        <span>Товар:</span>
                    </div>
                    <div class="prise-res">
                        <span class="prise-sum-s">
                            <?= $esty ?>
                            <?= $symbol ?>
                        </span>
                    </div>
                </div>
                <div class="end-pay">
                    <span> Итого </span>
                    <span class="prise-sum-s">
                        <?= $esty ?>
                        <?= $symbol ?>
                    </span>
                </div>
            </div>
            <div class="final-btn">
                <div class="btn">
                    <a href="/<?= $currensy ?>/order">Продолжить</a>
                </div>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
    <div class="right-block">
        <?= Apsell::widget(['title' => 'Лучший выбор покупателей']) ?>
    </div>
</div>