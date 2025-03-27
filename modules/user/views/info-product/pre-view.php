<?php
use app\models\Product;
use app\widgets\Raite;
use yii\bootstrap5\Modal;

$prise = Product::priceData($model['id'], $lang);
$name = $model->getParam('productName', $lang);
$description = $model->getParam('description', $lang);
$image = $model->getParam('image', null);
$shortName = $model->getParam('shortName', $lang);
?>
<main id="topBody">
    <section id="infoproduct_item">
        <div class="container">
            <?php echo $this->render('../components/left_menu_user.php', [
                'lang' => $lang,
                'active' => 'infoproduct'
            ]) ?>
            <div class="infoproducts__main item_infoproduct_no-stock">
                <div class="breadcrumbs">
                    <ul>
                        <li>
                            <a href="/<?= $lang;?>/user/info-product" class="referInfoc" data-link="/<?= $lang;?>/user/info-product">
                                <?= Yii::t('app', 'info-products')?>
                            </a>
                        </li>
                        <li class="active">
                            <a href="#"><?= $shortName ?></a>
                        </li>
                    </ul>
                </div>
                <h1>
                    <?= $name ?>
                </h1>
                <div class="infoproduct_container">
                    <div class="infoproduct_container__img">
                        <div class="icon_stock">
                            <span>
                            <?= Yii::t('app', 'accsess-ok')?>
                            </span>
                        </div>
                        <?php if (!empty($image)): ?>
                            <?php $image = json_decode($image, true) ?>
                            <?php if (isset($image['array'][array_key_first($image['array'])])): ?>
                                <div class="pre-view-info" style='background-image: url("<?php echo $image['array'][array_key_first($image['array'])]['value'] ?>")'></div>
                            <?php endif; ?>

                        <?php else: ?>
                            <div class="pre-view-info" style='background-image: url("/img/Rectangle 18.png")'></div>
                        <?php endif; ?>
                    </div>
                    <div class="infoproduct_container__description">
                        <?= $description ?>
                    </div>
                </div>
                <div class="infoproduct_container__links">
                    <div class="container_link_in-stock">
                        <a href="#" class="container_link-question"><?= Yii::t('app', 'asc-quest')?></a>
                        <a href="#"><?= Yii::t('app', 'asc-quest-telega')?></a>
                    </div>
                    <div class="container_link_no-stock dab_stock">
                        <a href="#" class="add-to-cart" data-count="1" data-cyrrency="<?= $lang ?>" data-id="<?= $model->id ?>"
                            data-price="<?= $prise['price']; ?>" data-symbol="<?= $prise['symbolCode']; ?>">
                            <?= Yii::t('app', 'pay-curs')?>
                        </a>
                    </div>
                </div>
                <div class="infoproduct__list-modules">
                    <?php $i = 0; ?>
                    <?php foreach ($infoCategory as $step): ?>
                        <?= $this->render('view-step', [
                            'step' => $step,
                            'model' => $model,
                            'i' => $i,
                            'lang' => $lang
                        ])?>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </div>
                <p class="time_course_limit">
                    <?php $dataActive = $model->getParam('date-info', null); ?>
                    <?php if ($dataActive): ?>
                        <?= Yii::t('app', 'the-course-is-active-col-dey') ?> <?= $dataActive ?> <?= Yii::t('app', 'day-s')?>
                    <?php endif; ?>
                </p>
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
<?php $this->registerJs('
$(document).on("click", ".referInfoc", function(e){
    e.preventDefault();
    var dataLink = $(this).data("link");
    parent.postMessage({
        linkData : dataLink,
    }, "*");
})
')?>