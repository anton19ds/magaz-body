<?php

use app\widgets\Curren;
?>


<section class="catalogs" id="catalogs">
    <div class="container">
        <div class="catalog" id="catalog">
            <div class="catalog__banner">
                <img src="/img/banner.jpg" alt="BALANCE" class="img ">
            </div>
            <nav class="sort flex-box">
                <select class="dropdown" id="dropdown">
                    <option class="dropdown__name">
                        Все категории товаров
                    </option>
                    <option class="dropdown__name">
                        Иннной выбор
                    </option>
                    <option class="dropdown__name">
                        Инной выбор
                    </option>
                </select>
                <button class="btn btn_sort">
                    СОРТИРОВАТЬ
                </button>
                <?= Curren::widget();?>
                
            </nav>
            <div class="card-wrapper flex-box">
                <?php foreach ($model as $item): ?>
                    <?= $this->render('product-card', [
                        'item' => $item,
                        'currency' => $currency
                    ]) ?>
                <?php endforeach; ?>
                <!-- <div class="card">
                    <span class="card-sale">
                        Хит продаж
                    </span>
                    <div class="card-img">
                        <img src="/img/catalog/img-catalog-1.jpg" alt="" class="img">
                    </div>
                    <div class="card-desc">
                        <h3 class="card-desc__title">
                            ANTI-CANDIDA / АНТИ-КАНДИДА (КУРС ОЧИЩЕНИЯ ОТ ГРИБКОВ)
                        </h3>
                        <div class="card-desc__details flex-box">
                            <div class="card-details">
                                <div class="card-details__rating flex-box">
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star"></span>
                                    <span>( 98 )</span>
                                </div>
                                <div class="card-details__price">
                                    <span class="price">
                                        6 000 ₽
                                    </span>
                                    <span class="price price_old">
                                        8 500 ₽
                                    </span>
                                </div>
                            </div>
                            <button class="btn btn_card" id="btn-card-1" data-btn="1">
                                Подробнее
                            </button>
                        </div>
                    </div>
                    <div class="card-dropdown" id="card-dropdown-1" data-content="1">
                        <div class="quantity-dropdown">
                            <ul class="quantity" id="quantity-dropdown-1">
                                <li class="quantity__item active">
                                    <span>
                                        Количество:
                                    </span>
                                    1-Pack
                                </li>
                                <li class="quantity__item ">
                                    <span>
                                        Количество:
                                    </span>
                                    2-Pack
                                </li>
                                <li class="quantity__item ">
                                    <span>
                                        Количество:
                                    </span>
                                    3-Pack
                                </li>
                            </ul>
                        </div>
                        <button class="btn btn_basket">
                            В корзину
                        </button>
                    </div>
                </div>
                <div class="card disabled">
                    <span class="card-sale disabled">
                        Хит продаж
                    </span>
                    <div class="card-img">
                        <img src="/img/catalog/img-catalog-5.jpg" alt="" class="img">
                    </div>
                    <div class="card-desc">
                        <h3 class="card-desc__title disabled">
                            ANTI-CANDIDA / АНТИ-КАНДИДА (КУРС ОЧИЩЕНИЯ ОТ ГРИБКОВ)
                        </h3>
                        <div class="card-desc__details flex-box">
                            <div class="card-details disabled">
                                <div class="card-details__rating flex-box">
                                    <span class="star active disabled "></span>
                                    <span class="star active disabled "></span>
                                    <span class="star active disabled "></span>
                                    <span class="star active disabled "></span>
                                    <span class="star disabled "></span>
                                    <span>( 98 )</span>
                                </div>
                                <div class="card-details__price">
                                    <span class="price disabled ">
                                        6 000 ₽
                                    </span>
                                    <span class="price price_old disabled ">
                                        8 500 ₽
                                    </span>
                                </div>
                            </div>
                            <button class="btn btn_card disabled" id="btn-card-3">
                                Нет в наличии
                            </button>
                        </div>
                    </div>
                    <div class="card-dropdown" id="card-dropdown-3">
                        <div class="quantity-dropdown disabled">
                            <ul class="quantity disabled" id="quantity-dropdown-3">
                                <li class="quantity__item active">
                                    <span>
                                        Количество:
                                    </span>
                                    1-Pack
                                </li>
                                <li class="quantity__item ">
                                    <span>
                                        Количество:
                                    </span>
                                    2-Pack
                                </li>
                                <li class="quantity__item ">
                                    <span>
                                        Количество:
                                    </span>
                                    3-Pack
                                </li>
                            </ul>
                        </div>
                        <button class="btn btn_basket disabled">
                            В корзину
                        </button>
                    </div>
                </div>
                <div class="card card_marketing">
                    <span class="card-sale card-sale_fill">
                        Реклама
                    </span>
                    <div class="card-img card-img_marketing">
                        <img src="/img/catalog/card-mark.jpg" alt="" class="img">
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>
<!-- CRITERION -->
<section class="criterion" id="criterion">
    <div class="container">
        <ul class="criterion-list">
            <li class="criterion-item">
                <h4>
                    Правила Возврата
                </h4>
            </li>
            <li class="criterion-item">
                <h4>
                    ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ
                </h4>
            </li>
            <li class="criterion-item">
                <h4>
                    УСЛОВИЯ ОБСЛУЖИВАНИЯ
                </h4>
            </li>
        </ul>
    </div>
</section>