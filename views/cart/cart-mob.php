<?php if ($dataTovar): ?>
    <?php foreach ($dataTovar as $key => $item): ?>
        <?php if ($key != 'promocod' && $key != 'size'): ?>
        <div class="cart-element" data-id="<?= $item['id'] ?>">
            <div class="img-block">
                <img src="<?= $item['img'] ?>" alt="">
            </div>
            <div class="data-block">
                <div class="list-first">
                    <div class="title-sard-el">
                        <?= $item['name'] ?>
                    </div>
                    <div class="delete-elem-in-cart" data-id="<?= $item['id'] ?>">
                        <img src="/img/close (1).svg" alt="" />
                    </div>
                </div>
                <div class="list-next">
                    <div class="data-count">
                        <span data-id="<?= $item['id'] ?>" class="minus-tov <?= ($item['count'] == 1 ? "grey" : '') ?>">
                            <img src="/img/minus.svg" alt="" />
                        </span>
                        <span class="count" data-id="<?= $item['id'] ?>">
                            <?= $item['count'] ?>
                        </span>
                        <span data-id="<?= $item['id'] ?>" class="plus-tov">
                            <img src="/img/plus.svg" alt="" />
                        </span>
                    </div>
                    <div class="data-price" data-id="<?= $item['id'] ?>">
                        <?= $item['price'] ?>
                        <?= $item['symbol'] ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?>
    <?php endforeach; ?>
<?php endif; ?>