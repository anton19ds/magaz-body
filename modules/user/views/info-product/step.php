<?php
use app\models\Product;
use yii\bootstrap5\Modal;

?>
<div id="user_page">
    <div class="left_block">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'infoproduct'
        ]) ?>
    </div>
    <div class="right_block">
        <div class="block_conten">
        <?= $content?>
        </div>
        <div class="block_end">
            <?php if($nexStep):?>
            <a href="/<?= $lang?>/user/info-product/list/<?= $product_link;?>/<?= $nexStep['id']?>">Потвердить прохождение и Перейти к следующему</a>
            <?php endif;?>
        </div>
    </div>
</div>