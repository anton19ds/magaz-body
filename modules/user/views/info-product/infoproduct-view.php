<?php
use app\models\Product;
use app\widgets\Raite;
?>
<?php if ($item->getActiveProductLang($lang)): ?>
    <?php $priceData = Product::getPriceProductbyId($item->id, $lang); ?>
    <?php
    $name = $item->getParam('productName', $lang);
    $link = $item->getParam('link', $lang);
    ?>
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
            <?php if (!empty($item->getParam('image', null))): ?>
                <?php $image = json_decode($item->getParam('image', null), true) ?>
                <?php if (isset($image['array'][array_key_first($image['array'])])): ?>
                    <div style='background-image: url("<?php echo htmlentities($image['array'][array_key_first($image['array'])]['value']) ?>")' class="img-info-bg"></div>
                <?php endif; ?>
            <?php else: ?>
                <div style='background-image: url("/img/Rectangle 18.png")' class="img-info-bg"></div>
            <?php endif; ?>
        </div>
        <div class="infoproduct_content">
            <h3>
                <?php if ($name) {
                    echo $name;
                } else {
                    echo 'not set';
                } ?>
            </h3>
            <p class="description_infoproduct">
                <?php if($item->getParam('description', $lang)){
                    echo strip_tags(mb_strimwidth($item->getParam('description', $lang), 0, 270, "..."));
                }?>
            </p>
            <div class="rate-time_infoproduct">
                <div class="data-raite">
                    <?php echo Raite::widget(['id' => $item->id, 'view' => true, 'front' => true]); ?>
                </div>
                <p class="infoproduct_time">
                    <?php
                    $dataActive = $item->getParam('date-info', null);
                    //echo $dataActive;
                    $date_end = null;
                    $timestamp = time();
                    if ($dataActive) {
                        $date_end = date("d.m.Y", strtotime('+' . $dataActive . ' day', $item->dataOrdersInfoproduct()));
                    }
                    ?>
                    <?php if (isset($date_end) && !$access[1]): ?>
                        <?= Yii::t('app', 'the-course-is-active-col-dey') ?> <?= $dataActive ?> <?= Yii::t('app', 'day-s')?>
                    <?php elseif( isset($date_end) && $access[1]):?>
                        <?= Yii::t('app', 'the-course-is-active-until-over')?> <?= $date_end;?>
                    <?php endif; ?>
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
                        <a href="https://anticandida.com/<?= $lang ?>/user/view/<?= $link; ?>" class="view_product referInfoc" data-link="https://anticandida.com/<?= $lang ?>/user/view/<?= $link; ?>">
                            <?= Yii::t('app', 'whats-included-in-the-course'); ?>
                        </a>
                        <a href="#" class="stepr add-to-cart" data-cyrrency="<?= $lang ?>" data-id="<?= $item->id ?>"
                            data-price="<?= (isset($priceData['summ']) && !empty($priceData['summ']) ? $priceData['summ'] : $priceData['price'])?>" data-symbol="<?= $priceData['symbolCode']?>" data-count="1">
                            <?= Yii::t('app', 'cart'); ?>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="buttons_infoproduct in_stock">
                        <a href="https://anticandida.com/<?= $lang ?>/user/info-product/<?= $link; ?>" data-link="https://anticandida.com/<?= $lang ?>/user/info-product/<?= $link; ?>" class="referInfoc">
                            <?= Yii::t('app', 'look'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>