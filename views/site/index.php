<?php
use app\widgets\Curren;
use app\widgets\Cart;

?>
<?php
function getDataArray($item ,$currency, $type){
    if($currency == 'ru'){
        if(isset($item['productMeta'][$type]) && !empty($item['productMeta'][$type])){
            return $item['productMeta'][$type];
        }else{
            return 'not set';
        }
    }else{
        if(isset($item['productMetaLangData'][$currency][$type]) && !empty($item['productMetaLangData'][$currency][$type])){
            return $item['productMetaLangData'][$currency][$type];
        }else{
            return 'not set';
        }
    }
}
?>
<?php
	$session = Yii::$app->session;
	$cart = $session->get('cart');
	debug($cart);
	?>
    
<section class="catalogs" id="catalogs">
    <div class="container">
        <div class="catalog" id="catalog">
            <div class="catalog__banner">
                <img src="/img/banner.jpg" alt="BALANCE" class="img ">
            </div>
            <nav class="sort flex-box">
                <form action="" method="GET" id="formSort">
                <select class="dropdown" id="dropdown" name="sort">
                    <option class="dropdown__name" value="0" <?= (!$sort ? "selected" : "")?>>
                    <?= Yii::t('app', '[our-category-product]')?>
                        
                    </option>
                    <?php foreach($category as $item):?>
                    <option class="dropdown__name" value="<?= $item['id']?>" <?= ($sort == $item['id'] ? "selected" : "")?>>
                        <?= $item['title']?>
                    </option>
                    <?php endforeach;?>
                </select>
                <button class="btn btn_sort">
                    <?php echo \Yii::t('app', '[sort-field]'); ?>
                </button>
                </form>
                <?= Curren::widget();?>
                
            </nav>
            <div class="card-wrapper flex-box">
                <?php foreach ($model as $item): ?>
                    <?= $this->render('product-card', [
                        'item' => $item,
                        'currency' => $currency,
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<!-- CRITERION -->
<?= Cart::widget(['lang' => Yii::$app->request->get()['lang']]) ?>