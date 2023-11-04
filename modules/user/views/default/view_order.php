<?php

use app\models\OrdersMeta;
use app\models\Product;
use app\models\Translations;

$listOrder = unserialize($orders->data_order);
?>
<?php foreach ($listOrder as $key => $value): ?>
    <?php $product = Product::getProduct($value['id'], $lang) ?>
    <?php $priceData = Product::priceData($value['id'], $lang); ?>
    <?php $imageList = $product->getImageProductList() ?>
    <div class="appcel-element">
        <div class="img-appcel">
            <?php if (isset($imageList['array']) && isset($imageList['array'][1]) && !empty($imageList['array'][1]['value'])): ?>
                <img src="/file/IMG_7555 1 (1).png" alt="">
            <?php endif; ?>
        </div>
        <div class="appcel-data">
            <div class="appcel-title">
                <a href="/tovar-2">
                    <?= $product->title() ?>
                </a>
            </div>
            <div class="appcel-element-data">
                <div class="appcel-rating">
                    <div class="appcel-rating-start">
                        <div class="appcel-star-list">
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star no"></div>
                        </div>
                        <div class="data-set-kol">(13)</div>
                    </div>
                    <?= $priceData['html']; ?>
                </div>

                <div class="appcel-in-cart">
                    <div class="btn-appcel-cart add-upsel-card add-to-cart" data-id="<?= $value['id'] ?>"
                        data-cyrrency="<?= $lang ?>" data-symbol="<?= $priceData['symbolCode'] ?>"
                        data-price="<?= $priceData['summ'] ?>">
                        <?= Translations::getTranslation('add_cart', $lang) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<div class="order_sem">
    <?php $meta = $orders->meta; ?>
    <p>
        <?php
        echo OrdersMeta::getLabelStatus()[$meta->shiping_type];
        ?>
        
        <?php
        echo OrdersMeta::getLabelShiping()[$meta->payment_type];
        ?>

        <?php
        echo $meta->promocode;
        ?>
    </p>
    <?php $adress = $meta->adress; ?>
    <?php if ($adress): ?>
        <p>
            <?php
            echo $adress->postcode;
            echo $adress->city;
            echo $adress->country;
            echo $adress->area;
            echo $adress->flat;
            echo $adress->street;
            ?>
        </p>
    <?php endif; ?>


</div>