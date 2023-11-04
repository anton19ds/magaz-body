<?php

use app\models\Translations;
use app\widgets\Apsell;
use app\widgets\Raite;
use yii\bootstrap5\Modal;

$imgJson = json_decode($model->getParam('image'), true);
$priseData = $model->getPriceProduct($currency);
?>


<div id="product">
    
    <div class="center-block-tovar">
    <div class="breadcrambs">
        <ul>
            <li><a href="/<?= $currency?>">Магазин</a></li>
            <li><a href="#"><?= $metaArray['productName'] ?></a></li>
        </ul>
    </div>
        <div class="param-tovar-ser">
            <div class="productTitle">
                <?= $metaArray['productName'] ?>
            </div>
            <?= Raite::widget(['id' => $model->id]) ?>
            <div class="img-product">
                <?php if (isset($imgJson['array'])): ?>
                    <?php
                    $imgPrev = $imgJson['array'][array_key_first($imgJson['array'])];
                    ?>
                    <img src="<?= $imgPrev['value'] ?>" alt="<?= $imgPrev['name'] ?>">
                <?php endif; ?>
            </div>
            <div class="img_prod_list">
                <?php if (isset($imgJson['array'])): ?>
                    <?php foreach ($imgJson['array'] as $item): ?>
                        <div class="elem">
                            <img src="<?= $item['value'] ?>" alt="">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div id="content_product">
            <?= $result ?>
        </div>
    </div>



    <div class="right-block-product">
        <ul class="product_prise">
            <li>
                <?= ($priseData['summ'] ? $priseData['summ'] : $priseData['price']) ?>
                <?= $priseData['symbol'] ?>
            </li>
            <?php if ($priseData['summ']): ?>
                <li>
                    <span><s>
                            <?= $priseData['price'] ?>
                            <?= $priseData['symbol'] ?>
                        </s></span>
                </li>
            <?php endif; ?>

        </ul>
        <div class="colect-data">
            <div class="col-colect active">
                <span>
                    <?= Yii::t('app', '1 pac') ?>
                </span>
                <span>
                    <?= ($priseData['summ'] ? $priseData['summ'] : $priseData['price']) ?>
                    <?= $priseData['symbol'] ?>
                    <?php if ($priseData['summ']): ?>
                        <s>
                            <?= $priseData['price'] ?>
                            <?= $priseData['symbol'] ?>
                        </s>
                    <?php endif; ?>
                </span>
            </div>
            <div class="col-colect">
                <span>
                    <?= Yii::t('app', '2 pac') ?>
                </span>
                <span>
                    <?= ($priseData['summ'] ? $priseData['summ'] * 2 : $priseData['price'] * 2) ?>
                    <?= $priseData['symbol'] ?>
                    <?php if ($priseData['summ']): ?>
                        <s>
                            <?= $priseData['price'] * 2 ?>
                            <?= $priseData['symbol'] ?>
                        </s>
                    <?php endif; ?>
                </span>
            </div>
            <div class="col-colect">
                <span>
                    <?= Yii::t('app', '3 pac') ?>
                </span>
                <span>
                    <?= ($priseData['summ'] ? $priseData['summ'] * 3 : $priseData['price'] * 3) ?>
                    <?= $priseData['symbol'] ?>
                    <?php if ($priseData['summ']): ?>
                        <s>
                            <?= $priseData['price'] * 3 ?>
                            <?= $priseData['symbol'] ?>
                        </s>
                    <?php endif; ?>
                </span>
            </div>
        </div>
        <div class="card_data">
            <?= Translations::getTranslation('add_cart', $currency) ?>
        </div>

        <div class="block-info-pred">
            <div class="se-y">
                <div><img src="/img/pig.svg" alt=""></div>
                <div> Платите дешевле
                    покупая комплекты</div>
            </div>
            <div class="se-y">
                <div><img src="/img/car.svg" alt=""></div>
                <div> Доставка товаров
                    по всему миру</div>
            </div>
            <div class="se-y">
                <div><img src="/img/chek.svg" alt=""></div>
                <div> 40 дней - гарантия
                    возврата денег</div>

            </div>
        </div>
        <?php if (isset($metaArray['image-ser']) && !empty($metaArray['image-ser'])): ?>
            <div class="ser-list">
                <?php $dataArray = json_decode($metaArray['image-ser'], true); ?>
                <?php if (isset($dataArray['array']) && !empty($dataArray['array'])): ?>
                    <?php foreach ($dataArray['array'] as $key => $data): ?>
                        <img src="<?= $data['value'] ?>" alt="">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="params_type">
            <div class="ter-y">
                Детали продукта
            </div>
            <?php if (isset($metaArray['params_sale']) && !empty($metaArray['params_sale'])): ?>
                <?php foreach (explode(';', $metaArray['params_sale']) as $key => $item): ?>
                    <div class="elem-div">
                        <?php foreach (explode(',', $item) as $key2 => $item2): ?>
                            <div class="div-s-t">
                                <?= $item2 ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>


        <div class="params_type">
            <div class="ter-y">
                Польза для здоровья
            </div>
            <?php if (isset($metaArray['params_sale_2']) && !empty($metaArray['params_sale_2'])): ?>
                <?php foreach (explode(';', $metaArray['params_sale_2']) as $key => $item): ?>
                    <div class="elem-div">
                        <div class="div-s-t-d">
                            <?= $item ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?= Apsell::widget(['title' => 'С ЭТИМ ТОВАРОМ БЕРУТ:']) ?>


    </div>
</div>


<?php Modal::begin([
    'id' => 'image-modal',
    'size' => 'modal-lg'
]) ?>
<div class="img-body">

</div>
<?php Modal::end() ?>