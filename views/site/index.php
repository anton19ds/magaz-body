
<a href="#" class="open-cart"><img src="/icon/cart.svg" alt=""></a>
<div id="page-magazin">

    <div class="page-catalog">
        <?php
        foreach ($model as $item): ?>
            <?= $this->render('product-card', [
                'item' => $item,
                'currency' => $currency
            ]) ?>
        <?php endforeach; ?>
    </div>
</div>
<style>
    #page-magazin {
        width: 1200px;
    }
</style>