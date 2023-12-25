<div class="popup exit-lk">
    <div class="close_popup close_popup_svg">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <g clip-path="url(#clip0_1158_108032)">
                <path
                    d="M11.1049 10L19.7712 1.33372C20.0763 1.0286 20.0763 0.533915 19.7712 0.228837C19.4661 -0.0762401 18.9714 -0.0762791 18.6663 0.228837L9.99999 8.89515L1.33372 0.228837C1.0286 -0.0762791 0.533915 -0.0762791 0.228837 0.228837C-0.0762401 0.533954 -0.0762792 1.02864 0.228837 1.33372L8.89511 9.99999L0.228837 18.6663C-0.0762792 18.9714 -0.0762792 19.4661 0.228837 19.7712C0.381376 19.9237 0.581337 20 0.781297 20C0.981258 20 1.18118 19.9237 1.33376 19.7712L9.99999 11.1049L18.6663 19.7712C18.8188 19.9237 19.0188 20 19.2187 20C19.4187 20 19.6186 19.9237 19.7712 19.7712C20.0763 19.4661 20.0763 18.9714 19.7712 18.6663L11.1049 10Z"
                    fill="black" />
            </g>
            <defs>
                <clipPath id="clip0_1158_108032">
                    <rect width="20" height="20" fill="white" />
                </clipPath>
            </defs>
        </svg>
    </div>
    <p class="title_popup">
        Вы действительно хотите выйти?
    </p>
    <div class="links_exit">
        <a href="list-infoproducts.html">Да</a>
        <a class="close_popup" href="#">Нет</a>
    </div>
</div>

<div class="infoproducts__menu">
    <div class="inf_menu__welcome">
        <span>Welcome</span>
        <?= Yii::$app->user->identity->email; ?>
    </div>
    <ul>
        <li>
            <a href="/<?= $lang; ?>/user/info-product"
                class="<?= ($active == 'infoproduct' ? 'active' : '') ?>">Инфопродукты</a>
        </li>
        <li>
            <a href="/<?= $lang; ?>/user/info"
            class="<?= ($active == 'info' ? 'active' : '') ?>">Личные данные</a>
        </li>
        <li>
            <a href="/<?= $lang?>/user"
            class="<?= ($active == 'history' ? 'active' : '') ?>">История заказов</a>
        </li>
        <li class="inf_menu-has_child">
            <a href="/<?= $lang?>/user/affiliate-program">Партнер</a>
            <ul>
                <li>
                    <a href="#">Промокоды</a>
                </li>
                <li>
                    <a href="#">Аналитика</a>
                </li>
                <li>
                    <a href="#">Отчеты</a>
                </li>
                <li>
                    <a href="#">Ваш баланс</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="/<?= $lang?>/user/bonus">Мои бонусы</a>
        </li>
        <li>
            <a href="/<?= $lang?>/user/feedback">Обратная связь</a>
        </li>
        <li class="inf_menu__exit">
            <a href="#">Выход</a>
        </li>
    </ul>
</div>


<?php $this->registerJs('
// var punckt = "' . $active . '";
// $("#menuUser a").each(function(e){
//     if($(this).data("id") == punckt){
//         $(this).addClass("active");
//     }
// })
'); ?>


<style>
    .infoproducts__menu>ul>li>a.active {
        background: #23B7D1;
        color: #fff;
        font-weight: 400;
    }

    .inf_menu__exit:hover {
        background: transparent;
    }

    .infoproducts__menu > ul > li.inf_menu__exit > a:hover {
        background: transparent !important;
        text-decoration: underline;
        color: #23B7D1 !important;
    }
</style>