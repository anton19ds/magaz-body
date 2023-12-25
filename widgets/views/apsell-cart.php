<?php

use app\models\Product;
use app\widgets\Raite;

?>
<div class="best-products">
    <p class="products-title">
        <?= $title ?>
    </p>
    <?php foreach ($apsellProduct as $item): ?>
        <?php $ptoductMeta = $item->arrayMeta($currency = null);
        $price = Product::getPriceProductbyId($item->id, $lang);
        ?>
        <div class="card-product">
            <div class="card-product__img">
                <?php if (isset($ptoductMeta['image']) && !empty($ptoductMeta['image'])): ?>
                    <?php
                    $arrayImg = json_decode($ptoductMeta['image'], true);
                    ?>
                    <img src="<?= $arrayImg['array'][1]['value'] ?>" alt="" class="img img_fill" />
                <?php else: ?>
                    <img src="/adminStyle/assets/img/no-image.png" alt="" class="img img_fill" />
                <?php endif; ?>
            </div>
            <div class="card-product__desc">
                <h5 class="card-product__title">
                    <a href="/<?= $lang ?>/<?= $ptoductMeta['link'] ?>">
                        <?= mb_strcut($ptoductMeta['productName'], 0, 90) ?>
                    </a>
                </h5>
                <div class="card-product__details flex-box">
                    <div class="card-product-details ">
                        <div class="card-product__rating flex-box">
                            <?= Raite::widget(['id' => $item->id, 'view' => true]) ?>
                        </div>
                        <div class="card-product__price flex-box">
                            <span class="price-product">
                                <?= number_format((isset($price['summ']) && !empty($price['summ']) ? $price['summ'] : $price['price']), 0, '', ' ') ?>
                                <?= $price['symbolCode'] ?>
                            </span>
                            <?php if (isset($price['summ']) && !empty($price['summ'])): ?>
                                <span class="price-product price-product_old">
                                    <?= number_format($price['price'], 0, '', ' ') ?>
                                    <?= $price['symbolCode'] ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button class="btn btn_card-product add-to-cart" data-id="<?= $item->id ?>" data-cyrrency="<?= $lang ?>"
                        data-symbol="<?= $price['symbolCode'] ?>"
                        data-price="<?= (isset($price['summ']) && !empty($price['summ']) ? $price['summ'] : $price['price']) ?>">
                        <?= Yii::t('app', 'cart') ?>
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>