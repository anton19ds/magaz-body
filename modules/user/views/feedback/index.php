<?php
use yii\bootstrap5\Modal;
use yii\widgets\ActiveForm;

?>

<div class="all_shadow"></div>
<section id="history_orders">
	<div class="container">
		<?php echo $this->render('../components/left_menu_user.php', [
			'lang' => $lang,
			'active' => 'feedback'
		]) ?>
		<div class="infoproducts__main">
			<h1><?= Yii::t('app', 'feedback') ?></h1>
			<div class="content_contacts">
				<div>
					<p>
						<?= Yii::t('app', 'helpline') ?>: <a
							href="tel:<?= Yii::t('app', 'phone') ?>"><?= Yii::t('app', 'phone') ?></a>
					</p>
					<ul class="socials_feedback">
						<li>
							<a href="<?= Yii::t('app', 'whatsapp') ?>" target="_blank">
								<img src="/asset/images/whatsapp.svg" alt="">
							</a>
						</li>
						<li>
							<a href="<?= Yii::t('app', 'viber') ?>" target="_blank">
								<img src="/asset/images/viber.svg" alt="">
							</a>
						</li>
						<li>
							<a href="<?= Yii::t('app', 'telegram') ?>" target="_blank">
								<img src="/asset/images/tg.svg" alt="">
							</a>
						</li>
					</ul>
				</div>
				<div>
					<p>
						E-mail: <a href="mailto:<?= Yii::t('app', 'email') ?>"><?= Yii::t('app', 'email') ?></a>
					</p>
				</div>
			</div>
			<?php if (Yii::$app->session->hasFlash('success')): ?>  
				<div class="diss-alert" role="alert">
					<?php echo Yii::$app->session->getFlash('success'); ?>
				</div>
				<br>
			<?php endif; ?>
			<?php $form = ActiveForm::begin([
				'id' => 'feedback_form'
			]) ?>
			<p>
				<input type="text" name="Feedback[feedback_theme]" placeholder="<?= Yii::t('app', 'subject') ?>"
					id="feedback_theme">
			</p>
			<p>
				<textarea name="Feedback[feedback_message]" rows="6" placeholder="<?= Yii::t('app', 'your-message') ?>"
					id="feedback_message"></textarea>
			</p>
			<p class="feedback_form__sub">
				<input type="submit" value="<?= Yii::t('app', 'send') ?>" id="send_feedback">
			</p>
			<?php ActiveForm::end(); ?>
		</div>
</section>


<script>
    var h2 = document.getElementById('pageSetBody').offsetHeight;
    parent.postMessage({
        heUserInfo: h2,
        top: true,
        path: document.location.pathname,
    }, '*');
</script>