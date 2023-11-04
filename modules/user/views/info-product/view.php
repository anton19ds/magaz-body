<?php
use app\models\Product;
use app\widgets\Raite;
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
        <!-- 'meta' => $meta,
            'lang' => $reuest['lang'],
            'product' => $product -->
        <div class="title_block_info">
            <div class="block_title_page">
                <?php echo $meta['productName'] ?>
            </div>
            <div class="description_inf">
                <div class="image">
                <?php $image = $product->getImageProductList(); ?>
                    <?php if (!empty($image)): ?>
                        <?php if (isset($image['array'][array_key_first($image['array'])])): ?>
                            <img src="<?php echo $image['array'][array_key_first($image['array'])]['value'] ?>" alt="">
                        <?php endif; ?>
                    <?php else: ?>
                        <img src="/img/Rectangle 18.png" alt="">
                    <?php endif; ?>
                </div>
                <div class="set_data">
                    <p>
                    <?php echo $meta['description'] ?>
                    </p>
                    <div class="set-raiting">
                    <?= Raite::widget(['id' => $product->id]);?>
                    </div>
                </div>
            </div>
            <div class="data_active">
                <a href="/<?= $lang?>/user/info-product/list/<?= $product_link?>">Расписание</a>
                <a href="">Чат курса</a>
            </div>
        </div>
    </div>
</div>