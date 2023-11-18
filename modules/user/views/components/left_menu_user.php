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
            <a href="#">Личные данные</a>
        </li>
        <li>
            <a href="#">История заказов</a>
        </li>
        <li class="inf_menu-has_child">
            <a href="#">Партнер</a>
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
            <a href="#">Мои бонусы</a>
        </li>
        <li>
            <a href="#">Обратная связь</a>
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