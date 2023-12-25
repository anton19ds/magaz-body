<?php foreach($userPromo as $item):?>
    
            

<div class="promocodes__item">
    <div class="promocode__top">
        <div>
            <div>
                <p class="promocode_question">
                    <img src="/asset/images/question.svg" alt="">
                    <span>Совокупность букв и цифр, дающая покупателям скидку в магазине и % отчисления
                        партнёру с их покупок.Рекомендация: не используйте в качестве промокода
                        случайный набор символов. Задайте какое-нибудь слово, связаное с тематикой
                        сайта, чтобы “замаскировать” вашу ссылку.
                    </span>
                </p>
                <p>
                    <span class="bold">Промокод: <span class="promocode_name">6noby29vdc198zg3hois</span></span>
                </p>
            </div>
        </div>
        <div>
            <div>
                <p class="promocode_question">
                    <img src="/asset/images/question.svg" alt="">
                    <span>Так будет выглядеть ваша партнёрская ссылка со “вшитым” в неё промокодом. При
                        переходе пользователей по данной ссылке, промокод учитывается автоматически и
                        будет действовать при всех последующих заходах клиентов на сайт. Следовательно,
                        если они решат совершить покупки - вы получите % вознаграждение.
                    </span>
                </p>
                <p>
                    <span class="bold">Реф. ссылка:</span>
                    <?php //"http" . ($_SERVER['HTTPS'] ?? '') . "://" . $_SERVER['HTTP_HOST']?>
                    <span class="ref_link">/<?= $lang?>/p/<span>6noby29vdc198zg3hois</span></span>
                    <span class="copy_icon">
                        <img src="/asset/images/copy.svg" alt="">
                        <span class="yes_copied">Скопировано</span>
                    </span>
                </p>
            </div>
            <div>
                <p class="promocode_question">
                    <img src="/asset/images/question.svg" alt="">
                    <span>Введите в это поле url любой страницы сайта, на которую вы хотите направлять
                        пользователей.Например: просто на главную страницу сайта “body-balance.com/ru”
                        или страницу магазина “body-balance.com/ru/shop”. При переходе по вашей
                        реферальной ссылке пользователи будут попадать на заданную вами страницу. Совет:
                        тщательно выбирайте страницу, это будет первое что увидят ваши клиенты.
                    </span>
                </p>
                <p>
                    <span class="bold">Целевая ссылка:</span>
                    <span class="targ_link">body-balance.com<span>/<?= $lang?>/</span></span>
                </p>
            </div>
        </div>
    </div>
    <div class="table_promocodes">
        <div class="table_promocodes__head">
            <div class="promocode_line">

                <p class="tovar_group">
                    <span class="promocode_question">
                        <span>Разные группы товаров имеют разный % вознаграждения.</span>
                    </span>
                    <span class="promocode_line__title">Товарные группы</span>
                </p>
                <p class="sale_client">
                    <span class="promocode_question">
                        <img src="/asset/images/question.svg" alt="">
                        <span>Задайте процент скидки которую получит пользователь, перейдя по вашей

                            партнёрской ссылке. “Скидка покупателю” = “Сумма” - “Ваш процент”</span>
                    </span>
                    <span class="promocode_line__title">Скидка клиенту (по промокоду)</span>
                </p>
                <p class="rewards_buy">
                    <span class="promocode_question">
                        <img src="/asset/images/question.svg" alt="">
                        <span>Задайте процент вашего личного вознаграждения. “Ваш процент” = “Сумма” - “Скидка
                            покупателю”</span>

                    </span>
                    <span class="promocode_line__title">Вознаграждение за покупки привлеченных вами
                        клиентов</span>
                </p>
                <p class="summ_percent">
                    <span class="promocode_question">
                        <img src="/asset/images/question.svg" alt="">
                        <span>Общий процент от стоимости продукта выделенный лично вам администрацией. “Сумма” = “Ваш
                            процент” + “Скидка покупателю”. Вы можете назначить скидку для вашей аудитории и собственное
                            вознагражение по своему усмотрению.</span>
                    </span>
                    <span class="promocode_line__title">Сумма процентов</span>
                </p>
            </div>
        </div>
        <div class="table_promocodes__body">
            <div class="promocode_line">
                <p class="tovar_group">Физические товары</p>
                <p class="sale_client">3%</p>
                <p class="rewards_buy">10%</p>
                <p class="summ_percent">13%</p>
            </div>
            <div class="promocode_line">
                <p class="tovar_group">Инфопродукты</p>
                <p class="sale_client">3%</p>
                <p class="rewards_buy">10%</p>
                <p class="summ_percent">13%</p>
            </div>

            <div class="promocode_line">
                <p class="tovar_group">Мед. услуги</p>
                <p class="sale_client">3%</p>
                <p class="rewards_buy">10%</p>
                <p class="summ_percent">13%</p>
            </div>
        </div>

    </div>
</div>
<?php endforeach;?>