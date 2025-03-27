<div class="list_advantages_product">
	<div class="list_advantages_product__item">
		<img src="/frontStyle/assets/images/pr_adv1.svg" alt="">
		<p><?= Yii::t('app', 'prod-desc-2')?></p>
	</div>
	<div class="list_advantages_product__item">
		<img src="/frontStyle/assets/images/pr_adv2.svg" alt="">
		<p><?= Yii::t('app', 'prod-desc-3')?></p>
	</div>
	<div class="list_advantages_product__item">
		<img src="/frontStyle/assets/images/pr_adv3.svg" alt="">
		<p><?= Yii::t('app', 'prod-desc-4')?></p>
	</div>
</div>
<?php $imageSer = $model->getParam('image-ser', $currency) ?>
<?php if (!empty($imageSer)): ?>
	<?php $imageSer = json_decode($imageSer, true);?>
	<?php if(!empty($imageSer) && isset($imageSer['array']) && !empty($imageSer['array'])):?>
		<ul class="product_certificats">
		<?php foreach($imageSer['array'] as $item):?>
			<li>
				<a href="<?= $item['value']?>" data-fancybox="cert">
					<img src="<?= $item['value']?>" alt="<?= $item['name']?>">
				</a>
			</li>
		<?php endforeach;?>
		</ul>
	<?php endif;?>
<?php endif;?>
<div class="product_char">
	<?php $params_text_1 = $model->getParam('params_text_1', $currency) ?>
	<?php if (!empty($params_text_1)): ?>
		<?php $params_text_1 = unserialize($params_text_1) ?>
		<ul class="product_char-table">
			<li class="product_char__title"><?= Yii::t('app', 'detal-prod')?></li>
			<?php foreach ($params_text_1 as $key => $value): ?>
				<li>
					<span>
						<?= $value[1] ?>
					</span>
					<span>
						<?= $value[2] ?>
					</span>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<?php $params_text_2 = $model->getParam('params_text_2', $currency) ?>
	<?php if (!empty($params_text_2)): ?>
		<?php $params_text_2 = unserialize($params_text_2) ?>
		<ul>
			<?php foreach ($params_text_2 as $key => $value): ?>
				<li <?= ($key == 0 ? 'class="product_char__title"' : '') ?>>
					<?= $value[1] ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<!-- <ul>
						<li class="product_char__title">Рекомендуемая диета</li>
						<li>
							<a href="#">Диета “Анти-Кандида”</a>
						</li>
						<li>
							<a href="#">“GAPS” Диета</a>
						</li>
					</ul> -->
</div>