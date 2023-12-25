<?php
use app\widgets\Curren;
use app\widgets\Cart;
?>

<section class="catalogs" id="catalogs">
    <div class="container">
        <div class="catalog" id="catalog">
            <div class="catalog__banner">
                <img src="/img/banner.jpg" alt="BALANCE" class="img ">
            </div>
            <nav class="sort flex-box">
                <select class="dropdown" id="dropdown">
                    <option class="dropdown__name">
                        Все категории товаров
                    </option>
                    <?php foreach($category as $item):?>
                    <option class="dropdown__name" value="<?= $item['id']?>">
                        <?= $item['title']?>
                    </option>
                    <?php endforeach;?>
                </select>
                <button class="btn btn_sort">
                    СОРТИРОВАТЬ
                </button>
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
<section class="criterion" id="criterion">
    <div class="container">
        <ul class="criterion-list">
            <li class="criterion-item">
                <h4>
                    Правила Возврата
                </h4>
            </li>
            <li class="criterion-item">
                <h4>
                    ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ
                </h4>
            </li>
            <li class="criterion-item">
                <h4>
                    УСЛОВИЯ ОБСЛУЖИВАНИЯ
                </h4>
            </li>
        </ul>
    </div>
</section>


<?= Cart::widget(['lang' => Yii::$app->request->get()['lang']]) ?>