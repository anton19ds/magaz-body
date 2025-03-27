<?php
use app\models\InfoStepLang;
$imageStep = null;
if (!empty($step['img'])) {
    $imageStepArray = json_decode($step['img'], true);
    $imageStep = $imageStepArray['array'][1]['value'];
}
?>
<?php if($lang == 'ru'):?>
<div class="list-modules__item list-modules__item-close">
    <a href="#">
        <div class="item_modules__img">
            <?php if ($imageStep): ?>
                <img src="<?= $imageStep ?>" alt="">
            <?php endif; ?>
        </div>
        <p class="item_modules__title">
            <?= $step['title'] ?>
        </p>
        <p class="item_modules__count-lessons">
        <?= $step->countStep()?> <?= Yii::t('app', 'lessons')?>
        </p>
        <p class="item_modules__status">
        <?= Yii::t('app', 'active-for-sale')?>
        </p>
        <div class="item_modules__progress">
            <span></span>
        </div>
    </a>
</div>
<?php else:?>
    <?php if(InfoStepLang::find()->where(['info_id' => $step['id']])->andWhere(['tag' => $lang])->exists()){
        $stepData = InfoStepLang::find()->where(['info_id' => $step['id']])->andWhere(['tag' => $lang])->asArray()->one();
        }?>
<div class="list-modules__item list-modules__item-close">
    <a href="#">
        <div class="item_modules__img">
            <?php if ($imageStep): ?>
                <img src="<?= $imageStep ?>" alt="">
            <?php endif; ?>
        </div>
        <p class="item_modules__title">
            <?= $step['title'] ?>
        </p>
        <p class="item_modules__count-lessons">
            <?= $step->countStep()?> <?= Yii::t('app', 'lessons')?>
        </p>
        <p class="item_modules__status">
        <?= Yii::t('app', 'active-for-sale')?>
        </p>
        <div class="item_modules__progress">
            <span></span>
        </div>
    </a>
</div>
<?php endif;?>