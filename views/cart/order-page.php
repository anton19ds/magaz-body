<?php
use app\models\SettingData;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
?>
<?= $this->render('../layouts/header-banner')?>
<input type="hidden" id="currensy" value="<?= $currensy ?>">

<?php $form = ActiveForm::begin([
    'id' => 'form-order'
]); ?>
<?php

function getValue($cart, $type, $adressSet = null)
{
    if (isset($cart['user'][$type]) && !empty($cart['user'][$type])) {
        return $cart['user'][$type];
    }
}
?>

<main>
    <div class="container_ordering">
        <div class="ordering__main">
            <div class="ordering_main__img">
            <?php $logo = SettingData::getValue('logo');
                    $array = json_decode($logo, true);
                    ?>
                    <img src="<?= $array['array'][1]['value']?>" alt="" />
            </div>
            <div class="ordering_main__steps">
                <span><a href="/<?= $currensy ?>/cart">
                        <?= Yii::t('app', 'cart-txt') ?>
                    </a></span>
                <span class="active"><a href="/<?= $currensy ?>/order">
                        <?= Yii::t('app', 'contact-information') ?>
                    </a></span>
                <span><a href="/<?= $currensy ?>/delivery">
                        <?= Yii::t('app', 'delivery-method') ?>
                    </a></span>
                <span><a href="/<?= $currensy ?>/payment">
                        <?= Yii::t('app', 'payment-method') ?>
                    </a></span>
            </div>
            
                <div class="contact_info__section">
                    <div class="flex_p_cis">
                        <h5><?= Yii::t('app', 'contact-information') ?> </h5>
                        <p>
                            <?= Yii::t('app', 'login-title')?><a href="/<?= $currensy?>/login?page=order"><?= Yii::t('app', 'in-log')?></a>
                        </p>
                    </div>


                    <div class="diss-alert" role="alert" id="dataAlertDiss">
                        <?= Yii::t('app', 'user-invalid')?>
                    
                    </div>
                    <div class="ordering_form__section">
                        <div class="ordering_form_section__item">
                            <div class="ordering_form_section__item-inp">
                                <label for="e-mail" style="<?= (getValue($cart, 'email') ? 'top: 7px; font-size: 14px;' : '')?>">E-mail</label>
                                <input type="text" name="email" id="e-mail" value="<?php echo getValue($cart, 'email'); ?>">
                            </div>
                            <p class="ordering_form_section__item-check">
                                <input type="checkbox" name="messages_for_sale" class="check_cont_ordering"
                                    id="messages_for_sale" checked>
                                <label for="messages_for_sale"><?= Yii::t('app', 'sms-label')?></label>
                            </p>
                            <p class="error_contact_info">
                            <?= Yii::t('app','validate-email')?>
                            </p>
                        </div>
                        <div class="ordering_form_section__item">
                            <div class="ordering_form_section__item-inp">
                                <label for="phone" style="<?= (getValue($cart, 'phone') ? 'top: 7px; font-size: 14px;' : '')?>">
                                <?= Yii::t('app', 'placeholder-phone') ?>
                                
                                </label>
                                <input type="text" name="phone" id="phone" value="<?php echo getValue($cart, 'phone'); ?>">
                                <p class="question_inp">
                                    <img src="/frontStyle/assets/images/help_circle.svg" alt="">
                                    <span>
                                    <?= Yii::t('app', 'validate-phone')?>
                                    </span>
                                </p>
                            </div>
                            <p class="error_contact_info">
                            <?= Yii::t('app','validate-set-phone')?>
                            </p>
                            <p class="ordering_form_section__item-check sms_messages_checkbox">
                                <input type="checkbox" name="sms_messages" class="check_cont_ordering" id="sms_messages"
                                    checked>
                                <label for="sms_messages">
                                <span><?= Yii::t('app', 'sms-message-title')?></span>
                                    <?= Yii::t('app', 'sms-message')?>
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="contact_info__section">
                    <div class="flex_p_cis">
                        <h5>
                            <?= Yii::t('app', 'placeholder-adress-delivey')?>
                        </h5>
                    </div>
                    <div class="form_pers-data__inputs">
                        <p class="form_w100">
                            <input type="text" id="country" value="<?php echo getValue($cart, 'country'); ?>" name="country" placeholder="  ">
                            <label for="country" style="<?= (getValue($cart, 'country') ? 'top: 7px; font-size: 14px;' : '')?>"><?= Yii::t('app', 'county')?></label>
                            <span class="form_pers-data__inputs-error"><?= Yii::t('app', 'validate-country')?></span>
                        </p>
                        <p class="form_w50" id="block-input-postcode">
                            <input type="text" id="index_number" value="<?php echo getValue($cart, 'postcode'); ?>" name="postcode" placeholder="  ">
                            <label for="index_number" style="<?= (getValue($cart, 'postcode') ? 'top: 7px; font-size: 14px;' : '')?>"><?= Yii::t('app', 'postcode')?></label>
                            <span class="form_pers-data__inputs-error">
                            <?= Yii::t('app', 'set-postcode')?>
                            </span>
                        </p>
                        <p class="form_w50">
                            <input type="text" id="region" value="<?php echo getValue($cart, 'area'); ?>" name="area" placeholder="  ">
                            <label for="region" style="<?= (getValue($cart, 'area') ? 'top: 7px; font-size: 14px;' : '')?>"><?= Yii::t('app', 'area')?></label>
                            <span class="form_pers-data__inputs-error"><?= Yii::t('app', 'set-area')?></span>
                        </p>
                        <p class="form_w50">
                            <input type="text" id="city" name="city" value="<?php echo getValue($cart, 'city'); ?>" placeholder="  ">
                            <label for="city" style="<?= (getValue($cart, 'city') ? 'top: 7px; font-size: 14px;' : '')?>"><?= Yii::t('app', 'city')?></label>
                            <span class="form_pers-data__inputs-error"><?= Yii::t('app', 'set-city')?></span>
                        </p>
                        <p class="form_w50">
                            <input type="text" id="street" name="street" value="<?php echo getValue($cart, 'street'); ?>" placeholder="  ">
                            <label for="street" style="<?= (getValue($cart, 'street') ? 'top: 7px; font-size: 14px;' : '')?>"><?= Yii::t('app', 'street')?></label>
                            <span class="form_pers-data__inputs-error"><?= Yii::t('app', 'set-street')?></span>
                        </p>
                        <p class="form_w100">
                            <input type="text" id="address" name="house" value="<?php echo getValue($cart, 'house'); ?>" placeholder="  ">
                            <label for="address" style="<?= (getValue($cart, 'house') ? 'top: 7px; font-size: 14px;' : '')?>"><?= Yii::t('app', 'house')?></label>
                            <span class="form_pers-data__inputs-error"><?= Yii::t('app', 'set-data')?></span>
                        </p>
                        <p class="form_w33">
                            <input type="text" id="surname" name="surname" value="<?php echo getValue($cart, 'surname'); ?>" placeholder="  ">
                            <label for="surname" style="<?= (getValue($cart, 'surname') ? 'top: 7px; font-size: 14px;' : '')?>"><?= Yii::t('app', 'surname')?></label>
                            <span class="form_pers-data__inputs-error"><?= Yii::t('app', 'set-surname')?></span>
                        </p>
                        <p class="form_w33">
                            <input type="text" id="name" name="name" value="<?php echo getValue($cart, 'name'); ?>" placeholder="  ">
                            <label for="name" style="<?= (getValue($cart, 'name') ? 'top: 7px; font-size: 14px;' : '')?>"><?= Yii::t('app', 'placeholder-name')?></label>
                            <span class="form_pers-data__inputs-error"><?= Yii::t('app', 'set-name')?></span>
                        </p>
                        <p class="form_w33">
                            <input type="text" id="fname" name="lastname" value="<?php echo getValue($cart, 'lastname'); ?>" placeholder="  ">
                            <label for="fname" style="<?= (getValue($cart, 'lastname') ? 'top: 7px; font-size: 14px;' : '')?>"><?= Yii::t('app', 'lastname')?></label>
                            <span class="form_pers-data__inputs-error"><?= Yii::t('app', 'set-lastname')?></span>
                        </p>
                        <p class="form_w100">
                            <textarea name="comment" id="comment" rows="3"></textarea>
                            <label for="comment"><?= Yii::t('app', 'comment')?></label>
                        </p>
                    </div>
                </div>
                <div class="contact_info_submit">
                    <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $currensy?>/cart" data-lang="<?= $currensy ?>" data-link="cart" id="NextStepOrder">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.3569 2.34375L4.7002 8.00042L10.3569 13.6571L11.3002 12.7144L6.58553 8.00042L11.3002 3.28642L10.3569 2.34375Z"
                                fill="#00A6CA" />
                        </svg>
                        <?= Yii::t('app', 'return-in-cart') ?>
                    </a>
                    <input type="submit" value="<?= Yii::t('app', 'next-btn')?>" id='send-form' data-lang="<?= $currensy?>" data-link="delivery">
                </div>
        </div>
        <div class="ordering__sidebar">
            <div class="ordering__sidebar-cart">
            <?= $this->render('min-cart', [
                'cart' => $cart,
                'currensy' => $currensy,
                'lang' => $lang,
                'product' => $product
            ]) ?>
                
            </div>
        </div>
    </div>
</main>
<?php ActiveForm::end(); ?>



<script>
    window.addEventListener('load', function () {
        parent.postMessage({
            he : document.documentElement.scrollHeight,
            path: document.location.pathname,
        }, '*');
    });
</script>


<?php $this->registerJs('
$(document).on("click","#NextStepOrder", function(e){
    e.preventDefault();
    var lang = $(this).data("lang");
    var link = $(this).data("link");
    parent.postMessage({
        lang : lang,
        link: link,
    }, "*");
})
')?>