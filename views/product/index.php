<?php
use app\widgets\ApsellCart;
use app\widgets\Cart;
use app\widgets\Raite;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$imgJson = json_decode($model->getParam('image'), true);
$priseData = $model->getPriceProduct($currency);
?>

<div class="container">
    <div class="product-wrapper-view">
        <div class="param-title-set">
            <div class="breadcrambs">
                <ul>
                    <li><a href="/<?= $currency ?>">Магазин</a></li>
                    <li><a href="#">
                            <?= $metaArray['productName'] ?>
                        </a></li>
                </ul>
            </div>
            <div class="productTitle">
                <?= $metaArray['productName'] ?>
            </div>
        </div>
        <div id="product">
            <div class="center-block-tovar">
                <div class="param-tovar-ser">
                    <div class="raite_in_product_tovar">
                        <?= Raite::widget(['id' => $model->id]) ?>
                    </div>
                    <div class="img-product">
                        <?php if (isset($imgJson['array'])): ?>
                            <?php
                            $imgPrev = $imgJson['array'][array_key_first($imgJson['array'])];
                            ?>
                            <img src="<?= $imgPrev['value'] ?>" alt="<?= $imgPrev['name'] ?>">
                        <?php endif; ?>
                    </div>
                    <div class="img_prod_list">
                        <?php if (isset($imgJson['array'])): ?>
                            <?php foreach ($imgJson['array'] as $item): ?>
                                <div class="elem">
                                    <img src="<?= $item['value'] ?>" alt="">
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div id="content_product">
                    <?= $result ?>
                </div>

                <div class="rivers-form">

                    <?php if (Yii::$app->user->isGuest): ?>
                        <div class="title-riwers">
                            <div>ОТЗЫВЫ <span>
                                    <?= (!empty($reviews) ? count($reviews) : ' нет оценок') ?>
                                </span></div>
                            <div>Авторизуйтесь, чтобы добавить отзыв: <a href="">Войти</a> </div>
                        </div>
                    <?php else: ?>
                        <div class="title-riwers">
                            <div>ОТЗЫВЫ <span>
                                    <?= (!empty($reviews) ? count($reviews) : ' нет оценок') ?>
                                </span></div>
                            <div></div>
                        </div>

                        <?php $form = ActiveForm::begin(); ?>
                        <?= $form->field($reviewsForm, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
                        <?= $form->field($reviewsForm, 'product_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                        <div class="block-star-title field-reviews-star">
                            <div class="invalid-feedback"></div>
                            <div class="label-title-form-riw">
                                <label for="">Оставить отзыв</label>
                            </div>
                            <div class="star-list" id="reviews-star">
                                <div class="text-tt-st">
                                    Оценка:
                                </div>
                                <span>
                                    <input type="radio" id="star1" value="1" name="Reviews[star]" class="startListData"
                                        checked="checked">
                                    <label for="star1"></label>
                                </span>
                                <span>
                                    <input type="radio" id="star2" value="2" name="Reviews[star]" class="startListData">
                                    <label for="star2"></label>
                                </span>
                                <span>
                                    <input type="radio" id="star3" value="3" name="Reviews[star]" class="startListData">
                                    <label for="star3"></label>
                                </span>
                                <span>
                                    <input type="radio" id="star4" value="4" name="Reviews[star]" class="startListData">
                                    <label for="star4"></label>
                                </span>
                                <span>
                                    <input type="radio" id="star5" value="5" name="Reviews[star]" class="startListData">
                                    <label for="star5"></label>
                                </span>
                            </div>
                        </div>
                        <?= $form->field($reviewsForm, 'text')->textarea(['rows' => '6'])->label(false) ?>
                        <?= Html::submitButton('Опубликовать', ['class' => 'send-riwer']) ?>
                        <?php ActiveForm::end() ?>
                    <?php endif; ?>
                    <div class="rw-list-r">
                        <?php foreach ($reviews as $item): ?>
                            <div class="item-riw-s">
                                <div class="tit-ose">
                                    <div class="name-user">
                                        <?= $item['firstName'] ?>
                                        <?= $item['LastName'] ?>

                                        <div class="item-start">
                                        <?php $setStar = 5 - $item['star'] ?>
                                        <?php for ($i = 0; $i < $item['star']; $i++): ?>
                                            <span><img src="/img/star-active.svg" alt=""></span>
                                        <?php endfor; ?>
                                        <?php for ($i = 0; $i < $setStar; $i++): ?>
                                            <span><img src="/img/star-disabled.svg" alt=""></span>
                                        <?php endfor; ?>
                                    </div>
                                    </div>
                                    <div class="date-riw">
                                        <?= date("d.m.Y", $item['date'])?>
                                    </div>
                                    
                                </div>
                                <div class="text-s">
                                    <p>
                                        <?= $item['text'] ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>



            <div class="right-block-product">
                <ul class="product_prise">
                    <li>
                        <?= ($priseData['summ'] ? $priseData['summ'] : $priseData['price']) ?>
                        <?= $priseData['symbol'] ?>
                    </li>
                    <?php if ($priseData['summ']): ?>
                        <li>
                            <span><s>
                                    <?= $priseData['price'] ?>
                                    <?= $priseData['symbol'] ?>
                                </s></span>
                        </li>
                    <?php endif; ?>

                </ul>
                <div class="colect-data">
                    <div class="col-colect active">
                        <span>
                            <?= Yii::t('app', '1 pac') ?>
                        </span>
                        <span>
                            <?= ($priseData['summ'] ? $priseData['summ'] : $priseData['price']) ?>
                            <?= $priseData['symbol'] ?>
                            <?php if ($priseData['summ']): ?>
                                <s>
                                    <?= $priseData['price'] ?>
                                    <?= $priseData['symbol'] ?>
                                </s>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="col-colect">
                        <span>
                            <?= Yii::t('app', '2 pac') ?>
                        </span>
                        <span>
                            <?= ($priseData['summ'] ? $priseData['summ'] * 2 : $priseData['price'] * 2) ?>
                            <?= $priseData['symbol'] ?>
                            <?php if ($priseData['summ']): ?>
                                <s>
                                    <?= $priseData['price'] * 2 ?>
                                    <?= $priseData['symbol'] ?>
                                </s>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="col-colect">
                        <span>
                            <?= Yii::t('app', '3 pac') ?>
                        </span>
                        <span>
                            <?= ($priseData['summ'] ? $priseData['summ'] * 3 : $priseData['price'] * 3) ?>
                            <?= $priseData['symbol'] ?>
                            <?php if ($priseData['summ']): ?>
                                <s>
                                    <?= $priseData['price'] * 3 ?>
                                    <?= $priseData['symbol'] ?>
                                </s>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
                <div class="card_data add-to-cart" data-cyrrency="<?= $currency?>" data-id="<?= $model->id?>" data-price="<?= ($priseData['summ'] ? $priseData['summ'] : $priseData['price']) ?>" data-symbol="<?= $priseData['symbol'] ?>">
                    В корзину
                </div>

                <div class="block-info-pred">
                    <div class="se-y">
                        <div><img src="/img/pig.svg" alt=""></div>
                        <div> Платите дешевле
                            покупая комплекты</div>
                    </div>
                    <div class="se-y">
                        <div><img src="/img/car.svg" alt=""></div>
                        <div> Доставка товаров
                            по всему миру</div>
                    </div>
                    <div class="se-y">
                        <div><img src="/img/chek.svg" alt=""></div>
                        <div> 40 дней - гарантия
                            возврата денег</div>

                    </div>
                </div>
                <?php if (isset($metaArray['image-ser']) && !empty($metaArray['image-ser'])): ?>
                    <div class="ser-list">
                        <?php $dataArray = json_decode($metaArray['image-ser'], true); ?>
                        <?php if (isset($dataArray['array']) && !empty($dataArray['array'])): ?>
                            <?php foreach ($dataArray['array'] as $key => $data): ?>
                                <img src="<?= $data['value'] ?>" alt="">
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($metaArray['params_sale']) && !empty($metaArray['params_sale'])): ?>
                    <div class="params_type">
                        <div class="ter-y">
                            Детали продукта
                        </div>
                        <?php foreach (explode(';', $metaArray['params_sale']) as $key => $item): ?>
                            <div class="elem-div">
                                <?php foreach (explode(',', $item) as $key2 => $item2): ?>
                                    <div class="div-s-t">
                                        <?= $item2 ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                <div class="params_type">
                    <div class="ter-y">
                        Польза для здоровья
                    </div>
                    <?php if (isset($metaArray['params_sale_2']) && !empty($metaArray['params_sale_2'])): ?>
                        <?php foreach (explode(';', $metaArray['params_sale_2']) as $key => $item): ?>
                            <div class="elem-div">
                                <div class="div-s-t-d">
                                    <?= $item ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?= ApsellCart::widget(['title' => 'С ЭТИМ ТОВАРОМ БЕРУТ:', 'lang' => $currency]) ?>
            </div>
        </div>
    </div>
</div>


<!-- <div class="img-body">

</div> -->


<?= Cart::widget(['lang' => Yii::$app->request->get()['lang']]) ?>