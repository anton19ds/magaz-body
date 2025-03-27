<?php
use app\models\Insurance;

?>
<?php if ($view == false): ?>
    <div class="ordering__sidebar-section block-belay" style="<?= isset($cart['insurance']) ? 'display:none' : ''?>">
        <h5>
            <?= Yii::t('app', 'delay-title') ?>
        </h5>
        <div class="list_prod_recommendation">
            <div class="prod_recommendation__item">
                <div class="prod_recommendation_item__img">
                    <img src="/img/catalog/arcticons.svg" alt="">
                </div>
                <div class="rec_item__char">
                    <div class="rec_item__char-title">
                        <p>
                            <?= Yii::t('app', 'insurance-txt') ?>
                        </p>
                        <p class="promocode_question letr">
                            <img src="/frontStyle/assets/images/question.svg" alt="">
                            <span>
                            <?= Yii::t('app', 'insurance-label') ?>
                            </span>
                        </p>
                    </div>
                    <div class="rec_char__price-sub">
                        <div>
                            <p class="rec_item__description">
                                <?= Yii::t('app', 'last-delay') ?>
                            </p>
                            <p class="price_count">
                                <?php echo Insurance::getInstance()->getSize($lang) ?>
                                <?php echo Yii::t('app', 'currency-symbol') ?>
                                <!-- <span class="sale-price_count">
                                    7 585 &#8381;
                                </span> -->
                            </p>
                        </div>
                        <a href="#" class="addInsurance">
                            <?= Yii::t('app', 'add-btn') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (isset($cart['insurance']) && $view == true): ?>
    <div class="products_in_cart__item material_product">
        <div class="prod_cart_item__img">
            <img src="/img/catalog/arcticons.svg" alt="">
        </div>
        <div class="prod_cart_item__char">
            <div class="prc_char__name-price">
                <a href="#" class="title_product_in_cart">
                <?= Yii::t('app', 'insurance-txt') ?>
                </a>
                <p class="inchure-text">
                    <?= Yii::t('app', 'last-delay')?>
                </p>
                <p class="price_count">
                    <?= number_format($cart['data'][$item->id]['count'] * Insurance::getInstance()->getSize($lang), 0, '', ' ') ?>
                    <?= Yii::t('app', 'currency-symbol') ?>
                </p>
            </div>
        </div>
        <div class="cart__item-delete delete-insurance" data-id="<?= $item['id'] ?>" data-pajax="0">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path
                    d="M13 11V16M3 6H19L17.42 20.22C17.3658 20.7094 17.1331 21.1616 16.7663 21.49C16.3994 21.8184 15.9244 22 15.432 22H6.568C6.07564 22 5.60056 21.8184 5.23375 21.49C4.86693 21.1616 4.63416 20.7094 4.58 20.22L3 6ZM6.345 3.147C6.50675 2.80397 6.76271 2.514 7.083 2.31091C7.4033 2.10782 7.77474 2 8.154 2H13.846C14.2254 1.99981 14.5971 2.10755 14.9176 2.31064C15.2381 2.51374 15.4942 2.80381 15.656 3.147L17 6H5L6.345 3.147V3.147ZM1 6H21H1ZM9 11V16V11Z"
                    stroke="#8B8B8B" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>
    <?php endif; ?>