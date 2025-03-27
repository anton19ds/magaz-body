<main>
    <div class="container-result_pay result_pay-error">
    <div class="title-set error" style="width:541px;line-height: 85px;">
            <?= Yii::t('app', 'paymnet-error')?>
        </div>
        <div class="section_result_pay__info">
            <h3><span>Попробуйте ещё раз или свяжитесь</span> с нашей службой поддержки</h3>
            <div class="result_pay__half_contacts">
                <div>
                    <p>Телефон горячей линии:</p>
                    <p><a href="tel:<?= Yii::t('app', 'phone')?>"><?= Yii::t('app', 'phone')?></a></p>
                </div>
                <div>
                    <p>E-Mail:</p>
                    <p><a href="mailto:<?= Yii::t('app', 'email')?>"><?= Yii::t('app', 'email')?></a></p>
                </div>
            </div>
            <div class="result_pay_info__socials">
                <a href="<?= Yii::t('app', "whatsapp")?>" class="result_pay_info_socials__wa" target="_blank">
                    <img src="/img/whatsapp.svg" alt="">
                </a>
                <a href="<?= Yii::t('app', "viber")?>" class="result_pay_info_socials__viber" target="_blank">
                    <img src="/img/Viber.svg" alt="">
                </a>
                <a href="<?= Yii::t('app', "telegram")?>" class="result_pay_info_socials__tg" target="_blank">
                    <img src="/img/telegram.png" alt="">
                </a>
            </div>
            <img src="/img/list1.png" class="list_mob" alt="">
        </div>
    </div>
</main>

<style>
    #criterion{
        display: none;
    }
</style>