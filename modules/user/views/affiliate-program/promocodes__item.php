<?php
use app\models\PromoUserSize;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php
try {
    $lavelDefaultSize = ArrayHelper::map(ArrayHelper::toArray($user->userLavel->categoryLavel), 'category_promo_id', 'size');
} catch (Exception $e) {

}
// debug($lavelDefaultSize);

?>
<?php foreach ($userPromo as $item): ?>
    <?php $form = ActiveForm::begin([
        'id' => 'promo_' . $item->id
    ]) ?>

    <?php

    $arraySize = array();
    foreach (ArrayHelper::toArray($item->promoUserSize) as $elem) {
        $arraySize[$elem['type']][$elem['category_promo_id']] = $elem;
    }
    // debug($arraySize);
    //debug($user->userLavel->lavel_id);
    //debug($item->lavel_id);

    if ($user->userLavel->lavel_id > $item->lavel_id) {
        $classType = 'new_group';
        $infotop = '<div class="promocode_system_top">' .
            '<div>' .
            '<p>' . Yii::t('app', "promo-desc-27") . '</p>' .
            '<p>' . Yii::t('app', "promo-desc-28") . '</p>' .
            '</div>' .
            '<div class="promocode_system_top__buttons">' . Html::submitButton(Yii::t('app', "save"), ['class' => 'sends-btn']) . '</div></div>';

    } else if ($user->userLavel->lavel_id < $item->lavel_id) {
        $classType = 'change_precents_delete';
        $infotop = '<div class="promocode_system_top">
        <div>
            <p>' . Yii::t('app', "promo-desc-29") . '</p>
        </div>
        <div class="promocode_system_top__buttons">
            <a href="#" class="delete_promocode_link" data-id="'.$item->id.'">' . Yii::t('app', 'delete') . '</a>
        </div>
    </div>';

    } else if ($user->userLavel->lavel_id == $item->lavel_id) {
        $classType = '';
        $infotop = '';
    }
    ?>

    <div class="promocodes__item <?= $classType; ?>">
        <!-- promocodes__item new_group -->
        <?= $infotop ?>


        <div class="promocode__top">

            <div>
                <div>
                    <p class="promocode_question">
                        <img src="/asset/images/question.svg" alt="">
                        <span>
                            <?= Yii::t('app', 'desc-promo-2') ?>
                        </span>
                    </p>
                    <p>
                        <span class="bold">
                            <?= Yii::t('app', "promocod") ?>: <span class="promocode_name">
                                <?= $item->name ?>
                            </span>
                        </span>
                    </p>
                </div>
            </div>
            <div>
                <div>
                    <p class="promocode_question">
                        <img src="/asset/images/question.svg" alt="">
                        <span>
                            <?= Yii::t('app', 'desc-promo-3') ?>
                        </span>
                    </p>
                    <p>
                        <span class="bold">
                            <?= Yii::t('app', 'ref-link') ?>:
                        </span>
                        <span class="ref_link" data-link="<?php echo"https://anticandida.com/"?><?= $lang ?>/p/<?= $item->name ?>">anticandida.com/<?= $lang ?>/p/<span><?= $item->name ?></span></span>
                        <span class="copy_icon" data-link="<?php echo"https://anticandida.com/"?><?= $lang ?>/p/<?= $item->name ?>" data-name="<?= $item->name ?>">
                            <img src="/asset/images/copy.svg" alt="" data-link="<?php echo"https://anticandida.com/"?><?= $lang ?>/p/<?= $item->name ?>" data-name="<?= $item->name ?>">
                            <span class="yes_copied <?= $item->name ?>">
                                <?= Yii::t('app', 'copied') ?>
                            </span>
                        </span>
                    </p>
                </div>
                <div>
                    <p class="promocode_question">
                        <img src="/asset/images/question.svg" alt="">
                        <span>
                            <?= Yii::t('app', 'desc-promo-4') ?>
                        </span>
                    </p>
                    <p>
                        <span class="bold"> 
                            <?= Yii::t('app', 'sell-link') ?>:
                        </span>
                        <?php 
                        $link = $lang;
                        if(!empty($item->link)){
                            $setArray = explode("/", $item->link);
                            if(isset($setArray[0]) && !empty($setArray[0]) && ($setArray[0] == 'ru' || $setArray[0] == 'cs' || $setArray[0] == 'en')){
                                $link = $item->link;
                            }
                        }
                        
                        
                        
                        ?>
                        <span class="targ_link">anticandida.com/<span><?= $link ?></span></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="table_promocodes">
            <div class="table_promocodes__head">
                <div class="promocode_line">

                    <p class="tovar_group">
                        <span class="promocode_question">
                            <img src="/asset/images/question.svg" alt="">
                            <span>
                                <?= Yii::t('app', "promo-desc-11") ?>
                            </span>
                        </span>
                        <span class="promocode_line__title">
                            <?= Yii::t('app', "desc-promo-6") ?>
                        </span>
                    </p>
                    <p class="sale_client">
                        <span class="promocode_question">
                            <img src="/asset/images/question.svg" alt="">
                            <span>
                                <?= Yii::t('app', "promo-desc-7") ?>
                            </span>
                        </span>
                        <span class="promocode_line__title">
                            <?= Yii::t('app', "promo-desc-24") ?>
                        </span>
                    </p>
                    <p class="rewards_buy">
                        <span class="promocode_question">
                            <img src="/asset/images/question.svg" alt="">
                            <span>
                                <?= Yii::t('app', "promo-desc-9") ?>
                            </span>

                        </span>
                        <span class="promocode_line__title">
                            <?= Yii::t('app', "promo-desc-25") ?>
                        </span>
                    </p>
                    <p class="summ_percent">
                        <span class="promocode_question">
                            <img src="/asset/images/question.svg" alt="">
                            <span>
                                <?= Yii::t('app', "promo-desc-22") ?>
                            </span>
                        </span>
                        <span class="promocode_line__title">
                            <?= Yii::t('app', "promo-desc-23") ?>
                        </span>
                    </p>
                </div>
            </div>
            <div class="table_promocodes__body type_new_group">
                <?php if ($classType == 'new_group'): ?>
                    <input type="hidden" value="<?= $item->id ?>" name="id">
                    <div class="promocode_line">
                        <p class="tovar_group">
                            <?= Yii::t('app', "promo-desc-26") ?>
                        </p>
                        <p class="sale_client"><input type="number" name="simple[2]" data-summ="<?= $lavelDefaultSize['1'] ?>"
                                group_percent="1" placeholder="0%" value="<?= $arraySize['2']['1']['size'] ?>"></p>
                        <p class="rewards_buy"><input type="number" name="simple[1]" data-summ="<?= $lavelDefaultSize['1'] ?>"
                                group_percent="1" placeholder="0%" value="<?= $arraySize['1']['1']['size'] ?>"></p>
                        <p class="summ_percent">
                            <?= $lavelDefaultSize['1'] ?>%
                        </p>
                        <span class="percent_error percent_error_big">
                            <?= Yii::t('app', "promo-desc-14") ?>
                        </span>
                        <span class="percent_error percent_error_small">
                            <?= Yii::t('app', "promo-desc-15") ?>
                        </span>
                    </div>
                    <div class="promocode_line">
                        <p class="tovar_group"> 
                            <?= Yii::t('app', 'info-products') ?>
                        </p>
                        <p class="sale_client"><input type="number" name="info[2]" data-summ="<?= $lavelDefaultSize['2'] ?>"
                                group_percent="2" placeholder="0%" value="<?= $arraySize['2']['2']['size'] ?>"></p>
                        <p class="rewards_buy"><input type="number" name="info[1]" data-summ="<?= $lavelDefaultSize['2'] ?>"
                                group_percent="2" placeholder="0%" value="<?= $arraySize['1']['2']['size'] ?>"></p>
                        <p class="summ_percent">
                            <?= $lavelDefaultSize['2'] ?>%
                        </p>
                        <span class="percent_error percent_error_big">
                            <?= Yii::t('app', "promo-desc-14") ?>
                        </span>
                        <span class="percent_error percent_error_small">
                            <?= Yii::t('app', "promo-desc-15") ?>
                        </span>
                    </div>
                    <div class="promocode_line">
                        <p class="tovar_group">
                            <?= Yii::t('app', 'promo-desc-262') ?>
                        </p>
                        <p class="sale_client"><input type="number" name="services[2]" data-summ="<?= $lavelDefaultSize['3'] ?>"
                                group_percent="3" placeholder="0%" value="<?= $arraySize['2']['3']['size'] ?>"></p>
                        <p class="rewards_buy"><input type="number" name="services[1]" data-summ="<?= $lavelDefaultSize['3'] ?>"
                                group_percent="3" placeholder="0%" value="<?= $arraySize['1']['3']['size'] ?>"></p>
                        <p class="summ_percent">
                            <?= $lavelDefaultSize['3'] ?>%
                        </p>
                        <span class="percent_error percent_error_big">
                            <?= Yii::t('app', "promo-desc-14") ?>
                        </span>
                        <span class="percent_error percent_error_small">
                            <?= Yii::t('app', "promo-desc-15") ?>
                        </span>
                    </div>

                <?php else: ?>
                    <div class="promocode_line">
                        <p class="tovar_group">
                            <?= Yii::t('app', "promo-desc-26") ?>
                        </p>
                        <p class="sale_client">
                            <?= $arraySize['2']['1']['size'] ?>%
                        </p>
                        <p class="rewards_buy">
                            <?= $arraySize['1']['1']['size'] ?>%
                        </p>
                        <p class="summ_percent">
                            <?= $lavelDefaultSize['1'] ?>%
                        </p>
                    </div>
                    <div class="promocode_line info-product-table">
                        <p class="tovar_group info-product">
                            <?= Yii::t('app', 'info-products') ?>
                        </p>
                        <p class="sale_client">
                            <?= $arraySize['2']['2']['size'] ?>%
                        </p>
                        <p class="rewards_buy">
                            <?= $arraySize['1']['2']['size'] ?>%
                        </p>
                        <p class="summ_percent">
                            <?= $lavelDefaultSize['2'] ?>%
                        </p>
                    </div>

                    <div class="promocode_line">
                        <p class="tovar_group">
                            <?= Yii::t('app', 'promo-desc-262') ?>
                        </p>
                        <p class="sale_client">
                            <?= $arraySize['2']['3']['size'] ?>%
                        </p>
                        <p class="rewards_buy">
                            <?= $arraySize['1']['3']['size'] ?>%
                        </p>
                        <p class="summ_percent">
                            <?= $lavelDefaultSize['3'] ?>%
                        </p>
                    </div>

                <?php endif; ?>


                <!--  -->


                <!-- <div class="promocode_line">
                    <p class="tovar_group">Мед. услуги</p>
                    <p class="sale_client">3%</p>
                    <p class="rewards_buy">10%</p>
                    <p class="summ_percent">13%</p>
                </div> -->
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
<?php endforeach; ?>

<style>
    .new_group .promocode_system_top__buttons .sends-btn {
        color: #00A6CA;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.14px;
        width: 90px;
        height: 35px;
        border-radius: 3px;
        border: 2px solid #00A6CA;
        transition: 0.2s ease;
    }

    .new_group .promocode_system_top__buttons .sends-btn:hover {
        background: #00A6CA;
        color: #FFF;
    }
</style>