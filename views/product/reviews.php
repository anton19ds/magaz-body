<?php
use app\models\Reviews;
use yii\bootstrap5\ActiveForm;

?>

<div class="product_reviews">
	<div class="flex_p_cis">
		<h4>
			<?= Yii::t('app', "riwers") ?>
			<span>
				<?= count($reviews) ?> <?= Yii::t('app', ' ratings') ?>
			</span>
		</h4>
		<?php if (Yii::$app->user->isGuest): ?>
			<p>
				<?= Yii::t('app', "decs-riwers") ?> <a
					href="/<?= $currency ?>/login?page=<?= Yii::$app->request->pathInfo ?>"><?= Yii::t('app', "in-log") ?></a>
			</p>
		<?php endif; ?>
	</div>
	<?php if (!Yii::$app->user->isGuest && !Reviews::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['product_id' => $model->id])->exists()): ?>
		<?php $form = ActiveForm::begin([
			'id' => 'addRewersS',
			'options' => [
				'class' => 'add_review_form'
			]
		]); ?>

		<input type="hidden" name="product_id" value="<?= $model->id?>">
		<input type="hidden" name="user_id" value="<?= $user_id?>">
		<p class="error_form">
			<?= Yii::t('app', "desc-riw-1") ?>
		</p>
			<div class="diss-alert riview-alert" role="alert" style="margin-bottom:10px">
				<?= Yii::t('app','review-success');?>
			</div>
		<div class="flex_p_cis">
			<label for="text_review"><?= Yii::t('app', "new-riwer") ?></label>
			<div class="choose_rate">
				<p><?= Yii::t('app', "rait") ?>: </p>
				<div class="choose_rate__items no_checked">
					<span data-rating="1">
						<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M15.9628 6.70938L11.4997 6.06075L9.5046 2.01602C9.45011 1.90528 9.36046 1.81563 9.24972 1.76114C8.97198 1.62403 8.63448 1.73829 8.49562 2.01602L6.5005 6.06075L2.03741 6.70938C1.91437 6.72696 1.80187 6.78497 1.71573 6.87286C1.6116 6.97989 1.55422 7.12387 1.5562 7.27319C1.55818 7.4225 1.61935 7.56492 1.72628 7.66915L4.95538 10.8174L4.19249 15.2629C4.1746 15.3663 4.18605 15.4727 4.22552 15.5699C4.265 15.6671 4.33094 15.7514 4.41585 15.813C4.50077 15.8747 4.60127 15.9114 4.70595 15.9188C4.81063 15.9263 4.91531 15.9043 5.00812 15.8553L9.00011 13.7565L12.9921 15.8553C13.1011 15.9133 13.2276 15.9326 13.3489 15.9115C13.6548 15.8588 13.8605 15.5688 13.8077 15.2629L13.0448 10.8174L16.2739 7.66915C16.3618 7.58301 16.4198 7.47051 16.4374 7.34747C16.4849 7.03985 16.2704 6.75508 15.9628 6.70938Z"
								fill="#CACACA" />
						</svg>
					</span>
					<span data-rating="2">
						<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M15.9628 6.70938L11.4997 6.06075L9.5046 2.01602C9.45011 1.90528 9.36046 1.81563 9.24972 1.76114C8.97198 1.62403 8.63448 1.73829 8.49562 2.01602L6.5005 6.06075L2.03741 6.70938C1.91437 6.72696 1.80187 6.78497 1.71573 6.87286C1.6116 6.97989 1.55422 7.12387 1.5562 7.27319C1.55818 7.4225 1.61935 7.56492 1.72628 7.66915L4.95538 10.8174L4.19249 15.2629C4.1746 15.3663 4.18605 15.4727 4.22552 15.5699C4.265 15.6671 4.33094 15.7514 4.41585 15.813C4.50077 15.8747 4.60127 15.9114 4.70595 15.9188C4.81063 15.9263 4.91531 15.9043 5.00812 15.8553L9.00011 13.7565L12.9921 15.8553C13.1011 15.9133 13.2276 15.9326 13.3489 15.9115C13.6548 15.8588 13.8605 15.5688 13.8077 15.2629L13.0448 10.8174L16.2739 7.66915C16.3618 7.58301 16.4198 7.47051 16.4374 7.34747C16.4849 7.03985 16.2704 6.75508 15.9628 6.70938Z"
								fill="#CACACA" />
						</svg>
					</span>
					<span data-rating="3">
						<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M15.9628 6.70938L11.4997 6.06075L9.5046 2.01602C9.45011 1.90528 9.36046 1.81563 9.24972 1.76114C8.97198 1.62403 8.63448 1.73829 8.49562 2.01602L6.5005 6.06075L2.03741 6.70938C1.91437 6.72696 1.80187 6.78497 1.71573 6.87286C1.6116 6.97989 1.55422 7.12387 1.5562 7.27319C1.55818 7.4225 1.61935 7.56492 1.72628 7.66915L4.95538 10.8174L4.19249 15.2629C4.1746 15.3663 4.18605 15.4727 4.22552 15.5699C4.265 15.6671 4.33094 15.7514 4.41585 15.813C4.50077 15.8747 4.60127 15.9114 4.70595 15.9188C4.81063 15.9263 4.91531 15.9043 5.00812 15.8553L9.00011 13.7565L12.9921 15.8553C13.1011 15.9133 13.2276 15.9326 13.3489 15.9115C13.6548 15.8588 13.8605 15.5688 13.8077 15.2629L13.0448 10.8174L16.2739 7.66915C16.3618 7.58301 16.4198 7.47051 16.4374 7.34747C16.4849 7.03985 16.2704 6.75508 15.9628 6.70938Z"
								fill="#CACACA" />
						</svg>
					</span>
					<span data-rating="4">
						<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M15.9628 6.70938L11.4997 6.06075L9.5046 2.01602C9.45011 1.90528 9.36046 1.81563 9.24972 1.76114C8.97198 1.62403 8.63448 1.73829 8.49562 2.01602L6.5005 6.06075L2.03741 6.70938C1.91437 6.72696 1.80187 6.78497 1.71573 6.87286C1.6116 6.97989 1.55422 7.12387 1.5562 7.27319C1.55818 7.4225 1.61935 7.56492 1.72628 7.66915L4.95538 10.8174L4.19249 15.2629C4.1746 15.3663 4.18605 15.4727 4.22552 15.5699C4.265 15.6671 4.33094 15.7514 4.41585 15.813C4.50077 15.8747 4.60127 15.9114 4.70595 15.9188C4.81063 15.9263 4.91531 15.9043 5.00812 15.8553L9.00011 13.7565L12.9921 15.8553C13.1011 15.9133 13.2276 15.9326 13.3489 15.9115C13.6548 15.8588 13.8605 15.5688 13.8077 15.2629L13.0448 10.8174L16.2739 7.66915C16.3618 7.58301 16.4198 7.47051 16.4374 7.34747C16.4849 7.03985 16.2704 6.75508 15.9628 6.70938Z"
								fill="#CACACA" />
						</svg>
					</span>
					<span data-rating="5">
						<svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M15.9628 6.70938L11.4997 6.06075L9.5046 2.01602C9.45011 1.90528 9.36046 1.81563 9.24972 1.76114C8.97198 1.62403 8.63448 1.73829 8.49562 2.01602L6.5005 6.06075L2.03741 6.70938C1.91437 6.72696 1.80187 6.78497 1.71573 6.87286C1.6116 6.97989 1.55422 7.12387 1.5562 7.27319C1.55818 7.4225 1.61935 7.56492 1.72628 7.66915L4.95538 10.8174L4.19249 15.2629C4.1746 15.3663 4.18605 15.4727 4.22552 15.5699C4.265 15.6671 4.33094 15.7514 4.41585 15.813C4.50077 15.8747 4.60127 15.9114 4.70595 15.9188C4.81063 15.9263 4.91531 15.9043 5.00812 15.8553L9.00011 13.7565L12.9921 15.8553C13.1011 15.9133 13.2276 15.9326 13.3489 15.9115C13.6548 15.8588 13.8605 15.5688 13.8077 15.2629L13.0448 10.8174L16.2739 7.66915C16.3618 7.58301 16.4198 7.47051 16.4374 7.34747C16.4849 7.03985 16.2704 6.75508 15.9628 6.70938Z"
								fill="#CACACA" />
						</svg>
					</span>
				</div>
				<input type="hidden" name="count_rate_review">
			</div>
		</div>
		<div class="field_text_review">
			<input type="text" name="username" id="username_review" placeholder="<?= Yii::t('app', "name-or-email") ?>">
		</div>
		<div class="field_text_review">
			<textarea id="text_review" rows="4" name="comment"></textarea>
		</div>
		<div class="review_submit">
			<input type="submit" value="<?= Yii::t('app', "public") ?>" id="submitSendR">
		</div>
		<?php ActiveForm::end(); ?>
	<?php endif; ?>

	<div class="list_reviews">
		<?php if (!empty($reviews)): ?>
			<?php foreach ($reviews as $elem): ?>
				<div class="list_reviews__item">
					<p class="review_item__name">
						<?php if(isset($elem->username) && !empty($elem->username)):?>
							<?= $elem->username ?>
							<?php else:?>
								<?= $elem->user->username ?>
								<?php endif;?>
						
					</p>
					<div class="list_rate_table">
						<?php for ($i = 0; $i < 5; $i++): ?>
							<?php if ($i < $elem->star): ?>
								<span class="rate_active"></span>
							<?php else: ?>
								<span></span>
							<?php endif; ?>
						<?php endfor; ?>
					</div>
					<?php if ($elem->text): ?>
						<p class="review_item__text">
							<?php echo $elem->text; ?>
						</p>
					<?php endif; ?>
					<span class="date_review">
						<?= date('d.m.Y', $elem->date) ?>
					</span>
					<p class="answer_review">
						<!-- <a href="#">Ответить</a> -->
					</p>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		<!-- <div class="list_reviews__item">

			<form action="" class="add_review_form">
				<div class="flex_p_cis">
					<label for="text_answer_review">Ответ</label>
				</div>
				<div class="field_text_review">
					<textarea id="text_answer_review" rows="1"></textarea>
				</div>
				<div class="review_submit">
					<input type="submit" value="Опубликовать">
				</div>
			</form>
		</div> -->
	</div>
	<!-- <a href="#" class="more_reviews">Показать больше</a> -->
</div>


<style>
	#username_review:focus,
	#text_review:focus{
		border: 1px solid #00A6CA;
	}
	#username_review{
		border: 1px solid #ECECEC;
		border-radius: 5px;
		width: 100%;
		padding: 11px;
		margin-top:10px;
		margin-bottom: 5px;
	}
</style>