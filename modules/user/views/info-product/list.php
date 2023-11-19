<?php
use app\models\Product;
use yii\bootstrap5\Modal;

?>
<main>
    <section id="list-lessons">
        <div class="container">
            <?php echo $this->render('../components/left_menu_user.php', [
                'lang' => $lang,
                'active' => 'infoproduct'
            ]) ?>
            <div class="infoproducts__main">
                <div class="breadcrumbs">
                    <ul>
                        <li>
                            <a href="#">Инфопродукты</a>
                        </li>
                        <li>
                            <a href="#">Все инфопродукты</a>
                        </li>
                        <li class="active">
                            <a href="#">
                                <?= $meta['productName'] ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <h1>
                    <?= $meta['productName'] ?>
                </h1>
                <div class="list_lessons">
                    <?php $keyS = 0; ?>
                    <?php foreach ($stepInfo as $key => $item): ?>
                        <?php if ($item->getCheck()) {
                            $add = null;
                            $keyS = $key + 1;
                        } else {
                            $add = 'no-step';
                        } ?>
                        <a href="/<?= $lang ?>/user/info-product/list/<?= $product_link ?>/<?= $item->id ?>"
                            class="lesson_course lesson_complete">
                            <div class="lesson_course__arrow">
                                <img src="/asset/images/arrow-lesson.svg" alt="">
                            </div>
                            <div class="lesson_course__content">
                                <div>
                                    <p class="lc_content__status">
                                        Задание выполнено
                                    </p>
                                    <p class="lc_content__name">
                                        <?= $item->title; ?>
                                    </p>
                                </div>
                                <p class="lesson_course__status">
                                    Выполнено
                                </p>
                            </div>
                        </a>
                    <?php endforeach; ?>

                    <a href="#" class="lesson_course lesson_expectation">
                        <div class="lesson_course__arrow">
                            <img src="/asset/images/arrow-lesson.svg" alt="">
                        </div>
                        <div class="lesson_course__content">
                            <div>
                                <p class="lc_content__status">
                                    Дата и время начала: 20.05.2023 - 10:00
                                </p>
                                <p class="lc_content__name">
                                    Лекция 1. Организационные моменты
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="#" class="lesson_course lesson_no_complete">
                        <div class="lesson_course__arrow">
                            <img src="/asset/images/arrow-lesson.svg" alt="">
                        </div>
                        <div class="lesson_course__content">
                            <div>
                                <p class="lc_content__status">
                                    Дата и время начала: 20.05.2023 - 10:00
                                </p>
                                <p class="lc_content__name">
                                    Лекция 2. Самодиагностика
                                </p>
                            </div>
                            <p class="lesson_course__status">
                                Не выполнено
                            </p>
                        </div>
                    </a>
                    <a href="#" class="lesson_course lesson_disabled">
                        <div class="lesson_course__arrow">
                            <img src="/asset/images/arrow-lesson.svg" alt="">
                        </div>
                        <div class="lesson_course__content">
                            <div>
                                <p class="lc_content__status">
                                    Дата и время начала: 22.05.2023 - 10.00
                                </p>
                                <p class="lc_content__name">
                                    Лекция 3. Работа ЖКТ в норме
                                </p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </section>
</main>