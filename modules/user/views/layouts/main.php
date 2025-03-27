<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\UserAsset;
use app\widgets\Alert;
use app\widgets\Cart;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use Yii;

UserAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <style>
        @font-face {
            font-family: Stem;
            src: url(/steams/Stem-Regular.eot);
            src: local(Stem), url(/steams/Stem-Regular.eot?#iefix) format("embedded-opentype"), url(/steams/Stem-Regular.woff) format("woff"), url(/steams/Stem-Regular.ttf) format("truetype");
            font-weight: 400;
            font-style: normal
        }

        @font-face {
            font-family: Stem;
            src: url(/steams/Stem-Medium.eot);
            src: local(Stem), url(/steams/Stem-Medium.eot?#iefix) format("embedded-opentype"), url(/steams/Stem-Medium.woff) format("woff"), url(/steams/Stem-Medium.ttf) format("truetype");
            font-weight: 500;
            font-style: normal
        }

        @font-face {
            font-family: Stem;
            src: url(/steams/Stem-Bold.eot);
            src: local(Stem), url(/steams/Stem-Bold.eot?#iefix) format("embedded-opentype"), url(/steams/Stem-Bold.woff) format("woff"), url(/steams/Stem-Bold.ttf) format("truetype");
            font-weight: 700;
            font-style: normal
        }

        @font-face {
            font-family: Stem;
            src: url(/steams/Stem-Light.eot);
            src: local(Stem), url(/steams/Stem-Light.eot?#iefix) format("embedded-opentype"), url(/steams/Stem-Light.woff) format("woff"), url(/steams/Stem-Light.ttf) format("truetype");
            font-weight: 300;
            font-style: normal
        }

        * {
            font-family: 'Stem' !important;
        }
    </style>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <?php $this->head() ?>
</head>

<body id="pageSetBody">
    <?php $this->beginBody() ?>
    <input type="hidden" value="<?= Yii::$app->request->get()['lang'] ?>" id="tagLang">

    <header class="pers_account">
        <?= $this->render('block-mob-menu', [
            'lang' => Yii::$app->request->get()['lang']
        ]) ?>

    </header>
    <!-- <a href="#" class="open-cart"><img src="/icon/cart.svg" alt=""></a> -->
    <?= $content ?>
    <?php
    if (!Yii::$app->user->isGuest) {
        //echo Yii::$app->user->identity->username;
    } else {
        // echo 'guest';
    }
    ?>

    <?= Cart::widget(['lang' => Yii::$app->request->get()['lang']]) ?>
    <!-- <div class="template-alert">
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
    </div> -->
    <!-- newuser -->

<?php 
$request = Yii::$app->request->get();
if(isset($request['newuser']) && $request['newuser']):
?>

<script>

</script>
<?php $this->registerJs('
var top = 350;
window.addEventListener("message", function (e) {
top = top + e.data.top;
});
$(".newuser_popup").css("top", top);
')?>
    <div class="asdf" style="display:block"></div>
    <div class="popup newuser_popup" style="display:block">
        <p class="title_popup">
            ВАША УЧЕТНАЯ ЗАПИСЬ НА ПОРТАЛЕ "АНТИКАНДИДА" БЫЛА СОЗДАНА!
        </p>
        <p>Ваш логин: <?= Yii::$app->user->identity->email; ?></p>
        <p class="description_popup">
            Пароль был сгенерирован автоматически и отправлен на ваш почтовый ящик. Если вы не получили письмо с
            паролем, то проверьте папку спам. В личном кабинете вы можете изменить пароль.
        </p>
        <p>
            <span class="gelt-det">Понятно</span>
        </p>
    </div>
<?php endif;?>

















    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>