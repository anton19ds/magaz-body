<?php
use app\models\Product;
use app\widgets\Cart;
use app\widgets\Raite;
$imgJson = json_decode($model->getParam('image'), true);
$priceData = Product::getPriceProductbyId($model->id, $currency, $metaArray['type']);
?>
<?php if(!$model->getActiveProductLang($currency)):?>
	<script>
		var linkHome = "/<?php echo $currency;?>/shop";
		parent.postMessage({
            linkData: linkHome,
        }, '*');
	</script>
<?php endif;?>
<link href="/css/common.min.css" rel="stylesheet">
<link href="https://anticandida.com/css/width-content.css" rel="stylesheet">
<main>
	<div class="container_product">
		<h1>
			<?= $metaArray['productName'] ?>
		</h1>
		<div class="list_rate">
			<?= Raite::widget(['front' => true, 'view' => true, 'id' => $model->id]) ?>
		</div>
		<div class="main_content_product">
			<div class="main_content_product__left">
				<div class="product_gallery">
					<div class="product_gallery__top">
						<?php if (isset($imgJson['array'])): ?>
							<?php foreach ($imgJson['array'] as $item): ?>
								<div class="main-iamge-list" style='background-image: url("<?= $item['value'] ?>")'></div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				<?php if(count($imgJson['array']) > 1 ):?>				
					<div class="product_gallery__bottom">
						<?php if (isset($imgJson['array'])): ?>
							<?php foreach ($imgJson['array'] as $item): ?>
								<div style='background-image: url("<?= $item['value'] ?>")' class="img-gal">
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				<?php endif;?>


				</div>
				<div class="main_content_product__right">
				<p class="price_count">
					<span class="set-pr-st">
						<?php echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?>
						<?= $priceData['symbolCode'] ?>
					</span>
					<?php if ($priceData['summ']): ?>
						<span class="sale-price_count">
							<?php echo number_format($priceData['price'], 0, '', ' '); ?>
							<?= $priceData['symbolCode'] ?>
						</span>
					<?php endif; ?> 
				</p>
						<?php if (($currency == 'ru' && ($metaArray['type'] == 'simple' || $metaArray['type'] == 'made')) || (isset($parentArray['type']) && $parentArray['type'] == 'made')): ?>
						<div class="variable_package_quantity">

							<?php if (
								isset($priceData['productPac']) &&
								!empty($priceData['productPac']) &&
								isset($priceData['productPac']['pricePac-1']) &&
								!empty($priceData['productPac']['pricePac-1'])
							): ?>
								<?php if (
									isset($priceData['productPac']['pricePac-1']['prise']) &&
									!empty($priceData['productPac']['pricePac-1']['prise']) &&
									isset($priceData['productPac']['pricePac-1']['sale']) &&
									!empty($priceData['productPac']['pricePac-1']['sale'])
								): ?>
									<div class="variable_package__item active" data-value="1">
										<p class="variable_package__title">
											<?= Yii::t('app', '1_pac') ?>
										</p>
										<p class="price_count"
											data-price="<?php echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?> <?= $priceData['symbolCode'] ?>">
											<?php echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?>
											<?= $priceData['symbolCode'] ?>
											<?php if ($priceData['summ']): ?>
												<span class="sale-price_count">
													<?php echo number_format($priceData['price'], 0, '', ' '); ?>
													<?= $priceData['symbolCode'] ?>
												</span>
											<?php endif; ?>
										</p>
									</div>
								<?php endif; ?>
							<?php endif; ?>

							<?php if (
								isset($priceData['productPac']) &&
								!empty($priceData['productPac']) &&
								isset($priceData['productPac']['pricePac-2']) &&
								!empty($priceData['productPac']['pricePac-2'])
							): ?>
								<?php if (
									isset($priceData['productPac']['pricePac-2']['prise']) &&
									!empty($priceData['productPac']['pricePac-2']['prise']) &&
									isset($priceData['productPac']['pricePac-2']['sale']) &&
									!empty($priceData['productPac']['pricePac-2']['sale'])
								): ?>
									<div class="variable_package__item" data-value="2">
										<p class="variable_package__title">
											<?= Yii::t('app', '2_pac') ?>
										</p>
										<p class="price_count"
											data-price="<?= number_format($priceData['productPac']['pricePac-2']['sale'], 0, '', ' ') ?> <?= Yii::t('app', 'currency-symbol') ?>">
											<?= number_format($priceData['productPac']['pricePac-2']['sale'], 0, '', ' ') ?>
											<?= Yii::t('app', 'currency-symbol') ?>
											<span class="sale-price_count">
												<?= number_format($priceData['productPac']['pricePac-2']['prise'], 0, '', ' ') ?>
												<?= Yii::t('app', 'currency-symbol') ?>
											</span>
										</p>
										<p class="promocode_question">
											<img src="/frontStyle/assets/images/ques.svg" alt="">
											<span><b><?= Yii::t('app', 'desc-prod-1') ?></b></span>
										</p>
									</div>
								<?php endif; ?>
							<?php endif; ?>

							<?php if (
								isset($priceData['productPac']['pricePac-3']['prise']) &&
								!empty($priceData['productPac']['pricePac-3']['prise']) &&
								isset($priceData['productPac']['pricePac-3']['sale']) &&
								!empty($priceData['productPac']['pricePac-3']['sale'])
							): ?>
								<div class="variable_package__item" data-value="3">
									<p class="variable_package__title">
										<?= Yii::t('app', '3_pac') ?>
									</p>
									<p class="price_count"
										data-price="<?= number_format($priceData['productPac']['pricePac-3']['sale'], 0, '', ' ') ?> <?= Yii::t('app', 'currency-symbol') ?>">
										<?= number_format($priceData['productPac']['pricePac-3']['sale'], 0, '', ' ') ?>		<?= Yii::t('app', 'currency-symbol') ?>
										<span class="sale-price_count">
											<?= number_format($priceData['productPac']['pricePac-3']['prise'], 0, '', ' ') ?>
											<?= Yii::t('app', 'currency-symbol') ?>
										</span>
									</p>
									<p class="promocode_question">
										<img src="/frontStyle/assets/images/ques.svg" alt="">
										<span><b><?= Yii::t('app', 'desc-prod-1') ?></b></span>
									</p>
								</div>
							<?php endif; ?>

						</div>
						<form action="#" class="list_goods_item__quantity">
						<?php if (($currency == 'ru' && ($metaArray['type'] == 'simple' || $metaArray['type'] == 'made')) || (isset($parentArray['type']) && $parentArray['type'] == 'made')): ?>
								<div class="quantity_good">
									<div class="quantity_good_abs no_opened" data-id="<?= $model->id ?>">
										<div class="item active" data-value="1"><span>
												<?= Yii::t('app', 'product-cart-count') ?>
											</span>1 - Pack</div>
										<div class="item" data-value="2"><span>
												<?= Yii::t('app', 'product-cart-count') ?>
											</span>2 - Pack</div>
										<div class="item" data-value="3"><span>
												<?= Yii::t('app', 'product-cart-count') ?>
											</span>3 - Pack</div>
									</div>
									<input type="hidden" name="quantity">
								</div>
							<?php endif; ?>
							<button type="submit" name="add-to-cart">
								<?= Yii::t('app', 'cart') ?>
							</button>
						</form>
					<?php endif; ?>
					<div class="list_advantages_product">
						<div class="list_advantages_product__item">
							<img src="/frontStyle/assets/images/pr_adv1.svg" alt="">
							<p><?= Yii::t('app', 'prod-desc-2') ?></p>
						</div>
						<div class="list_advantages_product__item">
							<img src="/frontStyle/assets/images/pr_adv2.svg" alt="">
							<p><?= Yii::t('app', 'prod-desc-3') ?></p>
						</div>
						<div class="list_advantages_product__item">
							<img src="/frontStyle/assets/images/pr_adv3.svg" alt="">
							<p><?= Yii::t('app', 'prod-desc-4') ?></p>
						</div>
					</div>
					<?php $imageSer = $model->getParam('image-ser', $currency) ?>
					<?php if (!empty($imageSer)): ?>
						<?php $imageSer = json_decode($imageSer, true); ?>
						<?php if (!empty($imageSer) && isset($imageSer['array']) && !empty($imageSer['array'])): ?>
							<ul class="product_certificats">
								<?php foreach ($imageSer['array'] as $item): ?>
									<li>
										<a href="<?= $item['value'] ?>" data-fancybox="cert">
											<img src="<?= $item['value'] ?>" alt="<?= $item['name'] ?>">
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					<?php endif; ?>


					<div class="product_char">

						<?php $params_text_1 = $model->getParam('params_text_1', $currency) ?>
						<?php if (!empty($params_text_1)): ?>
							<?php $params_text_1 = unserialize($params_text_1) ?>
							<ul class="product_char-table">
								<li class="product_char__title">
									<?= Yii::t('app', 'detal-prod') ?>
								</li>
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
				</div>



				<div id="content">
					<?php echo $result ?>
				</div>
				<?= $this->render('reviews', [
					'currency' => $currency,
					'reviews' => $reviews,
					'model' => $model,
					'user_id' => $user_id
				]) ?>
			</div>
			<div class="main_content_product__right">
				<p class="price_count" id="top-main-price">
					<span class="set-pr-st">
						<?php echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?>
						<?= $priceData['symbolCode'] ?>
					</span>
					<?php if ($priceData['summ']): ?>
						<span class="sale-price_count">
							<?php echo number_format($priceData['price'], 0, '', ' '); ?>
							<?= $priceData['symbolCode'] ?>
						</span>
					<?php endif; ?>
				</p>

				<?php if (($currency == 'ru' && ($metaArray['type'] == 'simple' || $metaArray['type'] == 'made')) || (isset($parentArray['type']) && $parentArray['type'] == 'made')): ?>
					<div class="variable_package_quantity">

						<?php if (
							isset($priceData['productPac']) &&
							!empty($priceData['productPac']) &&
							isset($priceData['productPac']['pricePac-1']) &&
							!empty($priceData['productPac']['pricePac-1'])
						): ?>
							<?php if (
								isset($priceData['productPac']['pricePac-1']['prise']) &&
								!empty($priceData['productPac']['pricePac-1']['prise']) &&
								isset($priceData['productPac']['pricePac-1']['sale']) &&
								!empty($priceData['productPac']['pricePac-1']['sale'])
							): ?>
								<div class="variable_package__item active" data-value="1">
									<p class="variable_package__title">
										<?= Yii::t('app', '1_pac') ?>
									</p>
									<p class="price_count"
										data-price="<?php echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?> <?= $priceData['symbolCode'] ?>">
										<?php echo number_format(($priceData['summ'] ? $priceData['summ'] : $priceData['price']), 0, '', ' '); ?>
										<?= $priceData['symbolCode'] ?>
										<?php if ($priceData['summ']): ?>
											<span class="sale-price_count">
												<?php echo number_format($priceData['price'], 0, '', ' '); ?>
												<?= $priceData['symbolCode'] ?>
											</span>
										<?php endif; ?>
									</p>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<?php if (
							isset($priceData['productPac']) &&
							!empty($priceData['productPac']) &&
							isset($priceData['productPac']['pricePac-2']) &&
							!empty($priceData['productPac']['pricePac-2'])
						): ?>
							<?php if (
								isset($priceData['productPac']['pricePac-2']['prise']) &&
								!empty($priceData['productPac']['pricePac-2']['prise']) &&
								isset($priceData['productPac']['pricePac-2']['sale']) &&
								!empty($priceData['productPac']['pricePac-2']['sale'])
							): ?>
								<div class="variable_package__item" data-value="2">
									<p class="variable_package__title">
										<?= Yii::t('app', '2_pac') ?>
									</p>
									<p class="price_count"
										data-price="<?= number_format($priceData['productPac']['pricePac-2']['sale'], 0, '', ' ') ?> <?= Yii::t('app', 'currency-symbol') ?>">
										<?= number_format($priceData['productPac']['pricePac-2']['sale'], 0, '', ' ') ?>
										<?= Yii::t('app', 'currency-symbol') ?>
										<span class="sale-price_count">
											<?= number_format($priceData['productPac']['pricePac-2']['prise'], 0, '', ' ') ?>
											<?= Yii::t('app', 'currency-symbol') ?>
										</span>
									</p>
									<p class="promocode_question">
										<img src="/frontStyle/assets/images/ques.svg" alt="">
										<span><b><?= Yii::t('app', 'desc-prod-1') ?></b></span>
									</p>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<?php if (
							isset($priceData['productPac']['pricePac-3']['prise']) &&
							!empty($priceData['productPac']['pricePac-3']['prise']) &&
							isset($priceData['productPac']['pricePac-3']['sale']) &&
							!empty($priceData['productPac']['pricePac-3']['sale'])
						): ?>
							<div class="variable_package__item" data-value="3">
								<p class="variable_package__title">
									<?= Yii::t('app', '3_pac') ?>
								</p>
								
								<p class="price_count"
									data-price="<?= number_format($priceData['productPac']['pricePac-3']['sale'], 0, '', ' ') ?><?= Yii::t('app', 'currency-symbol') ?>">
									<?= number_format($priceData['productPac']['pricePac-3']['sale'], 0, '', ' ') ?>		<?= Yii::t('app', 'currency-symbol') ?>
									<span class="sale-price_count">
										<?= number_format($priceData['productPac']['pricePac-3']['prise'], 0, '', ' ') ?>
										<?= Yii::t('app', 'currency-symbol') ?>
									</span>
								</p>
								<p class="promocode_question">
									<img src="/frontStyle/assets/images/ques.svg" alt="">
									<span><b><?= Yii::t('app', 'desc-prod-1') ?></b></span>
								</p>
							</div>
						<?php endif; ?>

					</div>
				<?php endif; ?>



				<form action="#" class="list_goods_item__quantity">
					<?php ?>
				<?php if (($currency == 'ru' && ($metaArray['type'] == 'simple' || $metaArray['type'] == 'made')) || (isset($parentArray['type']) && $parentArray['type'] == 'made')): ?>
						<div class="quantity_good">
							<div class="quantity_good_abs no_opened" data-id="<?= $model->id ?>">
								<div class="item active" data-value="1"><span>
										<?= Yii::t('app', 'product-cart-count') ?>
									</span>1 - Pack</div>
								<div class="item" data-value="2"><span>
										<?= Yii::t('app', 'product-cart-count') ?>
									</span>2 - Pack</div>
								<div class="item" data-value="3"><span>
										<?= Yii::t('app', 'product-cart-count') ?>
									</span>3 - Pack</div>
							</div>
							<input type="hidden" name="quantity">
						</div>
					<?php endif; ?>





					<button type="submit" name="add-to-cart" id="add_cart_product" class="add-to-cart"
						data-id="<?= $model->id ?>" data-count="1">
						<?= Yii::t('app', 'cart') ?>
					</button>
				</form>
				<?= $this->render('product-meta', [
					'currency' => $currency,
					'model' => $model
				]) ?>
				<?= $this->render('upsale-product', [
					'currency' => $currency,
					'upsale' => $upsale
				]) ?>
			</div>
		</div>
	</div>
</main>
<?= Cart::widget(['lang' => Yii::$app->request->get()['lang']]) ?>
<?php $this->registerJs('
	$("#content h1").remove();
	//$("#content h2").remove();
	$("#content .block-share-default").remove();
	$("#content .block-author-default").remove();
	$("#content img").each(function(e){
		$(this).attr("src", "https://anticandida.com"+$(this).data("src"));
	});
	$("#content div").each(function(e){
		$(this).attr("contenteditable", false);
	});
	$(document).on("click", ".product_certificats img", function(e){
		// $(".fancybox-content").css("top")
		parent.postMessage({
            scroll: "scroll",
        }, "*");
        
	});
'); ?>
<style>
	h2 {
		text-transform: inherit !important;
	}

	/* .add-te,
	.contrel-text {
		font-weight: 400 !important;
	} */
	.tit_elm .titleLiner, .title-text.default span {
    display: block;
    width: 20%;
    height: 3px;
    background: #00a6ca;
    margin-bottom: 22px;
}
span.gap-text {
    display: block;
    width: 100%;
    height: 10px;
}

#mainH1, .block-tex-title.element-bord h2 {
    font-size: 32px;
    line-height: 38px;
    font-weight: 500;
    margin-bottom: 25px;
}
.add-te a,
.contrel-text a,
.articles-content a {
    font-weight: 500;
    color: #00a6ca;
}

.add-te a:hover,
.contrel-text a:hover {
    margin-left: -3px;
    margin-right: -3px;
    color: #fff;
    background: #00a6ca;
    padding-left: 3px;
    padding-right: 3px;
    border-radius: 2px;
    text-decoration: none !important;
}

.content-text-redactor {
    margin-bottom: 15px;
}
#content{
	margin-top: 50px;
}
.articles-content a {
    font-weight: 500;
    color: #00a6ca;
}
.content-text-redactor .contrel-text {
    font-size: 18px;
    line-height: 25px;
	font-weight: 300;
}
.choose_rate__items span{
	display: flex;
	align-items: center;
}
b,strong{
	font-weight: 500;
}
.add-te {
    font-size: 18px;
    font-family: Stem, serif;
}
</style>


<script>
    window.addEventListener('load', function () {
        parent.postMessage({
            he : document.documentElement.scrollHeight,
            path: document.location.pathname,
        }, '*');
    });

	var top = 0;
        window.addEventListener("message", function (e) {
            top = e.data.top;
        })
		console.log(top);

		
</script>


