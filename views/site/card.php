<?php
use app\models\Product;
use app\models\Translations;
use app\widgets\Raite;


$type = $item->getParam('type', null);
$image = $item->getParam('image', null);
$visible = $item->getParam('visible', null);
$link = $item->getParam('link', $currency);
$label = $item->getParam('label', $currency);
$priceData = Product::getPriceProductbyId($item->id, $currency, $type);
$name = $item->getParam('productName', $currency);
$pricePac1 = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
$salePac1 = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
$pricePac2 = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
$salePac2 = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
$pricePac3 = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
$salePac3 = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
if (
    isset ($priceData['productPac']['pricePac-1']['prise']) &&
    !empty ($priceData['productPac']['pricePac-1']['prise'])
) {
    $pricePac1 = $priceData['productPac']['pricePac-1']['prise'];
}
if (
    isset ($priceData['productPac']['pricePac-1']['sale']) &&
    !empty ($priceData['productPac']['pricePac-1']['sale'])
) {
    $salePac1 = $priceData['productPac']['pricePac-1']['sale'];
}
if (
    isset ($priceData['productPac']['pricePac-2']['prise']) &&
    !empty ($priceData['productPac']['pricePac-2']['prise'])
) {
    $pricePac2 = $priceData['productPac']['pricePac-2']['prise'];
}
if (
    isset ($priceData['productPac']['pricePac-2']['sale']) &&
    !empty ($priceData['productPac']['pricePac-2']['sale'])
) {
    $salePac2 = $priceData['productPac']['pricePac-2']['sale'];
}

if (
    isset ($priceData['productPac']['pricePac-3']['prise']) &&
    !empty ($priceData['productPac']['pricePac-3']['prise'])
) {
    $pricePac3 = $priceData['productPac']['pricePac-3']['prise'];
}
if (
    isset ($priceData['productPac']['pricePac-3']['sale']) &&
    !empty ($priceData['productPac']['pricePac-3']['sale'])
) {
    $salePac3 = $priceData['productPac']['pricePac-3']['sale'];
}
?>

<?php if ($item->getActiveProductLang($currency) && $visible == '1'): ?>
    <?php if ($type == 'info' || $item->col > 0): ?>
        <div class="list_goods___relate">
            <div class="list_goods___item">
                <?php if (!empty ($image)): ?>
                    <?php $photoData = json_decode($image, true); ?>
                    <?php
                    $mainImage = '';
                    $listImage = '<ul class="list-image">';
                    $notMain = '';
                    foreach ($photoData['array'] as $photo) {
                        if (isset ($photo['main']) && $photo['main']) {
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
                    <img src="/adminStyle/assets/img/no-image.png" alt="" class="good_img">
                <?php endif; ?>
                <h5>
                    <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $currency ?>/shop/<?= $link; ?>" style="color:inherit" class="main-page-url-link" data-lang="<?= $currency ?>" data-link="<?= $link; ?>" data-set-link="<?php echo Yii::$app->params['parentUrl']?>/<?= $currency ?>/shop/<?= $link; ?>">
                        <?= ($name ? trim($name) : ""); ?>
                    </a>
                </h5>
                <div>
                    <div class="good__characters">
                        <div class="list_rate">
                            <?= Raite::widget(['front' => true, 'view' => true, 'id' => $item->id]) ?>
                        </div>
                        <p class="price_count">
                        <span class="prd-<?= $item->id?>">
                            <?php echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?>
                            <?= $priceData['symbolCode'] ?>
                            </span>
                            <?php if ($priceData['summ']): ?>
                                <span class="sale-price_count">
                                    <?php echo number_format($priceData['price'], 0, '', ' '); ?>
                                    <?= $priceData['symbolCode'] ?>
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $currency ?>/shop/<?= $link; ?>" class="main-page-url-link" data-lang="<?= $currency ?>" data-link="<?= $link; ?>">
                        <?= Yii::t('app', 'more_details') ?>
                    </a>
                </div>
                <form action="#" class="list_goods_item__quantity">
                    <?php if ($type != 'info'): ?>
                        <div class="quantity_good">
                            <div class="quantity_good_abs no_opened" data-id="<?= $item['id'] ?>">
                                <div class="item active" data-id="<?= $item->id?>" data-value="1" data-cena="<?= number_format($pricePac1, 0, '', ' ');?>" data-ser="<?= number_format($salePac1, 0, '', ' ');?>" data-code="<?= $priceData['symbolCode'] ?>"><span>
                                        <?= Yii::t('app', 'product-cart-count') ?>
                                    </span>1 - Pack</div>
                                <div class="item" data-id="<?= $item->id?>" data-value="2" data-cena="<?= number_format($pricePac2, 0, '', ' ');?>" data-ser="<?= number_format($salePac2, 0, '', ' ');?>" data-code="<?= $priceData['symbolCode'] ?>"><span>
                                        <?= Yii::t('app', 'product-cart-count') ?>
                                    </span>2 - Pack</div>
                                <div class="item" data-id="<?= $item->id?>" data-value="3" data-cena="<?= number_format($pricePac3, 0, '', ' ');?>" data-ser="<?= number_format($salePac3, 0, '', ' ');?>" data-code="<?= $priceData['symbolCode'] ?>"><span>
                                        <?= Yii::t('app', 'product-cart-count') ?>
                                    </span>3 - Pack</div>
                            </div>
                            <input type="hidden" name="quantity">
                        </div>
                    <?php endif; ?>
                    <button class="btn btn_basket add-to-cart" data-id="<?= $item['id'] ?>" data-count="1">
                        <?= Yii::t('app', 'cart') ?>
                    </button>
                </form>
                <?php if(isset($label) && !empty($label)):?>
                    <span class="good_tablet tablet-opacity">
                        <?= $label;?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    <?php elseif ($type != 'info' && $item->col <= 0): ?>
        <div class="list_goods___relate">
            <div class="list_goods___item good_no_stock">
                <?php if (!empty ($image)): ?>
                    <?php $photoData = json_decode($image, true); ?>
                    <?php
                    $mainImage = '';
                    $listImage = '<ul class="list-image">';
                    $notMain = '';
                    foreach ($photoData['array'] as $photo) {
                        if (isset ($photo['main']) && $photo['main']) {
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
                    <img src="/adminStyle/assets/img/no-image.png" alt="" class="good_img">
                <?php endif; ?>
                <h5>
                    <?= trim($name); ?>
                </h5>
                <div>
                    <div class="good__characters">
                        <div class="list_rate">
                            <?= Raite::widget(['front' => true, 'view' => true]) ?>
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
                    <a href="#">Нет в наличии</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
