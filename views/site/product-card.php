<?php

use app\models\Product;
use app\models\Translations;
use app\widgets\Raite;

$priceData = Product::getPriceProductbyId($item['id'], $currency);
?>

<?php if ( $item['productMeta']['type'] == "info" || $item['col'] > 0): ?>
    <div class="card">
        <?php if (isset($item['productMeta']['type']) && $item['productMeta']['type'] == "info"): ?>
            <span class="card-sale card-sale_fill">
                Инфо продукт
            </span>
        <?php else: ?>
            <?php if (isset($item['sale']) && !empty($item['sale'])): ?>
                <span class="card-sale">
                    Скидка
                    <?php if (stristr($item['sale'], '%')): ?>
                        <?= $item['sale'] ?>%
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        <?php endif; ?>
        <div class="card-img">
            <?php if (!empty($item['productMeta']['image'])): ?>
                <?php $photoData = json_decode($item['productMeta']['image'], true); ?>
                <?php foreach ($photoData as $elem): ?>
                    <?php foreach ($elem as $photo): ?>
                        <img src="<?= $photo['value'] ?>" alt="" class="img">
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <img src="/adminStyle/assets/img/no-image.png" alt="" class="img">
            <?php endif; ?>
        </div>
        <div class="card-desc">
            <h3 class="card-desc__title">
                <a href="/<?= $currency ?>/<?= $item['productMeta']['link']; ?>">
                    <?= mb_substr($item['productMeta']['productName'], 0, 70, 'UTF-8'); ?>
                </a>
            </h3>
            <div class="card-desc__details flex-box">
                <div class="card-details">
                    <div class="card-details__rating flex-box">
                        <?= Raite::widget(['id' => $item['id'], 'view' => true]) ?>
                    </div>
                    <div class="card-details__price">
                        <span class="price">
                            <?php echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?>
                            <?= $priceData['symbolCode'] ?>
                        </span>
                        <?php if ($priceData['summ']): ?>
                            <span class="price price_old">
                                <?php echo number_format($priceData['price'], 0, '', ' '); ?>
                                <?= $priceData['symbolCode'] ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="/<?= $currency ?>/<?= $item['productMeta']['link']; ?>" class="btn btn_card"
                    id="btn-card-<?= $item['id'] ?>" data-btn="<?= $item['id'] ?>">
                    <?= Translations::getTranslation('more_details', $currency) ?>
                </a>
            </div>
        </div>
        <div class="card-dropdown" id="card-dropdown-<?= $item['id'] ?>" data-content="<?= $item['id'] ?>">
            <?php if (isset($item['productMeta']['type']) && $item['productMeta']['type'] != "info"): ?>
                <div class="quantity-dropdown">

                    <ul class="quantity" id="quantity-dropdown-<?= $item['id'] ?>">
                        <li class="quantity__item active">
                            <span data-col="1">
                                Количество:
                            </span>
                            1-Pack
                        </li>
                        <li class="quantity__item ">
                            <span data-col="2">
                                Количество:
                            </span>
                            2-Pack
                        </li>
                        <li class="quantity__item " data-col="3">
                            <span>
                                Количество:
                            </span>
                            3-Pack
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
            <button class="btn btn_basket add-to-cart" data-cyrrency="<?= $currency ?>" data-id="<?= $item['id'] ?>"
                data-price="<?php echo ($priceData['summ'] ? $priceData['summ'] : $priceData['price']) ?>"
                data-symbol="<?= $priceData['symbolCode'] ?>" <?= (isset($priceMeta['type']) && $priceMeta['type'] == "info" ? 'style="margin-top:0px"' : '') ?>>
                <?= Translations::getTranslation('add_cart', $currency) ?>
            </button>
        </div>
    </div>

<?php else: ?>

    <div class="card disabled">
        <div class="card-img">
            <?php if (!empty($item['productMeta']['image'])): ?>
                <?php $photoData = json_decode($item['productMeta']['image'], true); ?>
                <?php foreach ($photoData as $elem): ?>
                    <?php foreach ($elem as $photo): ?>
                        <img src="<?= $photo['value'] ?>" alt="" class="img">
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <img src="/adminStyle/assets/img/no-image.png" alt="" class="img">
            <?php endif; ?>
        </div>
        <div class="card-desc">
            <h3 class="card-desc__title disabled">
                <?= mb_substr($item['productMeta']['productName'], 0, 70, 'UTF-8'); ?>
            </h3>
            <div class="card-desc__details flex-box">
                <div class="card-details disabled">
                <div class="card-details__rating flex-box">
                        <?= Raite::widget(['id' => $item['id'], 'view' => true]) ?>
                    </div>
                    <div class="card-details__price">
                        <span class="price">
                            <?php echo ($priceData['summ'] ? $priceData['summ'] : $priceData['price']) ?>
                            <?= $priceData['symbolCode'] ?>
                        </span>
                        <?php if ($priceData['summ']): ?>
                            <span class="price price_old">
                                <?= $priceData['price'] ?>
                                <?= $priceData['symbolCode'] ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="btn btn_card disabled">
                    Нет в наличии
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>