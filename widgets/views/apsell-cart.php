<?php

use app\models\Product;
use app\widgets\Raite;
?>
<div class="best-products">
    <p class="products-title">
        <?= $title ?>
    </p>
    <?php foreach ($apsellProduct as $item): ?>
        <?php if ($item->getActiveProductLang($lang)): ?>
            <?php
            $image = $item->getParam('image', null);
            $name = $item->getParam('productName', $lang);
            $link = $item->getParam('link', $lang);
            $type = $item->getParam('type', null);
            ?>
            <?php $price = Product::getPriceProductbyId($item->id, $lang, $type); ?>
            <div class="card-product">
                <div class="card-product__img">
                    <?php if (!empty($image)): ?>
                        <?php
                        $arrayImg = json_decode($image, true);
                        ?>
                        <?php if(isset($arrayImg['array'][1]) && isset($arrayImg['array'][1]['value'])):?>
                        <img src="<?= $arrayImg['array'][1]['value'] ?>" alt="" class="img img_fill" />
                        <?php else:?>
                            <img src="/adminStyle/assets/img/no-image.png" alt="" class="img img_fill" />    
                        <?php endif;?>
                    <?php else: ?>
                        <img src="/adminStyle/assets/img/no-image.png" alt="" class="img img_fill" />
                    <?php endif; ?>
                </div>
                <div class="card-product__desc">
                    <h5 class="card-product__title">
                        <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $lang ?>/shop/<?= $link ?>">
                            <?php if ($name) {
                                echo $name;
                            } ?>
                        </a>
                    </h5>
                    <div class="card-product__details flex-box upsel">
                        <div class="card-product-details ">
                            <div class="card-product__rating flex-box">
                                <div class="list_rate_table">
                                <?= Raite::widget(['id' => $item->id, 'view' => true]) ?>
                                </div>
                            </div>
                            <div class="card-product__price flex-box">
                                <span class="price-product">
                                    <?= number_format((isset($price['summ']) && !empty($price['summ']) ? $price['summ'] : $price['price']), 0, '', ' ') ?>
                                    <?= Yii::t('app', 'currency-symbol') ?>
                                </span>
                                <?php if (isset($price['summ']) && !empty($price['summ'])): ?>
                                    <span class="price-product price-product_old">
                                        <?= number_format($price['price'], 0, '', ' ') ?>
                                        <?= Yii::t('app', 'currency-symbol') ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <button class="btn btn_card-product add-to-cart" data-count='1' data-id="<?= $item->id ?>" data-cyrrency="<?= $lang ?>"
                            data-symbol="<?= Yii::t('app', 'currency-symbol') ?>"
                            data-price="<?= (isset($price['summ']) && !empty($price['summ']) ? $price['summ'] : $price['price']) ?>">
                            <?= Yii::t('app', 'cart') ?>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div> 