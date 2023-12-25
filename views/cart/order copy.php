<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BALANCE CLINIC</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/order.css" />
    <link rel="stylesheet" href="css/media.css" />
  </head>
  <body>
    <!-- HEADER -->
    <header class="header" id="header"></header>
    <!-- BASKET -->
    <section class="section-basket" id="section-basket">
      <div class="container">
        <div class="block-wrapper">
          <div class="basket">
            <div class="basket-logo">
              <img src="img/basket-logo.svg" alt="BODEY BALANCE" />
            </div>
            <nav class="basket-nav">
              <ul class="basket-nav__list flex-box">
                <li class="basket-nav__item active">
                  <a href="#">Корзина</a>
                  <svg
                    class="basket-nav__icon"
                    xmlns="http://www.w3.org/2000/svg"
                    width="6"
                    height="10"
                    viewBox="0 0 6 10"
                    fill="none"
                  >
                    <path d="M1 1L5 5L1 9" />
                  </svg>
                </li>
                <li class="basket-nav__item" data-list="contact-data">
                  <a href="#">Контактная информация</a>
                  <svg
                    class="basket-nav__icon"
                    xmlns="http://www.w3.org/2000/svg"
                    width="6"
                    height="10"
                    viewBox="0 0 6 10"
                    fill="none"
                  >
                    <path d="M1 1L5 5L1 9" />
                  </svg>
                </li>
                <li class="basket-nav__item">
                  <a href="#">Способ доставки</a>
                  <svg
                    class="basket-nav__icon"
                    xmlns="http://www.w3.org/2000/svg"
                    width="6"
                    height="10"
                    viewBox="0 0 6 10"
                    fill="none"
                  >
                    <path d="M1 1L5 5L1 9" />
                  </svg>
                </li>
                <li class="basket-nav__item">
                  <a href="#">Способ оплаты</a>
                </li>
              </ul>
            </nav>
            <div class="product-wrapper">
              <div class="top-prod-header">
                <div>Контактная информация</div>
                <div>Вы уже зарегестрированы? <a href="">Войти</a></div>
              </div>

              <div class="form-order-user">
                <div class="block-form">
                  <input
                    type="text"
                    name="email"
                    class="set-input-data"
                    id="email"
                    placeholder="  "
                  />
                  <label for="email"> E-mail </label>
                </div>
                <div class="block-form checkbox">
                  <div class="chekbox">
                    <input type="checkbox" name="" id="" />
                    <label>Сообщать мне об акциях и скидках</label>
                  </div>
                </div>
                <div class="block-form phone">
                  <div class="after-block-proms">
                    <div class="prom">
                      Введите телефон, если хотите, чтобы мы <br />
                      присылали информацию о вашем заказе в СМС
                    </div>
                  </div>
                  <input
                    type="text"
                    name="phpne"
                    class="set-input-data"
                    id="phone"
                    placeholder=" "
                  />
                  <label for="phone"> Телефон </label>
                </div>

                <div class="block-form checkbox border-s">
                  <div class="chekbox active">
                    <input type="checkbox" name="" id="" />
                    <p>
                      Получать СМС оповещения о моем заказе
                      <span
                        >Сразу после отправки заказа вы получите трек-номер
                        посылки на e-mail и в sms для отслеживания актуальной
                        информации о местонахождении отправления.</span
                      >
                    </p>
                  </div>
                </div>

                <div class="set-asset">Адрес доставки</div>

                <div class="block-form">
                  <input
                    type="text"
                    name="phpne"
                    class="set-input-data"
                    id="country"
                    placeholder=" "
                  />
                  <label for="country"> Страна </label>
                </div>

                <div class="flex-set-col">
                  <div class="col-block-set-form">
                    <div class="block-form">
                      <input
                        type="text"
                        name="phpne"
                        class="set-input-data"
                        id="postcode"
                        placeholder=" "
                      />
                      <label for="postcode">Индекс</label>
                    </div>
                    <div class="block-form">
                      <input
                        type="text"
                        name="phpne"
                        class="set-input-data"
                        id="city"
                        placeholder=" "
                      />
                      <label for="city">Город</label>
                    </div>
                  </div>

                  <div class="col-block-set-form">
                    <div class="block-form">
                      <input
                        type="text"
                        name="phpne"
                        class="set-input-data"
                        id="area"
                        placeholder=" "
                      />
                      <label for="area">Область</label>
                    </div>
                    <div class="block-form">
                      <input
                        type="text"
                        name="phpne"
                        class="set-input-data"
                        id="street"
                        placeholder=" "
                      />
                      <label for="street">Улица</label>
                    </div>
                  </div>
                </div>

                <div class="block-form">
                  <input
                    type="text"
                    name="house"
                    class="set-input-data"
                    id="house"
                    placeholder=" "
                  />
                  <label for="house">Дом, корпус, строение, квартира</label>
                </div>

                <div class="flex-set-trit-col">
                  <div class="block-form">
                    <input
                      type="text"
                      name="surname"
                      class="set-input-data"
                      id="surname"
                      placeholder=" "
                    />
                    <label for="surname">Фамилия</label>
                  </div>
                  <div class="block-form">
                    <input
                      type="text"
                      name="name"
                      class="set-input-data"
                      id="name"
                      placeholder=" "
                    />
                    <label for="name">Имя</label>
                  </div>
                  <div class="block-form">
                    <input
                      type="text"
                      name="lastname"
                      class="set-input-data"
                      id="lastname"
                      placeholder=" "
                    />
                    <label for="lastname">Отчество</label>
                  </div>
                </div>
                <div class="block-form text-area">
                  <textarea
                    name="comment"
                    id="comment"
                    cols="30"
                    rows="6"
                    placeholder=" "
                  ></textarea>

                  <label for="for">Комментарии к заказу</label>
                </div>

                <div class="set-end-block">
                  <a href="" class="back-cart"> Вернуться в корзину </a>
                  <a href="">Продолжить</a>
                </div>
              </div>
            </div>
          </div>
          <div class="left-block">
            <div class="cart-mini">
              <div class="title">Корзина</div>

              <div class="list-cart-pr">
                <div class="tovar-in-cart">
                  <div class="img-data">
                    <div
                      class="img"
                      style="
                        background-image: url(img/catalog/card-product-1.jpg);
                      "
                    ></div>
                  </div>
                  <div class="info-data">
                    <span class="tt-tovar"
                      >ANTI-CANDIDA + ANTI-PARASITE (КУРС ПОЛНОГО
                      ОЧИЩЕНИЯ)</span
                    >
                    <div class="rait">
                      <span class="star active"></span>
                      <span class="star active"></span>
                      <span class="star active"></span>
                      <span class="star active"></span>
                      <span class="star"></span>
                      <span class="count-commit">( 3 )</span>
                    </div>

                    <div class="prse-count">
                      <div class="pr-data">5 000 h <span>6000</span></div>
                      <div class="pr-count">
                        <span class="minus"
                          ><img src="/img/minus.svg" alt=""
                        /></span>
                        <input type="text" value="1" class="inp-count" />
                        <span class="plus"
                          ><img src="/img/plus.svg" alt=""
                        /></span>
                        <div class="delete-rs">
                          <svg
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M13 11V16M3 6H19L17.42 20.22C17.3658 20.7094 17.1331 21.1616 16.7663 21.49C16.3994 21.8184 15.9244 22 15.432 22H6.568C6.07564 22 5.60056 21.8184 5.23375 21.49C4.86693 21.1616 4.63416 20.7094 4.58 20.22L3 6ZM6.345 3.147C6.50675 2.80397 6.76271 2.514 7.083 2.31091C7.4033 2.10782 7.77474 2 8.154 2H13.846C14.2254 1.99981 14.5971 2.10755 14.9176 2.31064C15.2381 2.51374 15.4942 2.80381 15.656 3.147L17 6H5L6.345 3.147V3.147ZM1 6H21H1ZM9 11V16V11Z"
                              stroke="#8B8B8B"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tovar-in-cart">
                  <div class="img-data">
                    <div
                      class="img"
                      style="
                        background-image: url(img/catalog/card-product-1.jpg);
                      "
                    ></div>
                  </div>
                  <div class="info-data">
                    <span class="tt-tovar"
                      >ANTI-CANDIDA + ANTI-PARASITE (КУРС ПОЛНОГО
                      ОЧИЩЕНИЯ)</span
                    >
                    <div class="rait">
                      <span class="star active"></span>
                      <span class="star active"></span>
                      <span class="star active"></span>
                      <span class="star active"></span>
                      <span class="star"></span>
                      <span class="count-commit">( 3 )</span>
                    </div>

                    <div class="prse-count">
                      <div class="pr-data">5 000 h <span>6000</span></div>
                      <div class="pr-count">
                        <span class="minus"
                          ><img src="/img/minus.svg" alt=""
                        /></span>
                        <input type="text" value="1" class="inp-count" />
                        <span class="plus"
                          ><img src="/img/plus.svg" alt=""
                        /></span>
                        <div class="delete-rs">
                          <svg
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M13 11V16M3 6H19L17.42 20.22C17.3658 20.7094 17.1331 21.1616 16.7663 21.49C16.3994 21.8184 15.9244 22 15.432 22H6.568C6.07564 22 5.60056 21.8184 5.23375 21.49C4.86693 21.1616 4.63416 20.7094 4.58 20.22L3 6ZM6.345 3.147C6.50675 2.80397 6.76271 2.514 7.083 2.31091C7.4033 2.10782 7.77474 2 8.154 2H13.846C14.2254 1.99981 14.5971 2.10755 14.9176 2.31064C15.2381 2.51374 15.4942 2.80381 15.656 3.147L17 6H5L6.345 3.147V3.147ZM1 6H21H1ZM9 11V16V11Z"
                              stroke="#8B8B8B"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="best-products">
              <p class="products-title">Лучший выбор покупателей:</p>
              <div class="card-product">
                <div class="card-product__img">
                  <img
                    src="img/catalog/card-product-1.jpg"
                    alt=""
                    class="img img_fill"
                  />
                </div>
                <div class="card-product__desc">
                  <h5 class="card-product__title">
                    ANTI-CANDIDA + ANTI-PARASITE
                    <br />
                    (КУРС ПОЛНОГО ОЧИЩЕНИЯ)
                  </h5>
                  <div class="card-product__details flex-box">
                    <div class="card-product-details">
                      <div class="card-product__rating flex-box">
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star"></span>
                        <span>( 3 )</span>
                      </div>
                      <div class="card-product__price flex-box">
                        <span class="price-product"> 4 000 ₽ </span>
                        <span class="price-product price-product_old">
                          7 585 ₽
                        </span>
                      </div>
                    </div>
                    <button class="btn btn_card-product">В корзину</button>
                  </div>
                </div>
              </div>
              <div class="card-product">
                <div class="card-product__img">
                  <img
                    src="img/catalog/card-product-2.jpg"
                    alt=""
                    class="img img_fill"
                  />
                </div>
                <div class="card-product__desc">
                  <h5 class="card-product__title">
                    Тюбаж: Технология восстановления печени и желчного пузыря
                    (2023)
                  </h5>
                  <div class="card-product__details flex-box">
                    <div class="card-product-details">
                      <div class="card-product__rating flex-box">
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star"></span>
                        <span>( 3 )</span>
                      </div>
                      <div class="card-product__price flex-box">
                        <span class="price-product"> 250 ₽ </span>
                        <span class="price-product price-product_old">
                          550 ₽
                        </span>
                      </div>
                    </div>
                    <button class="btn btn_card-product">В корзину</button>
                  </div>
                </div>
              </div>
              <div class="card-product">
                <div class="card-product__img">
                  <img
                    src="img/catalog/card-product-3.jpg"
                    alt=""
                    class="img img_fill"
                  />
                </div>
                <div class="card-product__desc">
                  <h5 class="card-product__title">
                    ЗДОРОВЫЕ ВОЛОСЫ И КОЖА ГОЛОВЫ БЕЗ ГРИБКА
                  </h5>
                  <div class="card-product__details flex-box">
                    <div class="card-product-details">
                      <div class="card-product__rating flex-box">
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star"></span>
                        <span>( 3 )</span>
                      </div>
                      <div class="card-product__price">
                        <span class="price-product"> 3 000 ₽ </span>
                        <span class="price-product price-product_old"> </span>
                      </div>
                    </div>
                    <button class="btn btn_card-product">В корзину</button>
                  </div>
                </div>
              </div>
            </div> -->
            <div class="block-belay block-dealy-order">
              <p class="products-title products-title_belay">
                Приобретайте страховку, чтобы защитить свой товар на всех этапах
                доставки:
              </p>
              <div class="card-product">
                <div class="card-product__img">
                  <img
                    src="img/catalog/arcticons.svg"
                    alt=""
                    class="img img_fill"
                  />
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
                    <button
                      class="btn btn_card-product btn_card-product__belay"
                    >
                      Добавить
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-action">
              <div class="coypon">
                <div class="block-form">
                  <input
                    type="text"
                    name="coypon"
                    class="set-input-data"
                    id="coypon"
                    placeholder=" "
                  />
                  <label for="coypon"> Купон на скидку </label>
                </div>
                <div class="btn-add">
                  <a href="">Добавить</a>
                </div>
              </div>
              <div class="coypon">
                <div class="block-form">
                  <input
                    type="text"
                    name="promocode"
                    class="set-input-data"
                    id="promocode"
                    placeholder=" "
                  />
                  <label for="promocode"> Промокод </label>
                </div>
                <div class="btn-add">
                  <a href="">Добавить</a>
                </div>
              </div>

              <div class="block-form checkbox">
                <div class="chekbox">
                  <input type="checkbox" name="" id="" />
                  <label class="useCheckbox"
                    >Оформляя заказ, вы соглашаетесь с
                    <a href="">правилами возврата</a> и
                    <a href="">условиями обслуживания.</a></label
                  >
                </div>
              </div>

              <div class="block-form checkbox">
                <div class="chekbox">
                  <input type="checkbox" name="" id="" />
                  <label class="useCheckbox"
                    >Оформляя заказ, вы соглашаетесь с нашей
                    <a href=""> политикой конфиденциальности </a>, добровольно
                    предоставляете свои персональные данные для обработки заказа
                    и уведомлений.</label
                  >
                </div>
              </div>
              <div class="data-prom-user">
                <p>
                  Персональные данные, полученные из формы обратной связи
                  надежно хранятся в нашей базе данных в соответствии
                  <a href="">с действующим законодательством</a>.
                </p>
              </div>

              <div class="data-card-order-data">
                <ul>
                  <li><span>Товар</span><span>5 250 ₽</span></li>
                  <li><span>Доставка</span><span>0 ₽</span></li>
                  <li>
                    <span class="in-promo"
                      >Скидка по промокоду “natgard” (-10%) на товары из
                      категории “Пищевые добавки”:</span
                    ><span>-525 ₽</span>
                  </li>
                  <li class="final"><span>Итого</span> <span>4 725 ₽</span></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="btn-up"></button>
    </section>
    <!-- CRITERION -->
    <section class="criterion" id="criterion">
      <div class="container">
        <ul class="criterion-list">
          <li class="criterion-item">
            <h5>Правила Возврата</h5>
          </li>
          <li class="criterion-item">
            <h5>ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ</h5>
          </li>
          <li class="criterion-item">
            <h5>УСЛОВИЯ ОБСЛУЖИВАНИЯ</h5>
          </li>
        </ul>
      </div>
    </section>
    <script src="js/main.js"></script>
  </body>
</html>
