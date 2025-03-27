<?php
use app\models\Product;
function del_tags($txt, $tag)
{
    if($txt){
        $tags = explode(',', $tag);
    do {
        $tag = array_shift($tags);
        $txt = preg_replace("~<($tag)[^>]*>|(?:</(?1)>)|<$tag\s?/?>~x", '', $txt);
    } while (!empty($tags));
    return $txt;
    }
    return $txt;
}
?>
<?php foreach ($product as $key => $item): ?>
    <?php
    $type = $item->getParam('type', null);
    $priceData = Product::getPriceProductbyId($item->id, $currensy, $type);
    $price = $priceData['summ'] ? $priceData['summ'] : $priceData['price'];
    $image = $item->getParam('image', null);
    $link = $item->getParam('link', $currensy);
    $name = $item->getParam('productName', $currensy);
    ?>
    <div class="products_in_cart__item material_product">
        <?= $this->render('product-photo', [
            'image' => $image
        ]) ?>
        <div class="prod_cart_item__char">
            <div class="prc_char__name-price">
                <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $currensy; ?>/shop/<?= $link ?>" class="title_product_in_cart" data-set-link="<?php echo Yii::$app->params['parentUrl']?>/<?= $currensy; ?>/shop/<?= $link; ?>">
                    <?= del_tags($name, 'br'); ?>
                </a>
                <?= $this->render('price_count', [
                    'priceData' => $priceData,
                    'price' => $price,
                    'item' => $item,
                    'cart'=> $cart
                ]) ?>
            </div>
            <div class="prc_char__quantity-total">
                <?php if (isset($type) && $type != "info"): ?>
                    <?= $this->render('prc_quantity', ['item' => $item, 'cart' => $cart]) ?>
                <?php endif; ?>
                <p class="prc_char__total">
                    <?= $this->render('char__total',[
                        'priceData' => $priceData,
                        'cart' => $cart,
                        'item' => $item
                    ])?>
                </p>
            </div>
        </div>
        <div class="cart__item-delete delete-tov-cart" data-id="<?= $item['id'] ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path
                    d="M13 11V16M3 6H19L17.42 20.22C17.3658 20.7094 17.1331 21.1616 16.7663 21.49C16.3994 21.8184 15.9244 22 15.432 22H6.568C6.07564 22 5.60056 21.8184 5.23375 21.49C4.86693 21.1616 4.63416 20.7094 4.58 20.22L3 6ZM6.345 3.147C6.50675 2.80397 6.76271 2.514 7.083 2.31091C7.4033 2.10782 7.77474 2 8.154 2H13.846C14.2254 1.99981 14.5971 2.10755 14.9176 2.31064C15.2381 2.51374 15.4942 2.80381 15.656 3.147L17 6H5L6.345 3.147V3.147ZM1 6H21H1ZM9 11V16V11Z"
                    stroke="#8B8B8B" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>
    <?php if ($item['type'] != 'info' && $item['type'] != 'data'): ?>
        <?= $this->render('../components/delay', [
            'cart' => $cart,
            'view' => true,
            'item' => $item,
            'lang' => $currensy
        ]) ?>
    <?php endif; ?>
<?php endforeach; ?>