<?php
use app\models\InfoStep;
use app\models\Product;
use yii\bootstrap5\Modal;
?>
<main>
    <section id="list-lessons">
        <div class="container">
            <?php echo $this->render('../components/left_menu_user.php', [
                'lang' => $lang,
                'active' => 'infoproduct'
            ]) ?>
            <div class="infoproducts__main">
                <div class="breadcrumbs">
                    
                    <ul>
                        <li>
                            <a class="referInfoc" href="https://anticandida.com/<?= $lang;?>/user/info-product" data-link="/<?= $lang;?>/user/info-product">
                                <?= Yii::t('app', 'info-products')?>
                            </a>
                        </li>
                        <li>
                            <a class="referInfoc" href="https://anticandida.com/<?= $lang;?>/user/info-product/<?= $product->getParam('link', $lang); ?>" data-link="/<?= $lang;?>/user/info-product/<?= $product->getParam('link', $lang); ?>">
                                <?= $product->getParam('shortName', $lang); ?>
                            </a>
                        </li>
                        <li class="active">
                            <a href="#">
                                <?= mb_strimwidth($category->title, 0, 30, "..."); ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <h1>
                    <?= $product->getParam('productName', $lang) ?>
                </h1>
                <div class="list_lessons">
                    <?php $keyS = 0; ?>
                        <?php foreach ($infoStep as $key => $item): ?>
                            <?php
                            echo $this->render('active-step', [
                                'item' => $item,
                                'lang' => $lang,
                                'product_link' => $product_link,
                                'order' => $order,
                                'dataProduct' => $dataProduct,
                            ]);
                            ?>
                        <?php endforeach; ?>
                </div>
                <a href="https://anticandida.com/<?= $lang;?>/user/info-product/<?= $product->getParam('link', $lang); ?>" class="link-main-page-infockurs referInfoc" data-link="/<?= $lang;?>/user/info-product/<?= $product->getParam('link', $lang); ?>"><?= Yii::t('app', 'main-page-infoproduct')?></a>
            </div>
        </div>
    </section>
</main>
<script>
        var h2 = document.getElementById('pageSetBody').offsetHeight;
        parent.postMessage({
            heInfoproduct : h2,
        }, '*');
</script>
<style>
    .lesson_disabled.view .lesson_course__arrow img,
    .lesson_expectation.view .lesson_course__arrow img {
    transform: rotate(0deg);
    }
    .lesson_disabled.view .lesson_course__arrow img{
    transform: rotate(-90deg);
    }
</style>
<?php $this->registerJs('
$(document).on("click", ".referInfoc", function(e){
    e.preventDefault();
    var dataLink = $(this).data("link");
    parent.postMessage({
        linkData : dataLink,
    }, "*");
})
')?>