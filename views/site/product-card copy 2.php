<?php

use app\models\Product;
use app\models\Translations;
use app\widgets\Raite;

$priceData = Product::getPriceProductbyId($item['id'], $currency);
?>




<?php if ($item['productMeta']['type'] == "info" || $item['col'] > 0): ?>
    <div class="card">
        <?php if (isset($item['productMeta']['type']) && $item['productMeta']['type'] == "info"): ?>
            <span class="card-sale card-sale_fill">
                <?= Yii::t('app', 'info-product') ?>
            </span>
        <?php else: ?>
            <?php if (isset($item['sale']) && !empty($item['sale'])): ?>
                <span class="card-sale">
                    <?= Yii::t('app', '[sale]') ?>
                    <?php if (stristr($item['sale'], '%')): ?>
                        <?= $item['sale'] ?>%
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        <?php endif; ?>
        <div class="card-img">
            <?php if (!empty($item['productMeta']['image'])): ?>
                <?php $photoData = json_decode($item['productMeta']['image'], true); ?>
                <?php
                $mainImage = '';
                $listImage = '<ul class="list-image">';
                foreach ($photoData['array'] as $photo) {
                    if (isset($photo['main']) && $photo['main']) {
                        $mainImage = "<img src=\"{$photo['value']}\" alt=\"\" class=\"img main-image-product\">";
                    } else {
                        $listImage .= "<li>";
                        $listImage .= "<img src=\"{$photo['value']}\" alt=\"\" class=\"img\">";
                        $listImage .= "</li>";
                    }
                }
                $listImage .= '</ul>';
                ?>
                <?= $mainImage; ?>
                <?= $listImage; ?>

            <?php else: ?>
                <img src="/adminStyle/assets/img/no-image.png" alt="" class="img">
            <?php endif; ?>
        </div>
        <div class="card-desc">
            <h3 class="card-desc__title">
                <a href="/<?= $currency ?>/<?= getDataArray($item ,$currency, 'link'); ?>">
                    <?= mb_substr(getDataArray($item ,$currency, 'productName'), 0, 70, 'UTF-8'); ?>
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
                <a href="/<?= $currency ?>/<?= getDataArray($item ,$currency, 'link'); ?>" class="btn btn_card"
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
                                <?= Yii::t('app', '[product-cart-count]') ?>
                            </span>
                            1-Pack
                        </li>
                        <li class="quantity__item ">
                            <span data-col="2">
                                <?= Yii::t('app', '[product-cart-count]') ?>
                            </span>
                            2-Pack
                        </li>
                        <li class="quantity__item " data-col="3">
                            <span>
                                <?= Yii::t('app', '[product-cart-count]') ?>
                            </span>
                            3-Pack
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
            <button class="btn btn_basket add-to-cart" data-cyrrency="<?= $currency ?>" data-id="<?= $item['id'] ?>"
                data-price="<?php echo ($priceData['summ'] ? $priceData['summ'] : $priceData['price']) ?>"
                data-symbol="<?= $priceData['symbolCode'] ?>" <?= (isset($priceMeta['type']) && $priceMeta['type'] == "info" ? 'style="margin-top:0px"' : '') ?>>
                <?= Yii::t('app', 'cart')?>
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
                <?= mb_substr(getDataArray($item ,$currency, 'productName'), 0, 70, 'UTF-8'); ?>
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
                        <?= Yii::t('app', '[not-available]')?>
                    </button>
                </div>
            </div>
        </div>
<?php endif; ?>