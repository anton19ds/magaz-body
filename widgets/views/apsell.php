<?php
use app\widgets\Raite;
?>
<div class="apccel">
    <div class="appcel-header">
        <span>
            <?= $title ?>
        </span>
    </div>
    <div class="appcel-body">
        <div class="appcel-list">
            <?php
            foreach ($apsellProduct as $item): ?>
                <?php $ptoductMeta = $item->arrayMeta($currency = null) ?>
                <?php $prise = $item->priceData($item->id, $lang) ?>
                <div class="appcel-element">
                    <div class="img-appcel">
                        <?php if (isset($ptoductMeta['image']) && !empty($ptoductMeta['image'])): ?>
                            <?php
                            $arrayImg = json_decode($ptoductMeta['image'], true);
                            ?>
                            <img src="<?= $arrayImg['array'][1]['value'] ?>" alt="" />
                        <?php else: ?>
                            <img src="/img/IMG_7555 2.png" alt="" />
                        <?php endif; ?>
                    </div>
                    <div class="appcel-data ">
                        <div class="appcel-title">
                            <a href="/<?= $lang?>/<?= $ptoductMeta['link'] ?>">
                                <?= mb_strcut($ptoductMeta['productName'], 0, 90) ?>
                            </a>
                        </div>
                        <div class="appcel-element-data appsel-rait">
                            <div class="appcel-rating">
                                <?= Raite::widget(['id' => $item->id]) ?>
                                <?= $prise['html'] ?>
                            </div>
                            <div class="appcel-in-cart">
                                <div class="btn-appcel-cart add-upsel-card add-to-cart" data-id="<?= $item->id?>" data-cyrrency="<?= $lang?>"
                                    data-symbol="<?= $prise['symbolCode']?>"
                                    data-price="<?= (isset($prise['summ']) && !empty($prise['summ']) ? $prise['summ'] : $prise['price']) ?>">
                                    <?= Yii::t('app', 'cart')?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="apccel">
            <div class="appcel-header">
                <span>
                    Приобретайте страховку, чтобы защитить свой товар на всех этапах доставки:</span>
            </div>
            <div class="appcel-body">
                <div class="appcel-list">
                    <div class="appcel-element">
                        <div class="img-appcel">
                            <img src="/icon/shield.svg" alt="">
                        </div>
                        <div class="appcel-data ">
                            <div class="appcel-title">
                                <a href="//ANTI-CANDIDA-ANTI-KANDIDA-KURS-OChIShchENIYa-OT-GRIBKOV">
                                    Cтраховка</a>
                                <p>
                                    Если вашу посылку потеряет почта, то мы вышлем вам новый товар.
                                </p>
                            </div>
                            <div class="appcel-element-data appsel-rait">
                                <div class="appcel-rating">

                                    <div class="apccels-rating-price">300 RUB</div>
                                </div>
                                <div class="appcel-in-cart">
                                    <div class="btn-appcel-cart add-upsel-card add-to-cart" data-id="" data-cyrrency=""
                                        data-symbol="" data-price="">
                                        Добавить</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
<style>
    .appsel-rait .rating-list .star{
        width: 10px;
        height: 10px;
    }

    .appcel-title a{
        display: block;
        font-size: 12px;
        line-height: 12px;
    }

    .apccels-rating-price {
        margin-top: 0;
    }

    .appcel-element{
        margin-top: 10px;
        padding-right: 0;
    }

    .img-appcel{
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>