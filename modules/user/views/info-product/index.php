<?php
use app\models\Product;
use app\widgets\Raite;
use yii\bootstrap5\Modal;

?>
<div id="user_page">
    <div class="left_block">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'infoproduct'
        ]) ?>
    </div>
    <div class="right_block">
        <div class="breadcrambs">
            <ul>
                <li><a href="">Магазин</a></li>
                <li><a href="">Инфопродукты</a></li>
            </ul>
        </div>
        <div class="block-title-page">
            Инфопродукты
        </div>

        <?php foreach ($metaInfoProduct as $item): ?>
            <?php $product = $item->getProduct(); ?>
            <?php if (in_array($product->id, $listArray)) {
                $access = [
                    true,
                    "/img/Group 984.svg"
                ];
            } else {
                $access = [
                    false,
                    "/img/Лок.svg"
                ];
            } ?>
            <div class="element_info">
                <div class="block-img">
                    <div class="access_key">
                        <img src="<?= $access[1]; ?>" alt="">
                    </div>
                    <?php $image = $product->getImageProductList(); ?>
                    <?php if (!empty($image)): ?>
                        <?php if (isset($image['array'][array_key_first($image['array'])])): ?>
                            <img src="<?php echo $image['array'][array_key_first($image['array'])]['value'] ?>" alt="">
                        <?php endif; ?>
                    <?php else: ?>
                        <img src="/img/Rectangle 18.png" alt="">
                    <?php endif; ?>
                </div>
                <div class="block_data">
                    <?php
                    $prise = Product::priceData($product->id, $lang);
                    $meta = $product->arrayMeta();
                    ?>
                    <div class="title_info <?= ($access[0] ? 'open' : '') ?>">
                        <?= $meta['productName']; ?>
                    </div>
                    <div class="title_descript">
                        <?php if ($meta['description']): ?>
                            <?= $meta['description']; ?>
                        <?php endif; ?>
                    </div>

                    <div class="info_prise">
                        <div class="raite">
                            <?= Raite::widget(['id' => $product->id]); ?>
                        </div>
                        <div class="l-prise">
                            <div class="prise">
                                <?php if (isset($prise['summ']) && !empty($prise['summ'])): ?>
                                    <?php echo $prise['summ'] . " " . $prise['symbolCode']; ?>
                                    <s>
                                        <?php echo $prise['price'] . " " . $prise['symbolCode']; ?>
                                    </s>
                                <?php else: ?>
                                    <?php echo $prise['price'] . " " . $prise['symbolCode']; ?>
                                <?php endif; ?>
                            </div>
                            <div class="block_add_cart">
                                <?php if (!$access[0]): ?>
                                    <a href="/<?= $lang ?>/user/view/<?= $product->id ?>" class="view_product">Что входит в
                                        курс</a>
                                    <a href="#" class="stepr add-to-cart" data-cyrrency="<?= $lang ?>"
                                        data-id="<?= $product->id ?>" data-price="<?= $prise['price'] ?>"
                                        data-symbol="<?= $prise['symbolCode'] ?>">
                                        Купить
                                    </a>
                                <?php else: ?>
                                    <a href="/<?= $lang; ?>/user/info-product/<?= $meta['link'] ?>" class="stepr">Пройти</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>