<div class="pers_account__menu">
    <div class="pers_acc_menu__header">
        <p>Меню личного кабинета
            <img src="/asset/images/arrow_bottom_lk.svg" alt="">
        </p>
        <p class="pers_acc_menu_header__button">
            Показать
        </p>
    </div>
    <div class="pers_acc_menu__list">
        <ul class="list-meu0offset">
            <li>
                <a href="/<?= $lang; ?>/user/info-product">
                    <img src="/asset/images/menu_ico_personal-infopr.svg" alt="">
                    <?= Yii::t('app', 'info-products') ?>
                </a>
            </li>
            <li>
                <a href="/<?= $lang; ?>/user/info">
                    <img src="/asset/images/personal-information.svg" alt="">
                    <?= Yii::t('app', 'user-information') ?>
                </a>
            </li>
            <li>
                <a href="/<?= $lang ?>/user/order">
                    <img src="/asset/images/exam.svg" alt="">
                    <?= Yii::t('app', 'history-orders') ?>
                </a>
            </li>
            <li class="acc_menu_li-has-child">
                <a href="/<?= $lang ?>/user/affiliate-program">
                    <img src="/asset/images/collaboration.svg" alt="">
                    <?= Yii::t('app', "partners") ?>
                </a>
                <ul>
                    <li>
                        <a href="/<?= $lang ?>/user/affiliate-program"><?= Yii::t('app', 'menu-promo') ?></a>
                    </li>
                    <li>
                        <a href="/<?= $lang ?>/user/analytics" ><?= Yii::t('app', 'analytics') ?></a>
                    </li>
                    <li>
                        <a href="/<?= $lang ?>/user/report"><?= Yii::t('app', "report") ?></a>
                    </li>
                    <li>
                        <a href="/<?= $lang ?>/user/balance"><?= Yii::t('app', "your-balance") ?></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/<?= $lang ?>/user/bonus">
                    <img src="/asset/images/gift.svg" alt="">
                    <?= Yii::t('app', 'my-bonuses') ?>
                </a>
            </li>
            <li>
                <a href="/<?= $lang ?>/user/feedback">
                    <img src="/asset/images/call.svg" alt="">
                    <?= Yii::t('app', 'feedback') ?>
                </a>
            </li>
        </ul>
        <a href="#" class="a_exit_menu">Выйти</a>
    </div>
</div>



<?php $this->registerJs('
$(document).on("click", ".list-meu0offset a", function(e){
    e.preventDefault();
    var linkData = $(this).attr("href");
    parent.postMessage({
        linkData : linkData,
        path: document.location.pathname,
    }, "*");
});
');?>