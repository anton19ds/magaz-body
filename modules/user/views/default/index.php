<?php
use yii\bootstrap5\Modal;

?>




<div class="all_shadow"></div>


<section id="history_orders">
    <div class="container">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'history'
            
        ]) ?>
        <?php $order = $user->getOrders() ?>

        <?php if (!empty($order)): ?>
                <div class="infoproducts__main">
                    <h1>История заказов</h1>
                    <div class="table_history_orders">
                        <div class="table_orders__line">
                            <p class="orders_line__number_order">Заказ №</p>
                            <p class="orders_line__date_order">Дата</p>
                            <p class="orders_line__status_order">Статус</p>
                            <p class="orders_line__price_order">Итого</p>
                            <p class="orders_line__actions">Действия</p>
                        </div>


                        <?php $chet = 1; ?>
                        <?php foreach ($order as $key => $element): ?>
                            <div class="order_payed">
                                <a href="#" class="table_orders__line">
                                    <p class="orders_line__number_order">
                                        <?= $element->id; ?>
                                    </p>
                                    <p class="orders_line__date_order">
                                        <?php echo date('Y-m-d', $element->date); ?>
                                    </p>
                                    <p class="orders_line__status_order">2. Передан на упаковку</p>
                                    <p class="orders_line__price_order">
                                        <?php echo $element->orderInfo() ?>
                                    </p>
                                    <p class="orders_line__actions"></p>
                                </a>
                                <div class="actions_horders_elements">
                                    <a class="orders_line__actions_view" href="/<?= $lang?>/user/order/<?= $element->id; ?>">Просмотр</a>
                                    <a class="orders_line__actions_pay" href="#">Оплатить</a>
                                    
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php else: ?>
                <div class="infoproducts__main">
                    <h1>История заказов</h1>
                    <div class="blue_notification">
                        <svg xmlns="http://www.w3.org/2000/svg" width="53" height="53" viewBox="0 0 53 53" fill="none">
                            <g clip-path="url(#clip0_1218_122692)">
                                <path
                                    d="M49.412 13.8288C49.4113 13.7902 49.4088 13.7517 49.4043 13.7135C49.403 13.7015 49.4019 13.6894 49.4001 13.6776C49.3933 13.631 49.3844 13.5849 49.3723 13.5396C49.3707 13.5336 49.3685 13.5279 49.3668 13.522C49.3555 13.4825 49.3421 13.4436 49.3269 13.4054C49.3219 13.3931 49.3167 13.381 49.3114 13.3689C49.2963 13.3343 49.2795 13.3005 49.261 13.2672C49.2564 13.259 49.2523 13.2503 49.2475 13.2422C49.2231 13.2007 49.1964 13.1604 49.1669 13.1218C49.1646 13.1188 49.1619 13.1159 49.1596 13.1129C49.133 13.0787 49.1041 13.046 49.0735 13.0146C49.0651 13.006 49.0563 12.9976 49.0477 12.9892C49.0207 12.9631 48.9924 12.9383 48.9627 12.9146C48.9535 12.9071 48.9447 12.8995 48.9352 12.8924C48.8979 12.8643 48.8592 12.8376 48.8178 12.8136L27.1033 0.163047C26.7303 -0.054349 26.2692 -0.054349 25.8962 0.163047L4.18153 12.8135C4.14016 12.8376 4.10143 12.8642 4.06414 12.8923C4.05466 12.8994 4.04591 12.9071 4.03668 12.9145C4.00694 12.9382 3.97864 12.963 3.95166 12.989C3.94291 12.9974 3.93427 13.0058 3.92588 13.0145C3.8953 13.0459 3.86641 13.0786 3.83979 13.1128C3.83739 13.1158 3.83475 13.1187 3.83247 13.1217C3.80297 13.1603 3.77635 13.2006 3.75189 13.2421C3.7471 13.2502 3.7429 13.2588 3.73834 13.2671C3.71988 13.3003 3.70309 13.3341 3.68798 13.3688C3.6827 13.3809 3.67743 13.393 3.67251 13.4053C3.65728 13.4435 3.64385 13.4824 3.63258 13.5219C3.6309 13.5278 3.62863 13.5336 3.62707 13.5394C3.61496 13.5848 3.60608 13.6309 3.59925 13.6774C3.59757 13.6893 3.59649 13.7014 3.59505 13.7134C3.59061 13.7517 3.5881 13.79 3.58738 13.8287C3.58726 13.8356 3.58594 13.8424 3.58594 13.8495V39.1504C3.58594 39.5772 3.81269 39.9717 4.18141 40.1866L25.8961 52.837C25.8995 52.8391 25.9031 52.8403 25.9066 52.8422C25.9494 52.8666 25.9935 52.8891 26.0395 52.9081C26.04 52.9084 26.0406 52.9085 26.0412 52.9087C26.0846 52.9267 26.1294 52.9415 26.1752 52.9543C26.1868 52.9575 26.1984 52.9604 26.2101 52.9633C26.246 52.9722 26.2824 52.9793 26.3195 52.985C26.3318 52.9869 26.344 52.9892 26.3564 52.9906C26.4035 52.9963 26.4511 53 26.4997 53C26.5482 53 26.596 52.9963 26.643 52.9906C26.6553 52.9892 26.6676 52.9869 26.6799 52.985C26.717 52.9793 26.7534 52.9722 26.7893 52.9633C26.8009 52.9604 26.8125 52.9576 26.8242 52.9543C26.87 52.9415 26.9148 52.9267 26.9582 52.9087C26.9587 52.9085 26.9593 52.9084 26.9599 52.9081C27.0058 52.8891 27.0499 52.8666 27.0928 52.8422C27.0962 52.8403 27.0998 52.8389 27.1033 52.837L48.818 40.1866C49.1867 39.9717 49.4134 39.5772 49.4134 39.1504V13.8495C49.4134 13.8426 49.4121 13.8358 49.412 13.8288ZM26.4997 25.1124L18.0245 20.1749L37.357 8.91212L45.8323 13.8496L26.4997 25.1124ZM26.4997 2.5869L34.9749 7.52441L15.6424 18.7872L7.16715 13.8496L26.4997 2.5869ZM47.0152 38.4613L27.6988 49.7147V44.8462C27.6988 44.184 27.1619 43.6472 26.4997 43.6472C25.8374 43.6472 25.3006 44.184 25.3006 44.8462V49.7147L5.98413 38.4613V15.9359L15.0524 21.2189C15.053 21.2193 15.0537 21.2196 15.0543 21.2201L25.3006 27.1892V40.0499C25.3006 40.7121 25.8374 41.249 26.4997 41.249C27.1619 41.249 27.6988 40.7121 27.6988 40.0499V27.1892L47.0152 15.9359V38.4613Z"
                                    fill="#00A6CA" />
                                <path
                                    d="M34.128 29.7236C34.3508 30.106 34.7525 30.3193 35.1652 30.3193C35.3702 30.3193 35.5779 30.2668 35.7677 30.1561L40.1545 27.6005C40.7267 27.2672 40.9203 26.5331 40.587 25.9609C40.2536 25.3887 39.5194 25.1951 38.9473 25.5284L34.5605 28.084C33.9883 28.4173 33.7947 29.1514 34.128 29.7236Z"
                                    fill="#00A6CA" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1218_122692">
                                    <rect width="53" height="53" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <p class="title_blue_notification">У вас пока нет заказов!</p>
                        <div class="description_blue_notification">
                            <p>Начните с покупки наших лучших товаров.</p>
                        </div>
                        <div class="list_goods">
                            <div class="list_goods___item">
                                <img src="/asset/images/examples/shop-good.jpg" alt="" class="good_img">
                                <h5>ANTI-CANDIDA (АНТИ-КАНДИДА) курс очищения от грибков</h5>
                                <div>
                                    <div class="good__characters">
                                        <div class="list_rate">
                                            <div class="list_rate_table">
                                                <span class="rate_active"></span>
                                                <span class="rate_active"></span>
                                                <span class="rate_active"></span>
                                                <span class="rate_active"></span>
                                                <span></span>
                                            </div>
                                            <p class="count_rate">( 98 )</p>
                                        </div>
                                        <p class="price_count">
                                            6 000 &#8381;
                                            <span class="sale-price_count">
                                                8 500 &#8381;
                                            </span>
                                        </p>
                                    </div>
                                    <a href="">Подробнее</a>
                                </div>
                            </div>
                            <div class="list_goods___item">
                                <img src="/asset/images/examples/shop-good.jpg" alt="" class="good_img">
                                <h5>ANTI-CANDIDA (АНТИ-КАНДИДА) курс очищения от грибков</h5>
                                <div>
                                    <div class="good__characters">
                                        <div class="list_rate">
                                            <div class="list_rate_table">
                                                <span class="rate_active"></span>
                                                <span class="rate_active"></span>
                                                <span class="rate_active"></span>
                                                <span class="rate_active"></span>
                                                <span></span>
                                            </div>
                                            <p class="count_rate">( 98 )</p>
                                        </div>
                                        <p class="price_count">
                                            6 000 &#8381;
                                            <span class="sale-price_count">
                                                8 500 &#8381;
                                            </span>
                                        </p>
                                    </div>
                                    <a href="">Подробнее</a>
                                </div>
                            </div>
                            <div class="list_goods___item">
                                <img src="/asset/images/examples/shop-good.jpg" alt="" class="good_img">
                                <h5>ANTI-CANDIDA (АНТИ-КАНДИДА) курс очищения от грибков</h5>
                                <div>
                                    <div class="good__characters">
                                        <div class="list_rate">
                                            <div class="list_rate_table">
                                                <span class="rate_active"></span>
                                                <span class="rate_active"></span>
                                                <span class="rate_active"></span>
                                                <span class="rate_active"></span>
                                                <span></span>
                                            </div>
                                            <p class="count_rate">( 98 )</p>
                                        </div>
                                        <p class="price_count">
                                            6 000 &#8381;
                                            <span class="sale-price_count">
                                                8 500 &#8381;
                                            </span>
                                        </p>
                                    </div>
                                    <a href="">Подробнее</a>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="blue_notification_button">В магазин</a>
                    </div>
                </div>


            <?php endif; ?>


    </div>
</section>