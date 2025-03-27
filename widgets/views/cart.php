<?php
use app\models\Cart;
use app\models\Product;
use app\models\SettingData;
use app\widgets\ApsellCart;
use app\widgets\Raite;
use yii\widgets\Pjax;

?>
<div class="cart-modal" style="display:none">
    <div class="cart-wraper">
        <div class="cart">
            <?php Pjax::begin([
                'id' => 'pjax-cart-modal'
            ]); ?>
            <div class="cart-header">
                <div class="img-logo">
                <?php $logo = SettingData::getValue('logo');
                    $array = json_decode($logo, true);
                    ?>
                    <img src="<?= $array['array'][1]['value']?>" alt="" />
                </div>
                <div class="btn-close close-cart">
                    <img src="/img/close.svg" alt="" />
                </div>
            </div>
            <div class="card-body">
                <div class="card-element-list">
                    <div class="cart-element-header">
                        <span>
                            <?= Yii::t('app', 'our-product') ?>
                        </span>
                    </div>

                    
                    <div id="cart-element-data" class="modal-cart-data">
                        <?php if (isset($cart['data']) && !empty($product)): ?>
                            <?php foreach ($product as $key => $item): ?>
                                <?php
                                $type = $item->getParam('type', null);
                                $priceData = Product::getPriceProductbyId($item->id, $lang, $type);
                                
                                $image = $item->getParam('image', null);
                                $link = $item->getParam('link', $lang);
                                $name = $item->getParam('productName', $lang);
                                ?>
                                <?php if ($key != 'promocod' && $key != 'size'): ?>
                                    <div class="cart-element" data-id="<?= $item->id ?>">
                                        <div class="img-block">
                                            <?php if (!empty ($image)): ?>
                                                <?php $photoData = json_decode($image, true); ?>
                                                <?php
                                                $mainImage = '';
                                                $dopImage = '';
                                                foreach ($photoData['array'] as $photo) {
                                                    if (isset($photo['main']) && $photo['main'] && $photo['main'] == '1') {
                                                        $mainImage = "<img src=\"{$photo['value']}\" alt=\"\" class=\"good_img\">";
                                                    } else {
                                                        $dopImage = "<img src=\"{$photo['value']}\" alt=\"\" class=\"good_img\">";
                                                    }
                                                }
                                                ?>
                                                <?= ($mainImage ? $mainImage : $dopImage); ?>
                                            <?php else: ?>
                                                <img src="/adminStyle/assets/img/no-image.png" alt="" class="good_img">
                                            <?php endif; ?>

                                        </div>
                                        <div class="data-block">
                                            <div class="list-first">
                                                <div class="title-sard-el">
                                                    <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $lang ?>/shop/<?= $link; ?>" style="color:inherit" data-set-link="<?php echo Yii::$app->params['parentUrl']?>/<?= $lang ?>/shop/<?= $link; ?>">
                                                        <?= ($name ? trim($name) : ""); ?>
                                                    </a>
                                                </div>
                                                <div class="delete-elem-in-cart delete-tov-cart" data-id="<?= $item['id'] ?>">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M13 11V16M3 6H19L17.42 20.22C17.3658 20.7094 17.1331 21.1616 16.7663 21.49C16.3994 21.8184 15.9244 22 15.432 22H6.568C6.07564 22 5.60056 21.8184 5.23375 21.49C4.86693 21.1616 4.63416 20.7094 4.58 20.22L3 6ZM6.345 3.147C6.50675 2.80397 6.76271 2.514 7.083 2.31091C7.4033 2.10782 7.77474 2 8.154 2H13.846C14.2254 1.99981 14.5971 2.10755 14.9176 2.31064C15.2381 2.51374 15.4942 2.80381 15.656 3.147L17 6H5L6.345 3.147V3.147ZM1 6H21H1ZM9 11V16V11Z"
                                                            stroke="#8B8B8B" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="list-next">
                                                <div class="card-product__rating flex-box">
                                                    <?= Raite::widget(['id' => $item->id, 'view' => true, 'front' => true]) ?>
                                                </div>
                                                <div class="data-count">
                                                    <?php if ($item['type'] != 'info'): ?>
                                                        <span data-id="<?= $item->id ?>"
                                                            class="minus-tov <?= ($cart['data'][$item->id]['count'] == 1 ? "grey" : 'active') ?> minus-tov-cart">
                                                            <img src="/img/minus.svg" alt="" />
                                                        </span>
                                                        <span class="count" data-id="<?= $item->id ?>">
                                                            <?= $cart['data'][$item->id]['count'] ?>
                                                        </span>
                                                        <span data-id="<?= $item->id ?>" class="plus-tov plus-tov-cart">
                                                            <img src="/img/plus.svg" alt="" />
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="data-price" data-id="<?= $item->id ?>">
                                                    <!-- $priceData -->
                                                    <?php $dataSetPrise = function() use ($cart, $item, $priceData){
                                                        if($cart['data'][$item->id]['count'] == 1){
                                                            if(isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-1']['sale']) && $priceData['productPac']['pricePac-1']['sale']){
                                                                return  number_format($priceData['productPac']['pricePac-1']['sale'], 0, '', ' ')." ". Yii::t('app', 'currency-symbol');
                                                            }

                                                        }else if($cart['data'][$item->id]['count'] == 2){
                                                            if(isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-2']['sale']) && $priceData['productPac']['pricePac-2']['sale']){
                                                                return  number_format($priceData['productPac']['pricePac-2']['sale'], 0, '', ' ')." ". Yii::t('app', 'currency-symbol');
                                                            }
                                                        }else if($cart['data'][$item->id]['count'] >= 3){
                                                            if(isset($priceData['productPac']) && isset($priceData['productPac']['pricePac-3']['sale']) && $priceData['productPac']['pricePac-3']['sale']){
                                                                return  number_format($priceData['productPac']['pricePac-3']['sale'], 0, '', ' ')." ". Yii::t('app', 'currency-symbol');
                                                            }
                                                        }
                                                        return number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' ')." ".Yii::t('app', 'currency-symbol');
                                                    };
                                                    echo $dataSetPrise();
                                                    ?>
                                                    <?php //echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?>
                                                    <?php //= Yii::t('app', 'currency-symbol') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($cart['data']) && !empty($product)): ?>
                    <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $lang ?>/shop/cart" data-pjax=0 id="interToCart-to" data-lang="<?= $lang ?>" data-link="cart">
                            <?= Yii::t('app', 'go-in-cart') ?>
                        </a>
                    <?php endif;?>
                </div>
                <?= ApsellCart::widget(['title' => Yii::t('app', 'best-product'), 'lang' => $lang]) ?>
            </div>
            <div class="cart-header bottom-set">
                <div class="currents">
                    <div class="def-itog">
                        <?= Yii::t('app', 'total') ?>
                    </div>
                    <div class="def-prise">
                        <span id="end-resutl">
                        <?php if (isset($cart['data']) && !empty($product)): ?>
                            <?= Cart::totalSumm($cart, $product, $lang) ?>
                            <?php endif;?>
                        </span>
                    </div>
                </div>
                <div class="action-btn">
                    <div class="remove-cart">
                        <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $lang ?>/shop/cart" data-pjax=0 id="interToCart" data-lang="<?= $lang ?>" data-link="cart">
                            <?= Yii::t('app', 'go-in-cart') ?>
                        </a>
                    </div>
                    <div class="in-cart close-cart">
                        <?= Yii::t('app', 'next-btn-sales') ?>
                    </div>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>


<style>
#interToCart-to{
    text-align: center;
    width: 92%;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 50px;
    margin-top: 20px;
    margin-bottom: 30px;
    background-color: #00a6ca;
    margin: auto;
    color: #fff;
    margin-top: 20px;
    margin-bottom: 30px;
}
</style>