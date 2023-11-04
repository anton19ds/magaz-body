<?php
use app\models\Product;
use app\models\Translations;
use app\widgets\Raite;
use yii\helpers\ArrayHelper;

?>

<?php foreach ($upsale as $item): ?>
    <?php $item['productMeta'] = ArrayHelper::map($item['productMeta'], 'meta', 'value'); ?>
    <?php $priceData = Product::priceData($item['id'], $currency); ?>
    <div class="appcel-element">
        <div class="img-appcel">
            <?php if (isset($item['productMeta']['image']) && !empty($item['productMeta']['image'])): ?>
                <?php
                $arrayImg = json_decode($item['productMeta']['image'], true);
                ?>
                <img src="<?= $arrayImg['array'][1]['value'] ?>" alt="" />
            <?php else: ?>
                <img src="/img/IMG_7555 2.png" alt="" />
            <?php endif; ?>
        </div>

        <div class="appcel-data">
            <div class="appcel-title">
                <a href="/<?= $currency?>/<?= $item['productMeta']['link'] ?>">
                    <?= $item['productMeta']['productName'] ?>
                </a>
            </div>
            <div class="appcel-element-data">
                <div class="appcel-rating">
                <?= Raite::widget(['id' => $item['id']]) ?>

                    <?= $priceData['html']; ?>
                </div>
                <div class="appcel-in-cart">
                    <div class="btn-appcel-cart add-upsel-card add-to-cart" data-id="<?= $item['id'] ?>"
                        data-cyrrency="<?= $currency ?>" data-symbol="<?= $priceData['symbolCode'] ?>"
                        data-price="<?= $priceData['summ'] ?>">
                        <?= Translations::getTranslation('add_cart', $currency) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>