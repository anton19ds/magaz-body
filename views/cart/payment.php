<?php
use app\models\Cart;
use app\models\SettingData;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
//debug($cart);
?>
<?= $this->render('../layouts/header-banner') ?>

<input type="hidden" id="currensy" value="<?= $currensy ?>">
<?php $form = ActiveForm::begin([
    'id' => 'form-payment'
]); ?>
<main>
    <div class="container_ordering">
        <div class="ordering__main">
            <div class="ordering_main__img">
                <?php $logo = SettingData::getValue('logo');
                $array = json_decode($logo, true);
                ?>
                <img src="<?= $array['array'][1]['value'] ?>" alt="" />
            </div>
            <div class="ordering_main__steps">
                <span><a href="/<?= $currensy ?>/cart">
                        <?= Yii::t('app', 'cart-txt') ?>
                    </a></span>
                <span><a href="/<?= $currensy ?>/order">
                        <?= Yii::t('app', 'contact-information') ?>
                    </a></span>
                <span><a href="/<?= $currensy ?>/delivery">
                        <?= Yii::t('app', 'delivery-method') ?>
                    </a></span>
                <span class="active"><a href="/<?= $currensy ?>/payment">
                        <?= Yii::t('app', 'payment-method') ?>
                    </a></span>
            </div>

            <div class="contact_info__section">
                <div class="flex_p_cis">
                    <h5>
                        <?= Yii::t('app', 'contact-information') ?>
                    </h5>
                </div>
                <div class="table_contacts_order_info">
                    <?php echo $this->render('user-virew-form', [
                        'user' => $user
                    ]) ?>
                    <div class="table_contacts_order_info__list">
                        <p>

                            <span><?= Yii::t('app', 'delivery-txt') ?>:</span>
                            <?= (isset($cart['delivery']) ? Yii::t('app', 'del-' . $cart['delivery']): "") ?>
                        </p>
                        <a href="/<?= $currensy ?>/delivery" class="step_prev back-btn" data-lang="<?= $currensy ?>"
                            data-link="delivery"><?= Yii::t('app', 'update-date-set') ?></a>
                    </div>
                </div>
            </div>
            <div class="contact_info__section">
                <div class="flex_p_cis">
                    <h5>
                        <?= Yii::t('app', 'payment-method') ?>
                    </h5>
                </div>
                <div class="table_contacts_order_info">
                    <div class="table_contacts_order_info__list variable_ordering">
                        <?php if ($currensy == 'cs'): ?>
                            <?php if (isset(Yii::$app->params['gpbwebpay-merchat'])): ?>
                                <div>
                                    <p>
                                        <input type="radio" name="pay" class="delivery_radio" id="GP_webpay" value="webpay">
                                        <label for="GP_webpay">
                                            <span>
                                                GP webpay
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($currensy == 'ru'): ?>
                            <!-- <div>
                                <p>
                                    <input type="radio" name="pay" class="delivery_radio" id="im" value="inteleckt">
                                    <label for="im">
                                        <span>
                                            <?= Yii::t('app', 'intellect-mess'); ?>
                                        </span>
                                    </label>
                                </p>
                            </div> -->
                            <?php if (isset(Yii::$app->params['yandex-merchat'])): ?>
                                <div>
                                    <p>
                                        <input type="radio" name="pay" class="delivery_radio" id="yandex" value="yandex">
                                        <label for="yandex">
                                            <span>
                                            <?= Yii::t('app', 'yandex-pay-messesg'); ?>
                                            </span>
                                        </label>
                                    </p>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>
                        <!-- <div>
                            <p>
                                <input type="radio" name="pay" class="delivery_radio" id="um" value="trisby">
                                <label for="um">
                                    <span>
                                        <?php //= Yii::t('app', 'trisby-mess'); ?>
                                    </span>
                                </label>
                            </p>
                        </div> -->
                        <div>
                            <p>
                                <input type="radio" name="pay" class="delivery_radio" id="hand" value="card">
                                <label for="hand">
                                    <span>
                                        <?= Yii::t('app', 'pay-card-mess'); ?>
                                    </span>
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact_info_submit">
                <a href="/<?= $currensy ?>/delivery" class="back-btn" data-lang="<?= $currensy ?>" data-link="delivery">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.3569 2.34375L4.7002 8.00042L10.3569 13.6571L11.3002 12.7144L6.58553 8.00042L11.3002 3.28642L10.3569 2.34375Z"
                            fill="#00A6CA" />
                    </svg>
                    <?= Yii::t('app', 'return-in-cart') ?>
                </a>
                <input type="submit" value="<?= Yii::t('app', 'next-btn') ?>" id='send-pay'>
                <!--						<a href="#" class="ordering_new_step">Продолжить</a>-->
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="ordering__sidebar">
            <div class="ordering__sidebar-cart">
                <?= $this->render('min-cart', [
                    'product' => $product,
                    'cart' => $cart,
                    'currensy' => $currensy,
                    'lang' => $currensy,
                    'poctcode' => (isset($user['postcode']) ? $user['postcode'] : null)
                ]) ?>
            </div>
        </div>
    </div>
</main>
<script>
    window.addEventListener('load', function () {
        varHe = document.getElementById('topBody');
        parent.postMessage({
            he: varHe.scrollHeight,
            path: document.location.pathname,
        }, '*');
    });
</script>



<?php $this->registerJs('
$(".back-btn").on("click", function(e){
    e.preventDefault();
    var lang = $(this).data("lang");
    var link = $(this).data("link");
    $(this).submit();
    parent.postMessage({
        lang : lang,
        link: link,
    }, "*");
})
') ?>