<?php
use app\models\InfoStep;
use app\models\Product;
if (isset($dataProduct['date']) && !empty($dataProduct['date'])) {
    $letTime = $dataProduct['date'];
} else {
    $letTime = time();
}
?>
<div class="loaddebug" style="display:none">
        123123123
    <?php
    debug($item['id']);
    var_dump(Product::getAccessDes($item['info_id']));
    ?>
    </div>
<?php Product::getAccessDes($item['info_id'])?>
<?php if (!empty($item['time']) && $item['time'] != 0) {
    $date_end = strtotime('+' . $item['time'] . ' day', $letTime);
    $timer = time();
    $date = date("Y-m-d", $date_end);
    if(!empty($item['hourse'])){
        $date = $date." ".$item['hourse'].":00";
    }
    $d1 = strtotime($date); 
    ?>

    

    <?php if ($timer > $d1): ?>
        <?php if(InfoStep::getDescsStaticPrevent($item['id']) == 1 && Product::getAccessDes($item['info_id'])){
                $label = '<p class="lesson_course__status">'.Yii::t('app', 'view-false').'</p>';
                $status = 'lesson_expectation';
                $link = "https://anticandida.com/{$lang}/user/info-product/list/{$product_link}/{$item['id']}";
            }else if(InfoStep::getDescsStaticPrevent($item['id']) == 2 || !Product::getAccessDes($item['info_id'])){
                $label = '<p class="lesson_course__status">'.Yii::t('app', 'view-false').'</p>';
                $status = 'lesson_disabled view';
                $link = '';
            }else{
                $status = 'lesson_expectation';
                $link = "https://anticandida.com/{$lang}/user/info-product/list/{$product_link}/{$item['id']}";
            }?>
        <a href="<?= $link?>"
            class="lesson_course <?= $status;?> <?= (InfoStep::checkData($item['id'])? ' view ' : '')?> referInfoc"
            data-link="<?= $link?>">
            <div class="lesson_course__arrow">
                <img src="/asset/images/arrow-lesson.svg" alt="">
            </div>
            <div class="lesson_course__content">
                <div>
                    <p class="lc_content__status">
                        <?php if (!empty($item['time'])): ?>
                            <?= Yii::t('app', 'Time-Start') ?>
                            <?php
                            echo date("d.m.Y", $date_end);
                            ?>
                        <?php endif; ?>
                        <?php if (!empty($item['hourse'])): ?>
                            <?php echo " - " . $item['hourse']; ?>
                        <?php endif; ?>
                    </p>
                    <p class="lc_content__name">
                        <?= $item['title']; ?>
                    </p>
                </div>
                <p class="lesson_course__status"><?php if(InfoStep::checkData($item['id'])){
                    echo Yii::t('app', 'view-true');
                }else{
                    echo Yii::t('app', 'view-false');
                }?></p>
            </div>
        </a>
    <?php else: ?>
        <a href="https://anticandida.com/<?= $lang ?>/user/info-product/list/<?= $product_link ?>/<?= $item['id'] ?>"
            class="lesson_course lesson_disabled view" data-link="/<?= $lang ?>/user/info-product/list/<?= $product_link ?>/<?= $item['id'] ?>">
            <div class="lesson_course__arrow">
                <img src="/asset/images/arrow-lesson.svg" alt="">
            </div>
            <div class="lesson_course__content">
                <div>
                    <p class="lc_content__status">
                        <?= Yii::t('app', 'Time-Start') ?> 
                        <?php echo date("d.m.Y", $date_end);?>
                        <?php if (!empty($item['hourse'])): ?>
                            <?php echo " - " . $item['hourse']; ?>
                        <?php endif; ?>
                    </p>
                    <p class="lc_content__name">
                        <?= $item['title']; ?>
                    </p>
                </div>
            </div>
        </a>
    <?php endif; ?>
<?php } else { ?>


    <?php if(Product::getAccessDes($item['info_id'])):?>
        
    <?php if($item['disc'] == 1 && InfoStep::getDescsStatic($item['id']) ){
        $status = 'lesson_complete';
        $label = '<p class="lesson_course__status">'.Yii::t("app", "view-complate").'</p>';
        $link = "https://anticandida.com/{$lang}/user/info-product/list/{$product_link}/{$item['id']}";
    }else if($item['disc'] == 1 && !InfoStep::getDescsStatic($item['id'])){
        $status = 'lesson_no_complete';
        $label = '<p class="lesson_course__status">'.Yii::t("app", "view-no-complate").'</p>';
        $link = "https://anticandida.com/{$lang}/user/info-product/list/{$product_link}/{$item['id']}";
    }else{
        if(InfoStep::checkData($item['id'])){
            $label = '<p class="lesson_course__status">'.Yii::t("app", "view-true").'</p>';
            $status = 'lesson_expectation view';
            $link = "https://anticandida.com/{$lang}/user/info-product/list/{$product_link}/{$item['id']}";
        }else{
            if(InfoStep::getDescsStaticPrevent($item['id']) == 1){
                $label = '<p class="lesson_course__status">'.Yii::t('app', 'view-false').'</p>';
                $status = 'lesson_expectation';
                $link = "https://anticandida.com/{$lang}/user/info-product/list/{$product_link}/{$item['id']}";
            }elseif(InfoStep::getDescsStaticPrevent($item['id']) == 2){
                $label = '<p class="lesson_course__status">'.Yii::t('app', 'view-false').'</p>';
                $status = 'lesson_disabled view';
                $link = "";
            }else{
                $label = '<p class="lesson_course__status">'.Yii::t('app', 'view-false').'</p>';
                $status = 'lesson_expectation';
                $link = "https://anticandida.com/{$lang}/user/info-product/list/{$product_link}/{$item['id']}";
            }
        }
    }?>
    <?php else:?>

        <?php if($item['disc'] != '1'):?>
        <?php 
            $label = '<p class="lesson_course__status">'.Yii::t('app', 'view-false').'</p>';
            $status = 'lesson_disabled view';
            $link = "https://anticandida.com/";
            ?>
        <?else:?>
            <?php
            $status = 'lesson_no_complete';
            $label = '<p class="lesson_course__status">'.Yii::t("app", "view-no-complate").'</p>';
            $link = "https://anticandida.com/{$lang}/user/info-product/list/{$product_link}/{$item['id']}";
                ?>
            <?php endif;?>
    <?php endif;?>
    <a href="<?= $link?>" class="lesson_course <?= $status;?> referInfoc" data-link="<?= $link?>">
        <div class="lesson_course__arrow">
            <img src="/asset/images/arrow-lesson.svg" alt="">
        </div>
        <div class="lesson_course__content">
            <div>
                <p class="lc_content__status">
                    <?php if($item['disc'] != 1):?>
                        <?= Yii::t('app', 'Time-Start') ?> <?= date('d.m.Y', $letTime);?>
                    <?php endif;?>
                    <?php if(InfoStep::getDescsStatic($item['id'])):?>
                            <?= ($item['disc'] == 1 ? Yii::t('app', 'dessc-success') : '')?>
                        <?php else:?>
                            <?= ($item['disc'] == 1 ? Yii::t('app', 'dessc-fail') : '')?>
                        <?php endif?>
                </p>
                <p class="lc_content__name">
                    <?= $item['title']; ?>
                </p>
            </div>
            <?= $label;?>
        </div>
    </a>
<?php } ?>