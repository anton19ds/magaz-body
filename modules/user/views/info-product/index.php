<?php
use app\models\Product;
use app\widgets\Raite;
use yii\bootstrap5\Modal;

?>

<main>
    <section id="infoproducts">
        <div class="container">
            <?php echo $this->render('../components/left_menu_user.php', [
                'lang' => $lang,
                'active' => 'infoproduct'
            ]) ?>
            <div class="infoproducts__main">
                <h1>Инфопродукты</h1>
                <div class="list-infoproducts">
                    <?php foreach ($metaInfoProduct as $item): ?>
                        <?php $product = $item->getProduct(); ?>
                        <?php if (in_array($product->id, $listArray)) {
                            $access = [

                                'infoproduct_in_stock',
                                true,
                            ];
                        } else {
                            $access = [
                                'infoproduct_no_stock',
                                false
                            ];
                        } ?>

                        <?php
                        $prise = Product::priceData($product->id, $lang);
                        $meta = $product->arrayMeta();
                        ?>



                        <? // echo  Raite::widget(['id' => $product->id]); ?>



                        <div class="list-infoproducts__item <?= $access[0] ?>">
                            <div class="infoproduct_img">
                                <div class="icon_has_stock"></div>
                                <?php $image = $product->getImageProductList(); ?>
                                <?php if (!empty($image)): ?>
                                    <?php if (isset($image['array'][array_key_first($image['array'])])): ?>
                                        <img src="<?php echo $image['array'][array_key_first($image['array'])]['value'] ?>" alt="">
                                    <?php endif; ?>
                                <?php else: ?>
                                    <img src="/img/Rectangle 18.png" alt="">
                                <?php endif; ?>
                                <!-- <img src="asset/images/examples/infoproduct1.jpg" alt=""> -->
                            </div>
                            <div class="infoproduct_content">
                                <h3>
                                    <?= $meta['productName']; ?>
                                </h3>
                                <p class="description_infoproduct">
                                    <?php if ($meta['description']): ?>
                                        <?= $meta['description']; ?>
                                    <?php endif; ?>
                                </p>
                                <div class="rate-time_infoproduct">
                                    <div class="infoproduct_rate">
                                        <div class="infoproduct_rate_table">
                                            <span class="infoproduct_rate_active"></span>
                                            <span class="infoproduct_rate_active"></span>
                                            <span class="infoproduct_rate_active"></span>
                                            <span class="infoproduct_rate_active"></span>
                                            <span></span>
                                        </div>
                                        <p class="count_rate">(95)</p>
                                    </div>
                                    <p class="infoproduct_time">
                                        Курс активен до: 14.06.2022
                                    </p>
                                </div>

                                <div class="price-buttons_infoproduct">

                                    <?php if (!$access[1]): ?>

                                        <p class="price_infoproduct">
                                            <?php if (isset($prise['summ']) && !empty($prise['summ'])): ?>
                                                <?php echo $prise['summ'] . " " . $prise['symbolCode']; ?>
                                                <span class="sale-price_infoproduct">
                                                    <?php echo $prise['price'] . " " . $prise['symbolCode']; ?>
                                                </span>
                                            <?php else: ?>
                                                <?php echo $prise['price'] . " " . $prise['symbolCode']; ?>
                                            <?php endif; ?>
                                        </p>
                                        <div class="buttons_infoproduct">
                                            <a href="/<?= $lang ?>/user/view/<?= $product->id ?>" class="view_product">Что
                                                входит в
                                                курс?</a>
                                            <a href="#" class="stepr add-to-cart" data-cyrrency="<?= $lang ?>"
                                                data-id="<?= $product->id ?>" data-price="<?= $prise['price'] ?>"
                                                data-symbol="<?= $prise['symbolCode'] ?>">Купить подписку</a>
                                        </div>
                                    <?php else: ?>
                                        <div class="buttons_infoproduct">
                                            <a href="/<?= $lang ?>/user/info-product/<?= $meta['link'] ?>" class="view_product">Что
                                                входит в
                                                курс?</a>
                                            <a href="/<?= $lang; ?>/user/info-product/list/<?= $meta['link'] ?>">Смотреть</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>








                    <!-- <div class="list-infoproducts__item infoproduct_no_stock">
                        <div class="infoproduct_img">
                            <div class="icon_has_stock"></div>
                            <img src="asset/images/examples/infoproduct2.jpg" alt="">
                        </div>
                        <div class="infoproduct_content">
                            <h3>ЗДОРОВЫЕ ВОЛОСЫ И КОЖА ГОЛОВЫ БЕЗ ГРИБКА</h3>
                            <p class="description_infoproduct">
                                Самая технологичная и пошаговая инструкция по очищению и нормализации работы печени во
                                всем русскоязычном интернет-пространстве, очищенная от "воды" и заблуждений. Помощь при
                                тяжелых заболеваниях печени и ЖКТ... Помощь при тяжелых заболеваниях печени и ЖКТ...
                            </p>
                            <div class="rate-time_infoproduct">
                                <div class="infoproduct_rate">
                                    <div class="infoproduct_rate_table">
                                        <span class="infoproduct_rate_active"></span>
                                        <span class="infoproduct_rate_active"></span>
                                        <span class="infoproduct_rate_active"></span>
                                        <span class="infoproduct_rate_active"></span>
                                        <span></span>
                                    </div>
                                    <p class="count_rate">(12)</p>
                                </div>
                                <p class="infoproduct_time">
                                    Курс доступен: 180 дней
                                </p>
                            </div>
                            <div class="price-buttons_infoproduct">
                                <p class="price_infoproduct">
                                    4 000 &#8381;
                                    <span class="sale-price_infoproduct">
                                        6 000 &#8381;
                                    </span>
                                </p>
                                <div class="buttons_infoproduct">
                                    <a href="#">Что входит в курс?</a>
                                    <a href="#">Купить подписку</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="list-infoproducts__item infoproduct_no_stock">
                        <div class="infoproduct_img">
                            <div class="icon_has_stock"></div>
                            <img src="asset/images/examples/infoproduct3.jpg" alt="">
                        </div>
                        <div class="infoproduct_content">
                            <h3>ТЮБАЖ. ТЕХНОЛОГИЯ ОЧИЩЕНИЯ ПЕЧЕНИ (2023)</h3>
                            <p class="description_infoproduct">
                                Восстановление очистительной способности вашего фильтра крови и нормализация работы
                                организма. Помощь при тяжелых заболеваниях печени и ЖКТ... Помощь при тяжелых
                                заболеваниях печени и ЖКТ... Помощь при тяжелых заболеваниях печени и ЖКТ... Помощь при
                                тяжелых заболеваниях печени и ЖКТ...
                            </p>
                            <div class="rate-time_infoproduct">
                                <div class="infoproduct_rate">
                                    <div class="infoproduct_rate_table">
                                        <span class="infoproduct_rate_active"></span>
                                        <span class="infoproduct_rate_active"></span>
                                        <span class="infoproduct_rate_active"></span>
                                        <span class="infoproduct_rate_active"></span>
                                        <span></span>
                                    </div>
                                    <p class="count_rate">(54)</p>
                                </div>
                                <p class="infoproduct_time">
                                    Курс доступен: 180 дней
                                </p>
                            </div>
                            <div class="price-buttons_infoproduct">
                                <p class="price_infoproduct">
                                    4 000 &#8381;
                                    <span class="sale-price_infoproduct">
                                        6 000 &#8381;
                                    </span>
                                </p>
                                <div class="buttons_infoproduct">
                                    <a href="#">Что входит в курс?</a>
                                    <a href="#">Купить подписку</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
</main>


<style>
    .infoproduct_img img {
        max-width: 100%
    }
</style>