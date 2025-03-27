<?php
use app\models\Product;
use app\models\Translations;
use app\widgets\Raite;
?>
<div class="similar">
    <h4><?= Yii::t('app', 'cur-prod')?></h4>
    <div class="list_prod_recommendation">
        <?php foreach ($upsale as $item): ?>
            <?php
            
            $type = $item->getParam('type', null);
            $priceData = Product::getPriceProductbyId($item->id, $currency, $type);
            $image = $item->getParam('image', null);
            $link = $item->getParam('link', $currency);
            $name = $item->getParam('productName', $currency);
            ?>
            <?php if ($item->getActiveProductLang($currency)): ?>
                <div class="prod_recommendation__item">
                    <div class="prod_recommendation_item__img">
                        <?php if (!empty($image)): ?>
                            <?php $photoData = json_decode($image, true); ?>
                            <?php
                            $mainImage = '';
                            $listImage = '<ul class="list-image">';
                            $notMain = '';
                            foreach ($photoData['array'] as $photo) {
                                if (isset($photo['main']) && $photo['main']) {
                                    $mainImage = "<img src=\"{$photo['value']}\" alt=\"\" class=\"good_img\">";
                                } else {
                                    $notMain = "<img src=\"{$photo['value']}\" alt=\"\" class=\"good_img\">";
                                    $listImage .= "<li>";
                                    $listImage .= "<img src=\"{$photo['value']}\" alt=\"\" class=\"img\">";
                                    $listImage .= "</li>";
                                }
                            }
                            $listImage .= '</ul>';
                            ?>
                            <?= ($mainImage ? $mainImage : $notMain); ?>
                        <?php else: ?>
                            <img src="assets/images/examples/cart1.jpg" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="rec_item__char">
                        <a href="<?= $link ?>" data-set-link="<?php echo Yii::$app->params['parentUrl']?>/<?= $currency; ?>/shop/<?= $link; ?>">
                            <?= $name ?>
                        </a>
                        <div class="rec_char__price-sub">
                            <div>
                                <div class="list_rate">
                                    <?= Raite::widget(['front' => true, 'view' => true, 'id' => $item->id]) ?>
                                </div>
                                <p class="price_count">
                                    <?php echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?>
                                    <?= $priceData['symbolCode'] ?>
                                    <?php if ($priceData['summ']): ?>
                                        <span class="sale-price_count">
                                            <?php echo number_format($priceData['price'], 0, '', ' '); ?>
                                            <?= $priceData['symbolCode'] ?>
                                        </span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <a href="#" class="add-to-cart" data-cyrrency="<?= $currency ?>" data-count="1" data-id="<?= $item['id'] ?>"
                                data-price="<?php echo ($priceData['summ'] ? $priceData['summ'] : $priceData['price']) ?>"
                                data-symbol="<?= $priceData['symbolCode'] ?>" <?= (isset($priceMeta['type']) && $priceMeta['type'] == "info" ? 'style="margin-top:0px"' : '') ?>>
                                <?= Yii::t('app', 'cart')?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>