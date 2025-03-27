<?php
use app\models\InfoStep;
use app\models\Product;
use app\widgets\Raite;
use yii\bootstrap5\Modal;

$shortName = $product->getParam('shortName', $lang);
?>
<main id="topBody">
    <section id="infoproduct_item">
        <div class="container">
            <?php echo $this->render('../components/left_menu_user.php', [
                'lang' => $lang,
                'active' => 'infoproduct'
            ]) ?>
            <div class="infoproducts__main item_infoproduct_in-stock">
                <div class="breadcrumbs">
                    <ul>
                        <li>
                            <a href="/<?= $lang; ?>/user/info-product">
                                <?= Yii::t('app', 'info-products') ?>
                            </a>
                        </li>
                        <li class="active">
                            <a href="#"><?= $shortName ?></a>
                        </li>
                    </ul>
                </div>
                <h1>
                    <?= $product->getParam('productName', $lang) ?>
                </h1>
                <div class="infoproduct_container">
                    <div class="infoproduct_container__img">
                        <div class="icon_stock">
                            <span><?= Yii::t('app', 'pay-info-t') ?></span>
                        </div>
                        <?php if (!empty($product->getParam('image', null))): ?>
                            <?php $image = json_decode($product->getParam('image', null), true) ?>
                            <?php if (isset($image['array'][array_key_first($image['array'])])): ?>
                                <div class="pre-view-info"
                                    style='background-image: url("<?php echo $image['array'][array_key_first($image['array'])]['value'] ?>")'>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="pre-view-info" style='background-image: url("/img/Rectangle 18.png")'></div>
                        <?php endif; ?>
                    </div>
                    <div class="infoproduct_container__description">
                        <?= $product->getParam('description', $lang) ?>
                    </div>
                </div>
                <div class="infoproduct_container__links">
                    <div class="container_link_in-stock">
                        <a href="/ru/user/feedback" class="container_link-question" data-set-link="https://anticandida.com/ru/user/feedback"><?= Yii::t('app', 'asc-quest') ?></a>
                        <a href="https://t.me/anticandida_ru" target="_blank"><?= Yii::t('app', 'chat-tl') ?></a>

                    </div>
                    <div class="container_link_no-stock dab_stock">
                        <a href="<?= Yii::t('app', 'tel-bot-link')?>" target="_blank">
                            <?= Yii::t('app', 'telegram-message') ?></a>
                    </div>
                </div>
                <div class="infoproduct__list-modules">
                        <?php foreach ($infoCategory as $step): ?>
                            <?php echo $this->render('tables-category', [
                                'step' => $step,
                                'lang' => $lang
                            ])?>
                        <?php endforeach; ?>
                </div>
                <p class="time_course_limit">
                    <?php if ($date_end): ?>
                        <?= Yii::t('app', 'the-course-is-active-until') ?>
                        <?= $date_end ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </section>
</main>
<script>
    var h2 = document.getElementById('pageSetBody').offsetHeight;
    parent.postMessage({
        heInfoproduct: h2,
    }, '*');
</script>
<?php $this->registerJs('
// $(document).on("click", ".referInfoc", function(e){
//     e.preventDefault();
//     var dataLink = $(this).data("link");
//     parent.postMessage({
//         linkData : dataLink,
//     }, "*");
// })
') ?>