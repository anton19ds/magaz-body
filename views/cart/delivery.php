<?php
use app\models\Delivery;
use app\models\SettingData;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>
<input type="hidden" id="currensy" value="<?= $currensy ?>">
<?= $this->render('../layouts/header-banner') ?>
<?php $form = ActiveForm::begin([
    'id' => 'form-delivery'
]);
?>
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
                <span class="active"><a href="/<?= $currensy ?>/delivery">
                        <?= Yii::t('app', 'delivery-method') ?>
                    </a></span>
                <span><a href="/<?= $currensy ?>/payment">
                        <?= Yii::t('app', 'payment-method') ?>
                    </a></span>
            </div>
            <div class="contact_info__section  tab1">
                <div class="flex_p_cis">
                    <h5>
                        <?= Yii::t('app', 'contact-information') ?>
                    </h5>
                </div>
                <div class="table_contacts_order_info">
                    <?php echo $this->render('user-virew-form', [
                        'user' => $user
                    ]) ?>
                </div>
            </div>
            <div class="contact_info__section">
                <div class="flex_p_cis">
                    <h5>
                        <?= Yii::t('app', 'delivery-method') ?>
                    </h5>
                </div>
                <div class="table_contacts_order_info">






                    <div class="table_contacts_order_info__list variable_ordering">


                        <?php if (in_array('made', $productType) || in_array('simple', $productType)): ?>
                            <?php if ($resViewDelivery['russ'][strtoupper($currensy)] == '1'): ?>
                                <div>
                                    <p>
                                        <input type="radio" name="del" class="delivery_radio" id="rf" value="russ" checked>
                                        <label for="rf">
                                            <span><?= Yii::t('app', 'del-russ') ?></span>
                                        </label>
                                    </p>
                                    <p class="price_variable">
                                        <?= Delivery::getInstance()->getDelSumm('russ', $currensy, (isset($user['postcode']) ? $user['postcode'] : null)) ?>
                                        <?= Yii::t('app', 'currency-symbol') ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                            <?php if ($resViewDelivery['cs'][strtoupper($currensy)] == '1'): ?>
                                <div>
                                    <p>
                                        <input type="radio" name="del" class="delivery_radio" id="cs" value="cs">
                                        <label for="cs">
                                            <span><?= Yii::t('app', 'del-cs') ?></span>
                                        </label>
                                    </p>
                                    <p class="price_variable">
                                        <?= Delivery::getInstance()->getDelSumm('cs', $currensy) ?>
                                        <?= Yii::t('app', 'currency-symbol') ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                            <?php if ($resViewDelivery['sng'][strtoupper($currensy)] == '1'): ?>
                                <div>
                                    <p>
                                        <input type="radio" name="del" class="delivery_radio" id="sng" value="sng">
                                        <label for="sng">
                                            <span><?= Yii::t('app', 'del-sng') ?></span>
                                        </label>
                                    </p>
                                    <p class="price_variable">
                                        <?= Delivery::getInstance()->getDelSumm('sng', $currensy) ?>
                                        <?= Yii::t('app', 'currency-symbol') ?>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <?php if ($resViewDelivery['euro'][strtoupper($currensy)] == '1'): ?>
                                <div>
                                    <p>
                                        <input type="radio" name="del" class="delivery_radio" id="euro" value="euro">
                                        <label for="euro">
                                            <span><?= Yii::t('app', 'del-euro') ?></span>
                                        </label>
                                    </p>
                                    <p class="price_variable">
                                        <?= Delivery::getInstance()->getDelSumm('euro', $currensy) ?>
                                        <?= Yii::t('app', 'currency-symbol') ?>
                                    </p>
                                </div>
                            <?php endif; ?>

                            <?php if ($resViewDelivery['ems'][strtoupper($currensy)] == '1'): ?>
                                <div>
                                    <p>
                                        <input type="radio" name="del" class="delivery_radio" id="ems" value="ems">
                                        <label for="ems">
                                            <span><?= Yii::t('app', 'del-ems') ?></span>
                                        </label>
                                    </p>
                                    <p class="price_variable">
                                        <?= Delivery::getInstance()->getDelSumm('ems', $currensy) ?>
                                        <?= Yii::t('app', 'currency-symbol') ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- set-data-qar-cs -->
                            <div>
                                <p>
                                    <input type="radio" name="del" class="delivery_radio" id="info" value="info" checked>
                                    <label for="info">
                                        <?php if (in_array("consert", $productType)): ?>
                                            <span><?= Yii::t('app', 'set-data-qar-cs') ?></span>
                                        <?php else: ?>
                                            <span><?= Yii::t('app', 'del-info') ?></span>
                                        <?php endif; ?>

                                    </label>
                                </p>
                                <p class="price_variable">
                                    0
                                    <?= Yii::t('app', 'currency-symbol') ?>
                                </p>
                            </div>


                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <div class="contact_info_submit">
                <a href="/<?= $currensy ?>/order">

                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.3569 2.34375L4.7002 8.00042L10.3569 13.6571L11.3002 12.7144L6.58553 8.00042L11.3002 3.28642L10.3569 2.34375Z"
                            fill="#00A6CA" />
                    </svg>
                    <?= Yii::t('app', 'return-in-cart') ?>
                </a>
                <input type="submit" value="<?= Yii::t('app', 'next-btn') ?>" id='send-del' data-lang="<?= $currensy ?>"
                    data-link="payment">
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
$("#send-del").on("click", function(e){
    e.preventDefault();
    var lang = $(this).data("lang");
    var link = $(this).data("link");
    // if($(this).submit()){
    
    // };
    var form = $("#form-delivery").serializeArray();
    console.log(form);
    $.post("/cart-data/del", {form: form}, function(data){
    //console.log(data);
    if(data){
     parent.postMessage({
          lang : lang,
          link: link,
      }, "*");
        }else{
        console.log("123");
    }
    })

     
})
') ?>