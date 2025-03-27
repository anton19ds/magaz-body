<section id="partner_programm" class="analytics_section">
	<div class="container">
		<?php echo $this->render('../components/left_menu_user.php', [
			'lang' => $lang,
			'active' => 'analytics'
		]) ?>
		<div class="infoproducts__main">
			<h1><?= Yii::t('app', 'analytics') ?></h1>
			<p class="description_text">
				<?= Yii::t('app', 'description-text-analytics') ?>
			</p>
			<form action="#" class="filter_analytics" style="display:none">
				<div class="filter_analytics__inp">
					<label for="filter_analytics__period"><?= Yii::t('app', 'period-of-time') ?></label>
					<select name="filter_analytics__period" id="filter_analytics__period">
						<option value="1"><?= Yii::t('app', 'month') ?></option>
						<option value="2"><?= Yii::t('app', '3-months') ?></option>
						<option value="3"><?= Yii::t('app', '6-months') ?></option>
						<option value="4"><?= Yii::t('app', 'Year') ?></option>
						<option value="5" selected><?= Yii::t('app', 'all-the-time') ?></option>
					</select>
				</div>
			</form>
			<div class="analytics_indicators">
				<div class="analytics_indicators__item indicator_red">
					<p class="indicator_number"><?= number_format($summBalansce, 0, '', ' '); ?>
						<?= Yii::t('app', 'currency-symbol') ?>
					</p>
					<p class="indicator_description">
						<?= Yii::t('app', 'total-summ-profit') ?>
					</p>
				</div>
				<div class="analytics_indicators__item indicator_green">
					<p class="indicator_number"><?= $userReport ?></p>
					<p class="indicator_description">
						<?= Yii::t('app', 'unique-visitors') ?>
					</p>
				</div>
				<div class="analytics_indicators__item indicator_blue">
					<p class="indicator_number"><?= number_format($dataOurSumm, 0, '', ' ') ?>
						<?= Yii::t('app', 'currency-symbol') ?>
					</p>
					<p class="indicator_description"><?= Yii::t('app', 'average-check') ?></p>
				</div>
				<div class="analytics_indicators__item indicator_pink">
					<p class="indicator_number"><?= count($payOrder) ?></p>
					<p class="indicator_description"><?= Yii::t('app', 'number-of-buyers') ?></p>
				</div>
				<div class="analytics_indicators__item indicator_dark_blue">
					<p class="indicator_number"><?= $conversion ?> %</p>
					<p class="indicator_description"><?= Yii::t('app', 'conversions') ?></p>
				</div>
				<div class="analytics_indicators__item indicator_purple">
					<p class="indicator_number"><?= count($noPayOrder) ?></p>
					<p class="indicator_description"><?= Yii::t('app', 'unpaid-applications') ?></p>
				</div>
			</div>
			<div class="analytics_diagrams">
				<!-- <img src="/frontStyle/assets/images/diagramm.jpg" alt=""> -->
			</div>
		</div>
	</div>
</section>


<?php $this->registerJs('
$("#filter_analytics__period").on("change", function(e){
	//alert($(this).val());
	document.location = "?sort="+$(this).val();
})
') ?>


<script>
	var h2 = document.getElementById('partner_programm').offsetHeight;
	parent.postMessage({
		heUserOrder: h2,
	}, '*');
</script>