<?php $priceData = Product::getPriceProductbyId($item['id'], $lang); ?>
<?php if (in_array($item['id'], $listArray)) {
    $access = [
        'infoproduct_in_stock',
        true,
    ];
} else {
    $access = [
        'infoproduct_no_stock',
        false
    ];
} ?>
<div class="list-infoproducts__item <?= $access[0] ?>">
    <div class="infoproduct_img">
        <div class="icon_has_stock"></div>
        <?php if (!empty($item['productMeta']['image'])): ?>
            <?php $image = json_decode($item['productMeta']['image'], true) ?>
            <?php if (isset($image['array'][array_key_first($image['array'])])): ?>
                <img src="<?php echo $image['array'][array_key_first($image['array'])]['value'] ?>" alt="">
            <?php endif; ?>

        <?php else: ?>
            <img src="/img/Rectangle 18.png" alt="">
        <?php endif; ?>
    </div>
    <div class="infoproduct_content">
        <h3>
            <?= $item['productMeta']['productName'] ?>
        </h3>
        <p class="description_infoproduct">
            <?= $item['productMeta']['description'] ?>
        </p>
        <div class="rate-time_infoproduct">
            <div class="data-raite">
                <?php echo Raite::widget(['id' => $item['id']]); ?>
            </div>
            <p class="infoproduct_time">
                Курс активен до: 14.06.2022
            </p>
        </div>
        <div class="price-buttons_infoproduct">
            <?php if (!$access[1]): ?>
                <p class="price_infoproduct">
                    <?php if (isset($priceData['summ']) && !empty($priceData['summ'])): ?>
                        <?php echo number_format($priceData['summ'], 0, '', ' ') . " " . $priceData['symbolCode']; ?>
                        <span class="sale-price_infoproduct">
                            <?php echo number_format($priceData['price'], 0, '', ' ') . " " . $priceData['symbolCode']; ?>
                        </span>
                    <?php else: ?>
                        <?php echo number_format($priceData['price'], 0, '', ' ') . " " . $priceData['symbolCode']; ?>
                    <?php endif; ?>
                </p>
                <div class="buttons_infoproduct">
                    <a href="/<?= $lang ?>/user/view/<?= $item['id'] ?>" class="view_product">Что
                        входит в
                        курс?</a>
                    <a href="#" class="stepr add-to-cart" data-cyrrency="<?= $lang ?>" data-id="<?= $item['id'] ?>"
                        data-price="" data-symbol="" data-count="1">Купить подписку</a>
                </div>
            <?php else: ?>
                <div class="buttons_infoproduct">
                    <a href="/<?= $lang ?>/user/info-product/<?= $item['id'] ?>" class="view_product">Что
                        входит в
                        курс?</a>
                    <a href="/<?= $lang; ?>/user/info-product/list/<?= $item['id'] ?>">Смотреть</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>