<a href="/<?= $lang ?>/user/info-product/list/<?= $product_link ?>/<?= $item['id'] ?>" class="lesson_course lesson_disabled">
    <div class="lesson_course__arrow">
        <img src="/asset/images/arrow-lesson.svg" alt="">
    </div>
    <div class="lesson_course__content">
        <div>
            <p class="lc_content__status">
                <?php if(!empty($item['time'])):?>
            Дата начала: <?php //$timestamp = $order['date'];
                $date_end = date("d.m.Y", strtotime('+' . $item['time'] . 'day', $dataProduct['date']));
                //echo $date_end;
                ?>
                <?php endif;?>
                <?php if(!empty($item['hourse'])):?>
                <?php //$timestamp = $order['date'];
                echo $item['hourse'];
                ?>
                <?php endif;?>
            </p>
            <p class="lc_content__name">
            <?= $item['title']; ?>
            </p>
        </div>
    </div>
</a>


<!-- <a href="#" class="lesson_course lesson_no_complete">
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
</a> -->