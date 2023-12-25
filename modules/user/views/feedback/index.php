<?php
use yii\bootstrap5\Modal;

?>
<div class="all_shadow"></div>
<section id="history_orders">
    <div class="container">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'history'
        ]) ?>
        <div class="infoproducts__main">
					<h1>Обратная связь</h1>
					<div class="content_contacts">
						<div>
							<p>
								Телефон поддержки: <a href="tel:+79005655005">+7 (900) 565-5005</a>
							</p>
							<ul class="socials_feedback">
								<li>
									<a href="#">
										<img src="assets/images/whatsapp.svg" alt="">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="assets/images/viber.svg" alt="">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="assets/images/tg.svg" alt="">
									</a>
								</li>
							</ul>
						</div>
						<div>
							<p>
								E-mail: <a href="mailto:info@body-balance.com">info@body-balance.com</a>
							</p>
						</div>
					</div>
					<form action="#" method="post" id="feedback_form">
						<p>
							<input type="text" name="feedback_theme" placeholder="Тема">
						</p>
						<p>
							<textarea name="feedback_message" rows="6" placeholder="Ваше сообщение"></textarea>
						</p>
						<p class="feedback_form__sub">
							<input type="submit" value="Отправить">
						</p>
					</form>
				</div>
</section>