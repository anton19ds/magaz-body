<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use app\widgets\Cart;
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

    <style>
        @font-face {
            font-family: Stem;
            src: url("/stem/Stem-Light.eot");
            src: local("Stem Light"), local("Stem-Light"),
                url("stem/Stem-Light.eot?#iefix") format("embedded-opentype"),
                url("/stem/Stem-Light.woff2") format("woff2"),
                url("/stem/Stem-Light.woff") format("woff"),
                url("/stem/Stem-Light.ttf") format("truetype");
            font-weight: 300;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: Stem;
            src: url("/stem/Stem-Medium.eot");
            src: local("Stem Medium"), local("Stem-Medium"),
                url("/stem/Stem-Medium.eot?#iefix") format("embedded-opentype"),
                url("/stem/Stem-Medium.woff2") format("woff2"),
                url("/stem/Stem-Medium.woff") format("woff"),
                url("/stem/Stem-Medium.ttf") format("truetype");
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: Stem;
            src: url("stem/Stem-Bold.eot");
            src: local("Stem Bold"), local("Stem-Bold"),
                url("stem/Stem-Bold.eot?#iefix") format("embedded-opentype"),
                url("stem/Stem-Bold.woff2") format("woff2"),
                url("/stem/Stem-Bold.woff") format("woff"),
                url("/stem/Stem-Bold.ttf") format("truetype");
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: Stem;
            src: url("stem/Stem-SemiLight.eot");
            src: local("Stem Semi Light"), local("Stem-SemiLight"),
                url("/stem/Stem-SemiLight.eot?#iefix") format("embedded-opentype"),
                url("/stem/Stem-SemiLight.woff2") format("woff2"),
                url("/stem/Stem-SemiLight.woff") format("woff"),
                url("/stem/Stem-SemiLight.ttf") format("truetype");
            font-weight: 300;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: Stem;
            src: url("stem/Stem-ExtraLight.eot");
            src: local("Stem Extra Light"), local("Stem-ExtraLight"),
                url("/stem/Stem-ExtraLight.eot?#iefix") format("embedded-opentype"),
                url("/stem/Stem-ExtraLight.woff2") format("woff2"),
                url("/stem/Stem-ExtraLight.woff") format("woff"),
                url("/stem/Stem-ExtraLight.ttf") format("truetype");
            font-weight: 200;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: Stem;
            src: url("stem/Stem-Thin.eot");
            src: local("Stem Thin"), local("Stem-Thin"),
                url("/stem/Stem-Thin.eot?#iefix") format("embedded-opentype"),
                url("/stem/Stem-Thin.woff2") format("woff2"),
                url("/stem/Stem-Thin.woff") format("woff"),
                url("/stem/Stem-Thin.ttf") format("truetype");
            font-weight: 100;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: Stem;
            src: url("stem/Stem-Regular.eot");
            src: local("Stem Regular"), local("Stem-Regular"),
                url("/stem/Stem-Regular.eot?#iefix") format("embedded-opentype"),
                url("/stem/Stem-Regular.woff2") format("woff2"),
                url("/stem/Stem-Regular.woff") format("woff"),
                url("/stem/Stem-Regular.ttf") format("truetype");
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: Stem;
            src: url("stem/Stem-Regular.eot");
            src: local("Stem"),
                url("/stem/Stem-Regular.eot?#iefix") format("embedded-opentype"),
                url("/stem/Stem-Regular.woff") format("woff"),
                url("/stem/Stem-Regular.ttf") format("truetype");
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        * {
            font-family: Stem, serif;
        }
    </style>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <input type="hidden" value="<?= Yii::$app->request->get()['lang']?>" id="tagLang">
    <div class="info-line">
        <div class="center-block">
            <span class="icon01">30-ДНЕВНАЯ ГАРАНТИЯ  <s>ВОЗВРАТА ДЕНЕГ</s></span>
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

<?= Cart::widget(['lang' => Yii::$app->request->get()['lang']])?>


<a href="#" class="open-cart"><img src="/icon/cart.svg" alt=""></a>
    <a href="/<?= Yii::$app->request->get()['lang']?>/user" >user</a>
    <a href="/cs">cs</a>
    <a href="/ru">ru</a>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>