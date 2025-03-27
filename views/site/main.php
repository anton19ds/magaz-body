<?php
use app\widgets\Cart;
use app\widgets\CyrList;
?>
<main id="mainPage">
	<div class="container__main-store">
		<div class="main-store__banner">
			<a href="#">
				<img src="<?= ($mainImag ? $mainImag : '/img/banner.jpg')?>" alt="">
			</a>
		</div>
		<div class="main-store__filter">
			<form action="#">
				<select name="sort" class="dropdown" id="dropdown">
                    <option class="dropdown__name" value="0" <?= (!$sort ? "selected" : "")?>>
                    <?= Yii::t('app', 'our-category-product')?>
                    </option>
                    <?php foreach($category as $data => $item):?>
                    <option  value="<?= $data?>" <?= ($sort == $data ? "selected" : "")?>>
                        <?= $item?>
                    </option>
                    <?php endforeach;?>
				</select>
				<input type="submit" value="<?= Yii::t('app', 'sort-field')?>">
			</form>
		</div>
		<div class="list_goods">
			<?php foreach ($model as $item): ?>
				<?= $this->render('card', [
					'item' => $item,
					'currency' => $currency
				]) ?>
			<?php endforeach; ?>
			<?= CyrList::widget();?>
		</div>
	</div>
	<?= $this->render('../layouts/footer-link');?>
</main>
<?= Cart::widget(['lang' => Yii::$app->request->get()['lang']]) ?>


<?php $this->registerJs("
$(document).on('click', '.main-page-url-link', function(e){
	e.preventDefault();
	parent.postMessage({
		link: $(this).attr('data-link'),
		lang: $(this).attr('data-lang')
	}, '*');

})")?>


<?php if($sort):?>
	<script>
	varHe = document.getElementById('mainPage');
	parent.postMessage({
            he : varHe.scrollHeight,
            path: document.location.pathname,
        }, '*');
</script>
<?php else:?>
	<script>
    window.addEventListener('load', function () {
		varHe = document.getElementById('mainPage');
        parent.postMessage({
            he : varHe.scrollHeight,
            path: document.location.pathname,
        }, '*');
    });
</script>
<?php endif;?>

