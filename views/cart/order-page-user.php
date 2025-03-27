<?php
use app\models\SettingData;
use app\models\UserAdress;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>
<?= $this->render('../layouts/header-banner')?>
<input type="hidden" id="currensy" value="<?= $currensy ?>">
<?php
$adressSet = '';
if (isset($cart['user']['activeAdress'])) {
    $adressSet = UserAdress::find()->where(['id' => $cart['user']['activeAdress']])->asArray()->one();
}

function getValue($cart, $type, $adressSet = null)
{
    if (isset($cart['user'][$type]) && !empty($cart['user'][$type])) {
        return $cart['user'][$type];
    } else {
        if (isset($cart['user']['activeAdress'])) {
            //return '123';
            if ($type == 'house') {
                $type = 'flat';
            }
            if (!empty($adressSet) && isset($adressSet[$type])) {
                return $adressSet[$type];
            }
        }
    }
    return null;
}
$active = [
    0 => '',
    1 => '',
];
if(!isset($cart['user'])){
    $active = [
        'checked',
        'active'
    ];
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
            <?php $form = ActiveForm::begin([
                'id' => 'form-order'
            ]); ?>
            <!-- <form action="#" class="contact_info_ordering_form"> -->
            <div class="contact_info__section">
                <div class="flex_p_cis">
                    <h5>
                        <?= Yii::t('app', 'contact-information') ?>
                    </h5>
                    <p>
                        <a href="#">
                            <?= $user->email ?>
                        </a>
                    </p>
                </div>
                <div class="delivery_addresses__list">
                    <?php $userAdress = $user->userAdress; ?>

                    <?php if (!empty($userAdress)): ?>
                        <?php foreach ($userAdress as $item): ?>
                            <label for="adress<?= $item->id ?>"
                                class="delivery_address_item <?= (isset($cart['user']['activeAdress']) && $cart['user']['activeAdress'] == $item->id ? 'active' : '') ?>"
                                id="<?= $item->id ?>">
                                <input type="radio" value="<?= $item->id ?>" name="activeAdress" id="adress<?= $item->id ?>"
                                    style="display:none" <?= (isset($cart['user']['activeAdress']) && $cart['user']['activeAdress'] == $item->id ? 'checked' : '') ?>>
                                <div class="checkbox_variable_address"></div>
                                <div class="delivery_address_item__info">
                                    <p>
                                        <span class="del_address__surname">
                                            <?= $item->surname ?>
                                        </span>
                                        <span class="del_address__name">
                                            <?= $item->name ?>
                                        </span>
                                        <span class="del_address__fname">
                                        <?= $item->lastname ?>
                                        </span>
                                    </p>
                                    <p>
                                        <span class="del_address__index">
                                            <?= $item->postcode; ?></span>,
                                        <span class="del_address__country">
                                            <?= $item->country; ?></span>,
                                        <span class="del_address__region">
                                            <?= $item->area; ?></span>,
                                        <span class="del_address__city">
                                            <?= $item->city; ?></span>,
                                        <span class="del_address__street">
                                            <?= $item->street; ?></span>,
                                        <span class="del_address__address">
                                            <?= $item->flat; ?>
                                        </span>
                                    </p>
                                    <p>
                                        <span class="del_address__phone">
                                            <?= $user->phone ?>
                                        </span>
                                    </p>
                                    <p>
                                        <span class="del_address__email">
                                            <?= $user->email ?>
                                        </span>
                                    </p>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <label for="newAdress" class="new_delivery_address <?= (empty($userAdress) || (isset($cart['user']['activeAdress']) && $cart['user']['activeAdress'] == 'newAdress')? 'active' : '')?> <?= $active[1]?>">
                        <input type="radio" name="activeAdress" value="newAdress" id="newAdress" style="display:none" <?= (empty($userAdress) || (isset($cart['user']['activeAdress']) && $cart['user']['activeAdress'] == 'newAdress')? 'checked' : '')?> <?= $active[0]?>>
                        <div class="checkbox_variable_address"></div>
                        <p><?= Yii::t('app', 'add-new-adress') ?></p>
                    </label>

                </div>
                <div class="ordering_form__section">
                    <div class="ordering_form_section__item">
                        <div class="ordering_form_section__item-inp">
                            <label for="e-mail" style="<?= ($user->email ? 'top: 8px; font-size: 11px;' : '')?>">E-mail</label>
                            <input type="text" name="email" id="e-mail" value="<?= $user->email ?>">
                        </div>
                        <p class="ordering_form_section__item-check">
                            <input type="checkbox" name="messages_for_sale" class="check_cont_ordering"
                                id="messages_for_sale" checked>
                            <label for="messages_for_sale"><?= Yii::t('app', 'sms-label') ?></label>
                        </p>
                        <p class="error_contact_info">
                            <?= Yii::t('app', 'validate-set-phone') ?>
                        </p>
                    </div>
                    <div class="ordering_form_section__item">
                        <div class="ordering_form_section__item-inp">
                            <label for="phone" style="<?= ($user->email ? 'top: 8px; font-size: 11px;' : '')?>"><?= Yii::t('app', 'placeholder-phone') ?></label>
                            <input type="text" name="phone" id="phone" value="<?= $user->phone ?>">
                            <p class="question_inp">
                                <img src="/frontStyle/assets/images/help_circle.svg" alt="">
                                <span>
                                    <?= Yii::t('app', 'validate-phone') ?>
                                </span>
                            </p>
                        </div>
                        <p class="error_contact_info">
                            <?= Yii::t('app', 'validate-set-phone') ?>
                        </p>
                        <p class="ordering_form_section__item-check sms_messages_checkbox">
                            <input type="checkbox" name="sms_messages" class="check_cont_ordering" id="sms_messages"
                                checked>
                            <label for="sms_messages">
                                <span><?= Yii::t('app', 'sms-message-title') ?></span>
                                <?= Yii::t('app', 'sms-message') ?>
                            </label>
                        </p>
                    </div>
                </div>
            </div>
            <div class="contact_info__section">
                <div class="flex_p_cis">
                    <h5>
                        <?= Yii::t('app', 'placeholder-adress-delivey') ?>
                    </h5>
                </div>
                <div class="form_pers-data__inputs">
                    <p class="form_w100">
                    
                        <label for="country" style="<?= (getValue($cart, 'country', $adressSet) ? 'top: 7px; font-size: 14px;' : '')?>"><?= Yii::t('app', 'country') ?></label>
                        <!-- <select name="country" id="country">
                                <option disabled selected></option>
                                <option value="Россия">Россия</option>
                                <option value="Белоруссия">Белоруссия</option>
                                <option value="Канада">Канада</option>
                            </select> -->
                        <input type="text" id="country" value="<?php echo getValue($cart, 'country', $adressSet); ?>"
                            name="country">


                        <span class="form_pers-data__inputs-error"><?= Yii::t('app', 'error-country') ?></span>
                    </p>
                    <p class="form_w50">
                        <label for="index_number" style="<?= (getValue($cart, 'postcode', $adressSet) ? 'top: 7px; font-size: 14px;' : '')?>">
                            <?= Yii::t('app', 'postcode') ?>
                        </label>
                        <input type="text" id="index_number"
                            value="<?php echo getValue($cart, 'postcode', $adressSet); ?>" name="postcode">
                        <span class="form_pers-data__inputs-error">
                            <?= Yii::t('app', 'set-postcode') ?>
                        </span>
                    </p>
                    <p class="form_w50">
                        <label for="region" style="<?= (getValue($cart, 'area', $adressSet) ? 'top: 7px; font-size: 14px;' : '')?>">
                            <?= Yii::t('app', 'area') ?>
                        </label>
                        <input type="text" id="region" value="<?php echo getValue($cart, 'area', $adressSet); ?>"
                            name="area">
                        <span class="form_pers-data__inputs-error">
                            <?= Yii::t('app', 'set-area') ?>
                        </span>
                    </p>
                    <p class="form_w50">
                        <label for="city" style="<?= (getValue($cart, 'city', $adressSet) ? 'top: 7px; font-size: 14px;' : '')?>">
                            <?= Yii::t('app', 'city') ?>
                        </label>
                        <input type="text" id="city" name="city"
                            value="<?php echo getValue($cart, 'city', $adressSet); ?>">
                        <span class="form_pers-data__inputs-error">
                            <?= Yii::t('app', 'set-city') ?>
                        </span>
                    </p>
                    <p class="form_w50">
                        <label for="street" style="<?= (getValue($cart, 'street', $adressSet) ? 'top: 7px; font-size: 14px;' : '')?>">
                            <?= Yii::t('app', 'street') ?>
                        </label>
                        <input type="text" id="street" name="street"
                            value="<?php echo getValue($cart, 'street', $adressSet); ?>">
                        <span class="form_pers-data__inputs-error">
                            <?= Yii::t('app', 'set-street') ?>
                        </span>
                    </p>
                    <p class="form_w100">
                        <label for="address" style="<?= (getValue($cart, 'house', $adressSet) ? 'top: 7px; font-size: 14px;' : '')?>">
                            <?= Yii::t('app', 'house') ?>
                        </label>
                        <input type="text" id="address" name="house"
                            value="<?php echo getValue($cart, 'house', $adressSet); ?>">
                        <span class="form_pers-data__inputs-error">
                            <?= Yii::t('app', 'set-data') ?>
                        </span>
                    </p>
                    <p class="form_w33">
                        <label for="surname" style="<?= (getValue($cart, 'surname', $adressSet) ? 'top: 7px; font-size: 14px;' : '')?>">
                            <?= Yii::t('app', 'surname') ?>
                        </label>
                        <input type="text" id="surname" name="surname"
                            value="<?php echo getValue($cart, 'surname', $adressSet); ?>">
                        <span class="form_pers-data__inputs-error">
                            <?= Yii::t('app', 'set-surname') ?>
                        </span>
                    </p>
                    <p class="form_w33">
                        <label for="name" style="<?= (getValue($cart, 'name', $adressSet) ? 'top: 7px; font-size: 14px;' : '')?>">
                            <?= Yii::t('app', 'placeholder-name') ?>
                        </label>
                        <input type="text" id="name" name="name" value="<?php echo getValue($cart, 'name', $adressSet); ?>">
                        <span class="form_pers-data__inputs-error">
                            <?= Yii::t('app', 'set-name') ?>
                        </span>
                    </p>
                    <p class="form_w33">
                        <label for="fname" style="<?= (getValue($cart, 'lastname', $adressSet) ? 'top: 7px; font-size: 14px;' : '')?>">
                            <?= Yii::t('app', 'lastname') ?>
                        </label>
                        <input type="text" id="fname" name="lastname"
                            value="<?php echo getValue($cart, 'lastname', $adressSet); ?>">
                        <span class="form_pers-data__inputs-error">
                            <?= Yii::t('app', 'set-lastname') ?>
                        </span>
                    </p>
                    <p class="form_w100">
                        <label for="comment" style="<?= (isset($cart['comment']) && !empty($cart['comment']) ? 'top: 7px; font-size: 14px;' : '')?>">
                            <?= Yii::t('app', 'comment') ?>
                        </label>
                        
                        <textarea name="comment" id="comment" rows="3"><?= (isset($cart['comment']) && !empty($cart['comment']) ? $cart['comment'] : '')?></textarea>
                    </p>
                </div>
            </div>
            <div class="contact_info_submit">
                <a href="<?php echo Yii::$app->params['parentUrl']?>/<?= $currensy ?>/cart" data-lang="<?= $currensy ?>" data-link="cart" id="NextStepOrder">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.3569 2.34375L4.7002 8.00042L10.3569 13.6571L11.3002 12.7144L6.58553 8.00042L11.3002 3.28642L10.3569 2.34375Z"
                            fill="#00A6CA" />
                    </svg>
                    <?= Yii::t('app', 'return-in-cart') ?>
                </a>
                <input type="submit" value="<?= Yii::t('app', 'next-btn') ?>" id='send-form' data-lang="<?= $currensy?>" data-link="delivery">
                <!--						<a href="#" class="ordering_new_step">Продолжить</a>-->
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="ordering__sidebar">
            <div class="ordering__sidebar-cart">
                <?= $this->render('min-cart', [
                    'cart' => $cart,
                    'currensy' => $currensy,
                    'lang' => $lang,
                    'product' => $product,
                    'poctcode' => getValue($cart, 'postcode', $adressSet)
                ]) ?>
            </div>
        </div>
    </div>
</main>


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