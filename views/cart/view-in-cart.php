<?php
use app\widgets\Raite;

function del_tags($txt, $tag)
{
    $tags = explode(',', $tag);

    do {
        $tag = array_shift($tags);
        $txt = preg_replace("~<($tag)[^>]*>|(?:</(?1)>)|<$tag\s?/?>~x", '', $txt);
    } while (!empty($tags));

    return $txt;
}

foreach ($cart['data'] as $key => $item): ?>
    <?php if ($key != 'dataSummSale' && $key != 'dataSumm'): ?>
        <div class="product">
            <div class="product__img">
                <img src="<?= $item['productPhoto'] ?>" alt="" class="img">
            </div>
            <div class="product__desc">
                <h4>
                    <?= del_tags($item['productName'], 'br'); ?>
                </h4>
                <div class="card-product__rating flex-box">
                    <?= Raite::widget(['id' => $item['id'], 'view' => true]) ?>
                </div>
                <div class="product__price">
                    <span class="price price_basket">
                        <?= number_format($item['price'], 0, '', ' ') ?>
                        <?= $item['symbol'] ?>
                    </span>
                </div>
            </div>

            <div class="quantity-goods">
                <?php if (isset($item['type']) && $item['type'] != "info"): ?>
                    <button class="btn-quantity minus-tov-cart <?= ($item['count'] > 1 ? 'active' : '') ?>"
                        data-id="<?= $item['id'] ?>" data-pjax=0>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="2" viewBox="0 0 12 2" fill="none">
                            <path d="M0 1H12" stroke="#CACACA" stroke-width="2" />
                        </svg>
                    </button>
                    <input type="text" class="quantity-number" value="<?= $item['count'] ?>">
                    <button class="btn-quantity active plus-tov-cart" data-id="<?= $item['id'] ?>" data-pjax=0>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M0 6H6M12 6H6M6 6V0M6 6V12" stroke="#CACACA" stroke-width="2" />
                        </svg>
                    </button>
                <?php endif; ?>
                <?php if (isset($item['productSize']['saleSize'])): ?>
                    <span class="sale-data-s">
                        <?= $item['productSize']['saleSize'] ?> %
                    </span>
                <?php endif; ?>
                <div class="last-data">
                    <div class="total-price">
                        <?= number_format((isset($item['productSize']['sale']) && !empty($item['productSize']['sale']) ? $item['productSize']['sale'] * $item['count'] : $item['price'] * $item['count']), 0, '', ' ') ?>
                        <?= $item['symbol'] ?>
                    </div>
                    <span data-id="<?= $item['id'] ?>" class="delete-tov-cart">
                        <img src="/img/basket.svg" alt="">
                    </span>
                </div>
            </div>

        </div>
    <?php endif; ?>

<?php endforeach; ?>