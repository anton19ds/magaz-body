<?php
use app\models\Translations;
use app\widgets\Raite;

$priceData = $item->getPriceProduct($currency);
$priceMeta = $item->arrayMeta($currency);
?>

<div
    class="card-tovar <?= (isset($priceMeta['type']) && $priceMeta['type'] == "info" ? "info" : ($item->sale ? "sale" . $item->sale . $item->id : "")) ?>">
    <div class="img-tovar">
        <?php if (!empty($item->getImageProductList())): ?>
            <?php foreach ($item->getImageProductList() as $elem): ?>
                <?php foreach ($elem as $photo): ?>
                    <div class="wrap-img" style="background-image: url('<?= $photo['value'] ?>')"></div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="wrap-img" style="background-image: url('/adminStyle/assets/img/no-image.png')"></div>
        <?php endif; ?>
    </div>
    <div class="card-dater">
        <div class="card-title">
            <?= $item->getParam('productName', $currency) ?>
        </div>
        <div class="card-foram">
            <div class="raiting">
            <?= Raite::widget(['id' => $item->id])?>
                <div class="ply_prise">
                    <span>
                        <?php echo ($priceData['summ'] ? $priceData['summ'] : $priceData['price']) ?>
                        <?= $priceData['symbolCode'] ?>

                        <?php if ($priceData['summ']): ?>
                            <b>
                                <?= $priceData['price'] ?>
                                <?= $priceData['symbolCode'] ?>
                            </b>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            <div class="button-add">
                <a href="/<?= $currency; ?>/<?= $priceMeta['link'] ?>">
                    <?= Translations::getTranslation('more_details', $currency) ?>
                </a>
            </div>
        </div>
        <div class="crad-offer">
            <div class="btn-list">
                <div class="list-option">
                    <div class="element">
                        <div class="cost"><span>
                                <?= Translations::getTranslation('quantity', $currency) ?>
                            </span><?= Yii::t('app', '1 pac')?></div>
                    </div>
                </div>
                <div class="list-element">
                    <div class="element">
                        <div class="cost"><span>
                                <?= Translations::getTranslation('quantity', $currency) ?>
                            </span><?= Yii::t('app', '2 pac')?></div>
                    </div>
                    <div class="element">
                        <div class="cost"><span>
                                <?= Translations::getTranslation('quantity', $currency) ?>
                            </span><?= Yii::t('app', '3 pac')?></div>
                    </div>
                </div>
                <div class="btn-add-cart add-to-cart" data-cyrrency="<?= $currency ?>" data-id="<?= $item->id ?>"
                    data-price="<?php echo ($priceData['summ'] ? $priceData['summ'] : $priceData['price']) ?>"
                    data-symbol="<?= $priceData['symbolCode'] ?>">
                    <?= Translations::getTranslation('add_cart', $currency) ?>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    .sale

    <?= $item->sale . $item->id ?>
    :after {
        content: 'Скидка <?= $item->sale ?>%';
        display: block;
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        margin: auto;
        background-color: #fff;
        border: 1px solid #00A6CA;
        color: #00A6CA;
        width: 40%;
        text-align: center;
        padding: 2px;
        top: -15px;
        border-radius: 2px;
        z-index: 3;
    }

    @media(max-width:1000px) {
        .sale

        <?= $item->sale . $item->id ?>
        :after {
            font-size: 14px;
        }
    }
</style>