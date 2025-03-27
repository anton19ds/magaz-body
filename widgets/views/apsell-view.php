<?php
use app\models\Insurance;
use app\models\Product;
use app\widgets\Raite;

?>
<div class="ordering__sidebar first_ordering__sidebar">
    <?php if (!empty($apsellProduct)): ?>
        <div class="ordering__sidebar-section">
            <h5>
                <?= $title ?>
            </h5>
            <div class="list_prod_recommendation">
                <?php foreach ($apsellProduct as $item): ?>
                    
                    <?php if($item->getActiveProductLang($lang)):?>
                    <?php

                    $type = $item->getParam('type', null);
                    $image = $item->getParam('image', null);
                    $link = $item->getParam('link', $lang);
                    $name = $item->getParam('productName', $lang);
                    $priceData = Product::getPriceProductbyId($item->id, $lang, $type);
                    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
                    ?>
                    <div class="prod_recommendation__item">
                        <div class="prod_recommendation_item__img">
                            <?php if (!empty($image)): ?>
                                <?php $photoData = json_decode($image, true); ?>
                                <?php
                                $mainImage = '';
                                $dopImage = '';
                                foreach ($photoData['array'] as $photo) {
                                    if (isset($photo['main']) && $photo['main']) {
                                        $mainImage = "<img src=\"{$photo['value']}\" alt=\"\">";
                                    } else {
                                        $dopImage = "<img src=\"{$photo['value']}\" alt=\"\">";
                                    }
                                }
                                ?>
                                <?= (!empty($mainImage) ? $mainImage :  $dopImage); ?>
                            <?php else: ?>
                                <img src="/adminStyle/assets/img/no-image.png" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="rec_item__char">
                            <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $lang ?>/shop/<?= $link ?>" data-set-link="<?php echo Yii::$app->params['parentUrl']?>/<?= $lang; ?>/shop/<?= $link; ?>">
                                <?= $name ?>
                            </a>
                            <div class="rec_char__price-sub">
                                <div>
                                    <div class="list_rate">
                                        <div class="list_rate_table">
                                            <?= Raite::widget(['front' => true, 'view' => true]) ?>
                                        </div>
                                    </div>
                                    <p class="price_count">
                                        <?php echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?>
                                        <?= Yii::t('app', 'currency-symbol') ?>
                                        <?php if ($priceData['summ']): ?>
                                            <span class="sale-price_count">
                                                <?php echo number_format($priceData['price'], 0, '', ' '); ?>
                                                <?= Yii::t('app', 'currency-symbol') ?>
                                            </span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <a href="#" class="add-to-cart" data-count="1" data-id="<?= $item->id ?>" data-cyrrency="<?= $lang ?>"
                                    data-symbol="<?= Yii::t('app', 'currency-symbol') ?>"
                                    data-price="<?= (isset($priceData['summ']) && !empty($priceData['summ']) ? $priceData['summ'] : $priceData['price']) ?>">
                                    <?= Yii::t('app', 'cart') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>

                <?php endforeach; ?>

            </div>
        </div>
    <?php endif; ?>
    <?= $this->render('/components/delay', [
        'cart' => $cart,
        'view' => false,
        'lang' => $lang
    ]) ?>
</div>