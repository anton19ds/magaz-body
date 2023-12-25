<?php
use app\models\OrdersMeta;
use yii\bootstrap5\Modal;
$dataOrder = unserialize($order['data_order']);
?>
<div class="all_shadow"></div>
<section id="history_orders">
    <div class="container">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'history'

        ]) ?>
        <div class="infoproducts__main">
            <h1>История заказов</h1>
            <div class="main_order_information">
                <div class="content_order_information">
                    <h4>Информация о заказе</h4>
                    <div class="content_order__status-buttons">
                        <div class="content_order__status">
                            <p>Заказ №<?= $order['id']?> был оформлен <?= date('d.m.Y', $order['date'])?></p>
                            <!-- <p>Статус: «3. Упакован и отправлен»</p> -->
                            <p class="info_track">
                                <!-- Трек-номер отправления: -->
                                <!-- <span class="delivery_number">CA123456789UA</span> -->
                                <span class="copy_icon">
                                    <img src="assets/images/copy.svg" alt="">
                                    <span class="yes_copied">Скопировано</span>
                                </span>
                            </p>
                        </div>
                        <div class="content_order__buttons">
                            <a href="#" class="view_delivery">Отследить заказ</a>
                        </div>
                    </div>
                    <div class="table_order">
                        <div class="table_order__line">
                            <div class="order_box__good-price">
                                <div>
                                    <p class="order_line__goodname">Товар</p>
                                    <p class="order_line__price">Цена</p>
                                </div>
                            </div>
                            <p class="order_line__sale">Скидка</p>
                            <p class="order_line__delivery">Доставка</p>
                            <p class="order_line__methodpay">Метод оплаты</p>
                            <p class="order_line__finishprice">Итого</p>
                        </div>
                        <div class="table_order__line real_table_order_line">
                            <div class="order_box__good-price">
                                <?php foreach($dataOrder as $item):?>
                                <div>
                                    <p class="order_line__goodname"><?=$item['productName']?> × <?=$item['count']?></p>
                                    <p class="order_line__price"><?= $item['price']?> <?= $item['symbol']?></p>
                                </div>
                                <?php endforeach;?>
                            </div>
                            <p class="order_line__sale">1000 ₽</p>
                            <p class="order_line__delivery">350 ₽</p>
                            <p class="order_line__methodpay">
                                <?= OrdersMeta::getLabelPayDesc()[$orderMeta['payment_type']]?>
                            </p>
                            <p class="order_line__finishprice"><?= array_sum(array_column($dataOrder, 'price'))?> ₽</p>
                        </div>
                    </div>
                    <p>
                        <a href="/<?= $lang?>/user">
                            ← Назад к списку заказов
                        </a>
                    </p>
                </div>
                <div class="delivery_addresses__list">
                    <h4>Адрес доставки</h4>
                    <div class="delivery_address_item">
                        <p>
                            <span class="del_address__name"><?= $user['firstName'];?></span>
                            <span class="del_address__fname"><?= $user['LastName'];?></span>
                            <span class="del_address__surname"><?= $user['secondName'];?></span>
                        </p>
                        <p>
                            <span class="del_address__country"><?= $adress['country']?></span>
                            <span class="del_address__index"><?= $adress['postcode']?></span>
                            <span class="del_address__region"><?= $adress['area']?></span>
                            <span class="del_address__city"><?= $adress['city']?></span>
                            <span class="del_address__street"><?= $adress['street']?></span>
                            <span class="del_address__address"><?= $adress['flat']?></span>
                        </p>
                        <p>
                            <span class="del_address__phone"><?= $user['phone'];?></span>
                        </p>
                        <p>
                            <span class="del_address__email"><?= $user['email'];?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>