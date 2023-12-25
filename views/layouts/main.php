<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;

use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;


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
    <?php $this->beginBody() ?>
    <input type="hidden" value="<?= Yii::$app->request->get()['lang'] ?>" id="tagLang">
    <div class="info-line">
        <div class="center-block">
            <span class="icon01">30-ДНЕВНАЯ ГАРАНТИЯ <s>ВОЗВРАТА ДЕНЕГ</s></span>
            <span class="icon02"> служба поддержки: <s>8-900-565-5005 - INFO@BODY-BALANCE.COM </s></span>
        </div>
    </div>


    <?= $content ?>

    <?php
    if (!Yii::$app->user->isGuest) {
        //echo Yii::$app->user->identity->username;
    } else {
        // echo 'guest';
    }
    ?>




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