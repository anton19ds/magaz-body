<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Cart;
use yii\bootstrap5\Html;


AppAsset::register($this);
$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody();
    $lang = Yii::$app->request->get()['lang'];
    ?>
    <input type="hidden" value="<?= $lang; ?>" id="tagLang">
    <div class="info-line">
        <div class="center-block">
            <span class="icon01">30-ДНЕВНАЯ ГАРАНТИЯ <s>ВОЗВРАТА ДЕНЕГ</s></span>
            <span class="icon02"> служба поддержки: <s>8-900-565-5005 - INFO@BODY-BALANCE.COM </s></span>
        </div>
    </div>
    <section class="section-basket" id="section-basket">
        <div class="container">
            <div class="block-wrapper">
                <div class="basket">
                    <div class="basket-logo">
                        <a href="/<?= $lang ?>" style="display: block;">
                            <img src="/img/basket-logo.svg" alt="BODEY BALANCE" />
                        </a>
                    </div>
                    <nav class="basket-nav">
                        <ul class="basket-nav__list flex-box">
                            <li class="basket-nav__item active" data-step="1" data-url="/<?= $lang ?>/cart">
                                <a href="/<?= $lang ?>/cart">Корзина</a>
                                <svg class="basket-nav__icon" xmlns="http://www.w3.org/2000/svg" width="6" height="10"
                                    viewBox="0 0 6 10" fill="none">
                                    <path d="M1 1L5 5L1 9" />
                                </svg>
                            </li>
                            <li class="basket-nav__item" data-list="contact-data" data-step="2" data-url="/<?= $lang ?>/order">
                                <a href="/<?= $lang ?>/order">Контактная информация</a>
                                <svg class="basket-nav__icon" xmlns="http://www.w3.org/2000/svg" width="6" height="10"
                                    viewBox="0 0 6 10" fill="none">
                                    <path d="M1 1L5 5L1 9" />
                                </svg>
                            </li>
                            <li class="basket-nav__item" data-step="3" data-url="/<?= $lang ?>/delivery">
                                <a href="/<?= $lang ?>/delivery">Способ доставки</a>
                                <svg class="basket-nav__icon" xmlns="http://www.w3.org/2000/svg" width="6" height="10"
                                    viewBox="0 0 6 10" fill="none">
                                    <path d="M1 1L5 5L1 9" />
                                </svg>
                            </li>
                            <li class="basket-nav__item" data-step="4" data-url="/<?= $lang ?>/payment">
                                <a href="/<?= $lang ?>/payment">Способ оплаты</a>
                            </li>
                        </ul>
                    </nav>
                    <?= $content ?>
                </div>
            </div>
    </section>


    <div class="template-alert">
        <div class="template-header">
            <div class="text-template"><span>!</span> Ошибка</div>
            <span class="close-tmp">
            <img src="/img/close (1).svg" alt="">
            </span>
        </div>
        <div class="template-body">
            <p class="tm-data">
                Инфокурс уже у вас в корзине
            </p>
        </div>
    </div>

    
    <a href="#" class="open-cart"><img src="/icon/cart.svg" alt=""></a>
    <a href="/<?= Yii::$app->request->get()['lang'] ?>/user">user</a>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>