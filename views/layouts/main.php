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
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>