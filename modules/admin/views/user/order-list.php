<?php

use app\models\OrdersMeta;
use app\models\UserAdress;

?>
<?php foreach ($ordersUser as $item): ?>
    <div class="col-md-12 card">
        <?php $dataOrder = $item->getTovar(); ?>
        <?php $arrayOrder = unserialize($item->data_order); ?>
        
        <ul style="padding:0; list-style-type:none">
            <?php $i = 1; ?>
            <?php foreach ($dataOrder as $prod): ?>
                <li>
                    <?= $i; ?> ) -
                    <?= $prod->id ?>
                    <?= $prod->getParam('productName') ?> -
                    <?= $arrayOrder[$prod->id]['count'] ?> (шт.)
                    <?= $arrayOrder[$prod->id]['price'] ?>
                    <?= $arrayOrder[$prod->id]['symbol'] ?>
                </li>
                <?php $i++; ?>
            <?php endforeach; ?>
        </ul>
        <p>
            <label for="">
                Заказчик:
            </label>
            <?= $item->user->firstName; ?>
            <?= $item->user->LastName; ?>
            <?= $item->user->secondName; ?>
            <?= $item->user->email; ?>
            <?= $item->user->phone; ?>
            <br>
            <?= (isset($item->meta->shiping_type) ? OrdersMeta::getLabelStatus()[$item->meta->shiping_type] : ''); ?> -
            <?= (isset($item->meta->payment_type) ? OrdersMeta::getLabelShiping()[$item->meta->payment_type] : ''); ?> -
            <?= (isset($item->meta->order_summ) ? $item->meta->order_summ : ''); ?>
            <?= (isset($item->meta->promocode) ? $item->meta->promocode : ''); ?>
            <?php if(isset($item->meta->adress_shipig)):?>
            <?php
            $adress = UserAdress::findOne($item->meta->adress_shipig);
            ?>
            <label for="">
                Адрес:
            </label>
            <?= $adress->postcode; ?>
            <?= $adress->country; ?>
            <?= $adress->city; ?>
            <?= $adress->area; ?>
            <?= $adress->flat; ?>
            <?= $adress->street; ?>
            <?php endif;?>
        </p>
        <hr>
    </div>
<?php endforeach; ?>