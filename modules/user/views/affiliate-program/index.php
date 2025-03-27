<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="all_shadow"></div>
<section id="history_orders" class="partner-set">
    <div class="container" id="partner-set">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'affiliate-program'
        ]) ?>
        <div class="infoproducts__main"  style="min-height:500px">
            <h1>
                <?= Yii::t('app', "your-promocodes") ?>
            </h1>
            <div class="section_add_new_promocode" style="display:none">
                <h3>
                    <?= Yii::t('app', "create-new-pronocode") ?>
                </h3>
                <div class="actual_precents">
                    <p class="actual_precents__title">
                        <?= Yii::t('app', "actual-promocode") ?>
                    </p>
                    <table>
                        <tbody>
                            <?php foreach ($user->userLavel->categoryLavel as $sizeLavel): ?>
                                <tr>
                                    <td>
                                        <?= $sizeLavel->categoryPromo->name ?>:
                                    </td>
                                    <td>
                                        <?= $sizeLavel->size ?>
                                        %
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- <p class="button_add_promocode"><span>Создать промокод</span></p> -->
                </div>
            </div>



            <div class="list_promocodes">
                <?= $this->render('promocodes__item', [
                    'userPromo' => $userPromo,
                    'lang' => $lang,
                    'user' => $user
                ]) ?>
            </div>
            <a href="#" class="benefit_link">
                <?= Yii::t('app', 'up-level') ?>
            </a>
            <div class="use_tg_link">
			<a href="<?= Yii::t('app', 'tel-bot-link')?>" target="_blank">
					<span><?= Yii::t('app', "con-telegram")?></span>
					<img src="/asset/images/tg_quadro.svg" alt="">
				</a>
			</div>
        </div>
    </div>
</section>
<div class="popup benefit_popup" style="display: none;" id="benefitPopup">
    <div class="close_popup close_popup_svg">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <g clip-path="url(#clip0_1158_108032)">
                <path
                    d="M11.1049 10L19.7712 1.33372C20.0763 1.0286 20.0763 0.533915 19.7712 0.228837C19.4661 -0.0762401 18.9714 -0.0762791 18.6663 0.228837L9.99999 8.89515L1.33372 0.228837C1.0286 -0.0762791 0.533915 -0.0762791 0.228837 0.228837C-0.0762401 0.533954 -0.0762792 1.02864 0.228837 1.33372L8.89511 9.99999L0.228837 18.6663C-0.0762792 18.9714 -0.0762792 19.4661 0.228837 19.7712C0.381376 19.9237 0.581337 20 0.781297 20C0.981258 20 1.18118 19.9237 1.33376 19.7712L9.99999 11.1049L18.6663 19.7712C18.8188 19.9237 19.0188 20 19.2187 20C19.4187 20 19.6186 19.9237 19.7712 19.7712C20.0763 19.4661 20.0763 18.9714 19.7712 18.6663L11.1049 10Z"
                    fill="black"></path>
            </g>
            <defs>
                <clipPath id="clip0_1158_108032">
                    <rect width="20" height="20" fill="white"></rect>
                </clipPath>
            </defs>
        </svg>
    </div>
    <p class="title_popup">
        <?= Yii::t('app', 'up-lavel-dec-1') ?>
    </p>
    <p class="description_popup">
        <?= Yii::t('app', 'up-lavel-dec-2') ?>
    </p>
    <?php $form = ActiveForm::begin([
        'id' => 'why_benefit_form',
        'options' => [
            'class' => 'why_benefit_form',
            'name' => "receiving_password_form"
        ]
    ]) ?>
    <!-- <form action="#" name="" class=""> -->
    <p>
        <textarea name="why_benefit" placeholder="<?= Yii::t('app', 'up-lavel-dec-3') ?>" id="why_benefit"></textarea>
    </p>
    <p>
        <?= Html::submitButton(Yii::t('app', 'send'), ['id' => "send-new-req-promo"]) ?>
        <!-- <input type="submit" value=> -->
    </p>
    <!-- </form> -->
    <?php ActiveForm::end() ?>
</div>



<?= $this->render('add_promocode_popup', [

]) ?>



<div class="popup success_benefit">
    <div class="close_popup close_popup_svg">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <g clip-path="url(#clip0_1158_108032)">
                <path
                    d="M11.1049 10L19.7712 1.33372C20.0763 1.0286 20.0763 0.533915 19.7712 0.228837C19.4661 -0.0762401 18.9714 -0.0762791 18.6663 0.228837L9.99999 8.89515L1.33372 0.228837C1.0286 -0.0762791 0.533915 -0.0762791 0.228837 0.228837C-0.0762401 0.533954 -0.0762792 1.02864 0.228837 1.33372L8.89511 9.99999L0.228837 18.6663C-0.0762792 18.9714 -0.0762792 19.4661 0.228837 19.7712C0.381376 19.9237 0.581337 20 0.781297 20C0.981258 20 1.18118 19.9237 1.33376 19.7712L9.99999 11.1049L18.6663 19.7712C18.8188 19.9237 19.0188 20 19.2187 20C19.4187 20 19.6186 19.9237 19.7712 19.7712C20.0763 19.4661 20.0763 18.9714 19.7712 18.6663L11.1049 10Z"
                    fill="black" />
            </g>
            <defs>
                <clipPath id="clip0_1158_108032">
                    <rect width="20" height="20" fill="white" />
                </clipPath>
            </defs>
        </svg>
    </div>
    <p class="title_popup">
        <?= Yii::t('app', "promo-desc-19") ?>
    </p>
    <p class="description_popup">
        <?= Yii::t('app', "promo-desc-20") ?>
    </p>
</div>


<script>
    var h2 = document.getElementById('pageSetBody').offsetHeight;
    parent.postMessage({
        heUserInfo: h2,
        top: true
    }, '*');
</script>

<style>
	.summ_percent .promocode_question:after{
		display: none;
        content: "<?= Yii::t('app', 'mob-desc-1')?>";
		white-space: nowrap;
	}
	.sale_client .promocode_question:after{
		display: none;
		content: "<?= Yii::t('app', 'mob-desc-2')?>";
		white-space: nowrap;
	}
	.rewards_buy .promocode_question:after{
		display: none;
        content: "<?= Yii::t('app', 'mob-desc-3')?>";
		white-space: nowrap;
	}
</style>