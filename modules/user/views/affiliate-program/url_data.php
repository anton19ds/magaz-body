<?php
use app\models\PromoUser;
?>
<div class="report__link">
    <p>
        https://anticandida.com/<?= (isset($model['promocode']) && PromoUser::getProdLink($model['promocode']) != '/' ? PromoUser::getProdLink($model['promocode']) : '') ?>
    </p>
</div>


