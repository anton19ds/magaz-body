<?php
use app\models\Product;
use yii\bootstrap5\Modal;
?>
<main>
    <section id="lesson">
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
                            <a href="#">Мои инфопродукты</a>
                        </li>
                        <li class="active">
                            <a href="#">Anticandida PRO</a>
                        </li>
                    </ul>
                </div>

                <?= $content ?>



                
                <form action="#" method="post" class="agree_condition">
                    <div class="agree_condition__item">
                        <div>
                            <input type="checkbox" class="agree_cond__checkbox" id="agree_cond__checkbox1" value="yes">
                            <label for="agree_cond__checkbox1"></label>
                        </div>
                        <p>
                            Оформляя заказ, вы соглашаетесь с <a href="#" target="_blank">правилами возврата</a> и <a
                                href="#" target="_blank">условиями обслуживания</a>.
                        </p>
                    </div>
                    <div class="agree_condition__item">
                        <div>
                            <input type="checkbox" class="agree_cond__checkbox" id="agree_cond__checkbox2" value="yes">
                            <label for="agree_cond__checkbox2"></label>
                        </div>
                        <p>
                            Оформляя заказ, вы соглашаетесь с нашей <a href="#" target="_blank">политикой
                                конфиденциальности</a>, добровольно предоставляете свои персональные данные для
                            обработки заказа и уведомлений.
                        </p>
                    </div>
                    <div class="agree_condition__item">
                        <p>
                            Персональные данные, полученные из формы обратной связи надежно хранятся в нашей базе данных
                            в соответствии <a href="#" target="_blank">с действующим законодательством</a>.
                        </p>
                    </div>
                    <p class="agree_condition__submit">
                        <input type="submit" name="submit_agree" value="Продолжить">
                        <?php if ($nexStep): ?>
                            <a href="/<?= $lang ?>/user/info-product/list/<?= $product_link; ?>/<?= $nexStep['id'] ?>">Потвердить
                                прохождение и Перейти к следующему</a>
                        <?php endif; ?>
                    </p>
                </form>
            </div>
        </div>
    </section>
</main>