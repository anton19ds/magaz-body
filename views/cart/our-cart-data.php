<div class="data-card-order-data">
    <ul>
        <?php if(isset($cart['promocode'])):?>
        <li><span>Товар</span><span><?= number_format($cart['totalData']['salePrice'], 0, '', ' ')?> ₽</span></li>
        <?php endif;?>
        <?php if(isset($cart['delivery']) && !empty($cart['delivery'])):?>
        <li><span>Доставка</span><span><?= $cart['delivery']?> ₽</span></li>
        <?php endif;?>
        <?php if(!empty($cart['promocode'])):?>
        <li>
            <span class="in-promo">Скидка по промокоду “<?= $cart['promocode']?>”:</span><span><?= number_format($cart['totalData']['saleSizePrice'], 0, '', ' ')?> ₽</span>
        </li>
        <?php endif;?>
        <li class="final"><span>Итого</span> <span><?php if(isset($cart['totalData']['totalPrice']) && $cart['totalData']['totalPrice'] != 0){
                echo number_format($cart['totalData']['totalPrice'], 0, '', ' ');
            }else{
                echo number_format($cart['totalData']['salePrice'], 0, '', ' ');
            }?> ₽</span></li>
    </ul>
</div>