<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\FrontAssets;
use yii\helpers\Html;

FrontAssets::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
//$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
//$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <link rel="icon" href="https://anticandida.com/gallery/icons/favicon/anticandida-favicon.png" sizes="32x32">
    <link rel="icon" href="https://anticandida.com/gallery/icons/favicon/anticandida-favicon.png" sizes="192x192">
    <link rel="apple-touch-icon" href="https://anticandida.com/gallery/icons/favicon/anticandida-favicon.png">
    <meta name="msapplication-TileImage" content="https://anticandida.com/gallery/icons/favicon/anticandida-favicon.png">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <?php $this->head() ?>
</head>

<body id="topBody">
    <?php $this->beginBody() ?>
    <input type="hidden" value="<?= Yii::$app->request->get()['lang'] ?>" id="tagLang">
    <?= $content ?>
    

    <div class="template-alert">
        <p class="tm-data">

        </p>
    </div>

    <style>
        .template-alert {
            position: fixed;
            left: -100%;
            background: #fff;
            padding: 18px;
            top: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 20px 0 #00000026;
            transition: all 0.5s ease;
            border: 1px solid red;
        }

        .tm-data {
            font-weight: 500;
        }
    </style>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>