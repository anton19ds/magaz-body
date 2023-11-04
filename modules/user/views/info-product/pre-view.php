<?php
use app\models\Product;
use app\widgets\Raite;
use yii\bootstrap5\Modal;

$prise = Product::priceData($model->id, $lang);
?>
<div id="user_page">
    <div class="left_block">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'infoproduct'
        ]) ?>
    </div>
    <div class="right_block">
        <div class="breadcrambs">
            <?php $meta = $model->arrayMeta($lang) ?>
            <ul>
                <li><a href="">Магазин</a></li>
                <li><a href="">Инфопродукты</a></li>
                <li><a href="">
                        <?= $meta['productName'] ?>
                    </a></li>
            </ul>
        </div>

        <div class="block-title-page">
            <?= $meta['productName'] ?>
        </div>
        <div class="head-block">
            <?php echo $model->getProductFoto($stat = true) ?>
            <div class="dest">
                <div class="description">
                    <p>
                        <?= $meta['description'] ?>
                    </p>


                </div>
            </div>
        </div>
        <div class="info_prise slet">
            <div class="prise">
                <div class="set-raiting">
                    <?= Raite::widget(['id' => $model->id]) ?>
                </div>
                <?php if (isset($prise['summ']) && !empty($prise['summ'])): ?>
                    <?php echo $prise['summ'] . " " . $prise['symbolCode']; ?>
                    <s>
                        <?php echo $prise['price'] . " " . $prise['symbolCode']; ?>
                    </s>
                <?php else: ?>
                    <?php echo $prise['price'] . " " . $prise['symbolCode']; ?>
                <?php endif; ?>
            </div>
            <div class="block_add_cart">
                <a href="#" class="stepr add-to-cart" data-cyrrency="<?= $lang ?>" data-id="<?= $model->id ?>"
                    data-price="<?= $prise['price'] ?>" data-symbol="<?= $prise['symbolCode'] ?>">
                    Купить
                </a>
            </div>
        </div>
        <div class="lsert">
            Этапы Курса
        </div>
        <div class="step_curse">
            <?php $step = $model->getStep() ?>
            <?php if ($step): ?>
                <?php $i = 0; ?>
                <?php foreach ($step as $item): ?>
                    <?php
                    $img = false;
                    if (!empty($item['img'])) {
                        $arrayImg = json_decode($item['img'], true);
                        if (isset($arrayImg['array'][1]['value'])) {
                            $img = $arrayImg['array'][1]['value'];
                        }
                    } ?>
                    <div class="item_step <?= ($img ? 'hasImg' : '') ?>">
                        <img src="<?= $img ?>" alt="">
                        <p>
                            <?= $i;
                            $i++; ?>. Этап
                            <?php echo $item['title']; ?>
                            <br>
                            <span>
                                Время прохождения курса
                                <?php echo $item['time']; ?>
                            </span>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>



<style>
    .lsert {
        margin-top: 30px;
    }

    .step_curse {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        margin-top: 30px;
    }

    .item_step {
        width: calc((100%/3) - 10px);
        margin: 5px;
        border: 1px solid #ECECEC;
        border-radius: 10px;
        position: relative;
        text-align: center;
        display: flex;
        justify-content: center;
        background: #00A6CA;
        background-size: 100%;
        background-repeat: no-repeat;
        background-position: top center;
        color: #fff;
        transition: all 0.3s ease;
        flex-direction: column;
        overflow: hidden;
    }

    .hasImg:hover {
        background-size: 105%;
    }

    .hasImg p {
        color: black;
        padding: 0;
        margin: 0;
        background-color: #ddd;
        border-radius: 3px;
        margin-top: auto;
        margin-bottom: 0;
        width: 100%;
        text-align: left;
        padding: 5px;
    }

    .hasImg p span {
        font-size: 12px;
        font-weight: 300;
    }

    .head-block {
        display: flex;
    }

    .img-write {
        width: 40%;
    }

    .img-write img {
        max-width: 100% !important;
        width: 100% !important;

    }

    .dest {
        width: 60%;
        margin-left: 20px;
    }

    .description {
        font-weight: 300;
        font-size: 16px;
    }

    .content-block {
        margin-top: 20px;
    }

    .prise {
        margin-right: 10px;
    }

    .info_prise {
        justify-content: end;
    }

    .block_add_cart {
        margin-left: inherit;
    }

    .info_prise.slet {
        flex-direction: row;
    }

    .info-prod {
        font-size: 24px;
    }
</style>