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

    <div class="breadcrambs">
            <ul>
                <li><a href="">Магазин</a></li>
                <li><a href="">Инфопродукты</a></li>
                <li><a href="">
                        <?= $meta['productName'] ?>
                    </a></li>
            </ul>
        </div>

        <div class="block-title-page">
            <?= $meta['productName'] ?>
        </div>


        <?php $keyS = 0;?>
        <?php foreach ($stepInfo as $key => $item): ?>
            <?php if($item->getCheck()){
                $add = null;
                $keyS = $key + 1;
            }else{
                $add = 'no-step';
            }?>
            
            <div class="step <?= $add?> <?= ($keyS == $key ? 'next' : '')?>" data-id="<?= $item->id?>">
                <div class="left"></div>
                <div class="right">
                    <p>
                    <span>Необходимо выполнить задание</span><br>
                    <?= $item->title; ?>
                    </p>
                    <div class="btn-active">
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>