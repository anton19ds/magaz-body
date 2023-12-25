<?php
use app\models\Product;
use app\widgets\Raite;
use yii\bootstrap5\Modal;

$prise = Product::priceData($model['id'], $lang);
?>



<main>
    <section id="infoproduct_item">
        <div class="container">
            <?php echo $this->render('../components/left_menu_user.php', [
                'lang' => $lang,
                'active' => 'infoproduct'
            ]) ?>
            <div class="infoproducts__main item_infoproduct_no-stock">
                <div class="breadcrumbs">
                    <ul>
                        <li>
                            <a href="#">Инфопродукты</a>
                        </li>
                        <li class="active">
                            <a href="#">Все инфопродукты</a>
                        </li>
                    </ul>
                </div>
                <h1>
                    <?= $model['productMeta']['productName'] ?>
                </h1>
                <div class="infoproduct_container">
                    <div class="infoproduct_container__img">
                        <div class="icon_stock">
                            <span>Купите подписку для просмотра контента</span>
                        </div>
                        <?php if (!empty($model['productMeta']['image'])): ?>
                            <?php $image = json_decode($model['productMeta']['image'], true) ?>
                            <?php if (isset($image['array'][array_key_first($image['array'])])): ?>
                                <img src="<?php echo $image['array'][array_key_first($image['array'])]['value'] ?>" alt="">
                            <?php endif; ?>

                        <?php else: ?>
                            <img src="/img/Rectangle 18.png" alt="">
                        <?php endif; ?>
                    </div>
                    <div class="infoproduct_container__description">
                        <?= $model['productMeta']['description'] ?>
                    </div>
                </div>
                <div class="infoproduct_container__links">
                    <div class="container_link_in-stock">
                        <a href="#" class="container_link-question">Задать вопрос</a>
                        <a href="#">Общий чат в Telegram</a>
                    </div>
                    <div class="container_link_no-stock">

                    <!-- <button class="btn btn_basket add-to-cart" data-cyrrency="ru" data-id="21" data-price="4800" data-symbol="₽">
                В корзину            </button> -->
    
                        <a href="#" class="add-to-cart" data-cyrrency="<?= $lang?>" data-id="<?= $model['id']?>" data-price="<?= $prise['price'];?>" data-symbol="<?= $prise['symbolCode'];?>">Приобрести курс</a>
                    </div>
                </div>
                <div class="infoproduct__list-modules">
                    <?php $i = 0; ?>
                    <?php foreach ($model['infoStep'] as $step): ?>
                        <?php
                        $imageStep = null;
                        if (!empty($step['img'])) {
                            $imageStepArray = json_decode($step['img'], true);
                            $imageStep = $imageStepArray['array'][1]['value'];
                        }
                        ?>

                        <div class="list-modules__item list-modules__item-close">
                            <a href="#">
                                <div class="item_modules__img">
                                    <?php if ($imageStep): ?>
                                        <img src="<?= $imageStep ?>" alt="">
                                    <?php endif; ?>
                                </div>
                                <p class="item_modules__title">
                                    <?= $i; ?> Этап.
                                    <?= $step['title'] ?>
                                </p>
                                <p class="item_modules__count-lessons">
                                    5 уроков
                                </p>
                                <p class="item_modules__status">
                                    Пройден
                                </p>
                                <div class="item_modules__progress">
                                    <span></span>
                                </div>
                            </a>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </div>
                <p class="time_course_limit">Информационный курс активен до: 22.12.2023</p>
            </div>
        </div>
    </section>
</main>