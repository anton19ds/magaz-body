<?php
use app\models\CategoryPromo;
use yii\helpers\ArrayHelper;

//$data = ArrayHelper::toArray($posts, [
//BaseArrayHelper

//debug($user->promoUser) ?>




<div class="all_shadow"></div>
<?= $this->render('_form', [
	'user' => $user,
	'lang' => $lang
]) ?>

<section id="partner_programm">
	<div class="container">
		<?php echo $this->render('../components/left_menu_user.php', [
			'lang' => $lang,
			'active' => 'affiliate-program'
		]) ?>
		<div class="infoproducts__main">
			<h1>
				<?= Yii::t('app', "your-promocodes") ?>
			</h1>
			<div class="section_add_new_promocode">
				<h3><?= Yii::t('app', "create-new-pronocode")?></h3>
				<div class="actual_precents">
					<p class="actual_precents__title"><?= Yii::t('app', "actual-promocode")?></p>
					<table>
						<?php $objLavel = ArrayHelper::toarray($user->userLavel->categoryLavel);
						ArrayHelper::multisort($objLavel, ['category_promo_id'], [SORT_ASC]);
						?>
						<?php foreach ($objLavel as $sizeLavel): ?>
							<tr>
								<td>
									<?php if($sizeLavel['category_promo_id'] == 1):?>
										<?= Yii::t('app', 'promo-desc-26')?>
									<?php elseif($sizeLavel['category_promo_id'] == 2):?>
										<?= Yii::t('app', 'promo-desc-17')?>
									<?php elseif($sizeLavel['category_promo_id'] == 3):?>
										<?= Yii::t('app', 'promo-desc-262')?>
									<?php endif;?>
								</td>
								<td>
									<?= $sizeLavel['size']?>%
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
					<p class="button_add_promocode">
						<span><?= Yii::t('app', 'add-new-promocode')?></span>
					</p>
				</div>
			</div>
			<div class="list_promocodes">
				<?= $this->render('promocodes__item', [
					'user' => $user,
					'userPromo' => $userPromo,
					'lang' => $lang
				]) ?>
			</div>
			<div class="use_tg_link">
			<a href="<?= Yii::t('app', 'tel-bot-link')?>" target="_blank">
					<span><?= Yii::t('app', "con-telegram")?></span>
					<img src="/asset/images/tg_quadro.svg" alt="">
				</a>
			</div>
		</div>
	</div>
</section>
<script>
	var h2 = document.getElementById('pageSetBody').offsetHeight;
    window.addEventListener('load', function () {
        parent.postMessage({
            he : h2,
        }, '*');
    });
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