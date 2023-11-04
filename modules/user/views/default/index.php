<?php
use yii\bootstrap5\Modal;

?>


<div id="user_page">
    <div class="left_block">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'user'
        ]) ?>
    </div>
    <div class="right_block">
        <div class="breadcrambs">
            <ul>
                <li><a href="">Магазин</a></li>
                <li><a href="">Список заказов</a></li>
            </ul>
        </div>
        <?php $order = $user->getOrders() ?>
        <?php if (!empty($order)): ?>
            <div class="block-title-page">
                Спосок заказов
            </div>
            <table class="order_user_list">
                <tr>
                    <th style="text-align: center;">#</th>
                    <th>uuid</th>
                    <th style="text-align: center;">В заказе</th>
                    <th style="text-align: center;">Дата заказа</th>
                </tr>
                <?php if ($order): ?>
                    <?php $chet = 1; ?>
                    <?php foreach ($order as $key => $element): ?>
                        <tr>
                            <td class="numb">
                                <?= $chet ?>
                            </td>
                            <td>
                                <a href="#" class="view-product" data-uuid="<?= $element->uuid; ?>" data-lang="<?= $lang; ?>">
                                    №
                                    <?= $element->uuid; ?>
                                </a>
                            </td>
                            <td class="date-set">
                                <?php echo $element->orderInfo() ?>
                            </td>

                            <td class="date-set">
                                <?php echo date('Y-m-d H:s', $element->date); ?>
                            </td>
                        </tr>
                        <?php $chet++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        <?php endif; ?>
    </div>
</div>


<?php Modal::begin([
    'id' => 'view_product',
    'size' => 'modal-lg'
]) ?>

<?php Modal::end(); ?>