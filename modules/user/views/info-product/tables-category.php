<?php
use app\models\Product;

$first = [
    'status' => true
];
if($step->getFirstStep()){
    $first = $step->getFirstStep()->getStatusDate();
}

$imageStep = "/adminStyle/assets/img/no-image.png";
if (!empty($step->img)) {
    $imageStepArray = json_decode($step->img, true);
    if (isset($imageStepArray['array'][1]['value']) && $imageStepArray['array'][1]['value']) {
        $imageStep = $imageStepArray['array'][1]['value'];
    }
}
?>
<?php
$open = true;
if($first['status']){
    if(!Product::getAccessDes($step->infoproduct_id)){
        if(Product::gehasDesk($step->infoproduct_id, $step->id)){
            $open = true;
        }else{
            $open = false;
        }
    }else{
        $open = true;
    }
}else{
    $open = false;
}?>
<?php if ($open): ?>

    <div class="list-modules__item list-modules__item-active">
        <a href="https://anticandida.com/<?= $lang ?>/user/info-product/list/<?= $step['id'] ?>" data-set-link="https://anticandida.com/<?= $lang ?>/user/info-product/list/<?= $step['id'] ?>">
            <div class="item_modules__img">
                <?php if ($imageStep): ?>
                    <img src="<?= $imageStep ?>" alt="">
                <?php endif; ?>
            </div>
            <p class="item_modules__title">
                <?= $step->title ?>
            </p>
            <p class="item_modules__count-lessons">
                <?= $step->countStep() ?>
                <?= Yii::t('app', 'lessons') ?>
            </p>
            <?php
            $steRg = $step->step;
            $procents = count($steRg);
            $sertY = 0;
            $hart = 0;
            foreach ($steRg as $elem) {
                if ($elem->check) {
                    $sertY = $sertY + 1;
                }
            }
            if ($sertY != 0) {
                $hart = $sertY / ($procents / 100);
            }
            ?>
            <?php if ($hart == 100): ?>
                <p class="item_modules__status">
                    <?= Yii::t('app', "step-true") ?>
                </p>
            <?php else: ?>
                <p class="item_modules__status">
                    <?= Yii::t('app', "step-false") ?>
                </p>
            <?php endif; ?>

            <div class="item_modules__progress">
                <span style="width: <?= $hart ?>%"></span>
            </div>

        </a>
    </div>
<?php else: ?>
    <div class="list-modules__item list-modules__item-close">
        <a href="#">
            <div class="item_modules__img">
                <?php if ($imageStep): ?>
                    <img src="<?= $imageStep ?>" alt="">
                <?php endif; ?>
            </div>
            <p class="item_modules__title">
                <?= $step->title ?>
            </p>
            <p class="item_modules__count-lessons">
                <?= $step->countStep() ?>
                <?= Yii::t('app', 'lessons') ?>
            </p>
            <p class="item_modules__status">
                <?php try{?>
                    <?php if(isset($first['date_end']) && $first['date_end'] != 0):?>
                    <?= Yii::t('app', "data-step-open") ?> <?= date('d.m.Y', $first['date_end'])?>
                    <?php else:?>
                        <?= Yii::t('app', "data-step-open") ?> <?= date('d.m.Y')?>
                    <?php endif;?>
                <?php }catch(Exception $e){?>
                <?php }?>
            </p>
            <div class="item_modules__progress">
                <span style="width: 0%"></span>
            </div>
        </a>
    </div>
<?php endif ?>