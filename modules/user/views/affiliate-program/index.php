<div class="all_shadow"></div>
<section id="history_orders">
    <div class="container">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'history'
        ]) ?>
        <div class="infoproducts__main">
            <h1>Ваши промокоды</h1>
            

<?php if($user->promo_active == '2'):?>
            <div class="section_add_new_promocode">
                <h3>Создайте новый промокод</h3>
                <div class="actual_precents">
                    <p class="actual_precents__title">Ваши актуальные проценты вознаграждения</p>
                    <table>
                        <tbody>
                            <tr>
                                <td>Физические товары:</td>
                                <td>30%</td>
                            </tr>
                            <tr>
                                <td>Инфопродукты:</td>
                                <td>35%</td>
                            </tr>
                            <tr>
                                <td>Мед.услуги</td>
                                <td>20%</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="button_add_promocode"><span>Создать промокод</span></p>
                </div>
            </div>
<?php endif;?>
            <div class="list_promocodes">
            <?= $this->render('promocodes__item', [
                'userPromo' => $userPromo,
                'lang' => $lang
            ])?>
                
            </div>
            <a href="#" class="benefit_link">Хочу более выгодные условия</a>
            <div class="use_tg_link">
                <a href="#">
                    <span>Подключить телеграм</span>
                    <img src="/asset/images/tg_quadro.svg" alt="">
                </a>
            </div>
        </div>
    </div>
</section>



<div class="popup benefit_popup" style="display: none;">
			<div class="close_popup close_popup_svg">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
					<g clip-path="url(#clip0_1158_108032)">
						<path d="M11.1049 10L19.7712 1.33372C20.0763 1.0286 20.0763 0.533915 19.7712 0.228837C19.4661 -0.0762401 18.9714 -0.0762791 18.6663 0.228837L9.99999 8.89515L1.33372 0.228837C1.0286 -0.0762791 0.533915 -0.0762791 0.228837 0.228837C-0.0762401 0.533954 -0.0762792 1.02864 0.228837 1.33372L8.89511 9.99999L0.228837 18.6663C-0.0762792 18.9714 -0.0762792 19.4661 0.228837 19.7712C0.381376 19.9237 0.581337 20 0.781297 20C0.981258 20 1.18118 19.9237 1.33376 19.7712L9.99999 11.1049L18.6663 19.7712C18.8188 19.9237 19.0188 20 19.2187 20C19.4187 20 19.6186 19.9237 19.7712 19.7712C20.0763 19.4661 20.0763 18.9714 19.7712 18.6663L11.1049 10Z" fill="black"></path>
					</g>
					<defs>
						<clipPath id="clip0_1158_108032">
							<rect width="20" height="20" fill="white"></rect>
						</clipPath>
					</defs>
				</svg>
			</div>
			<p class="title_popup">
				Почему вы хотите более выгодные условия?
			</p>
			<p class="description_popup">
				Опишите ваши возможности, имеющиеся информационые ресурсы и аккаунты
				(YouTube, Instagram, vk, fb и другие), укажите количество ваших подписчиков. <br>Как вы намерены способствовать нашему продвижению?
			</p>
			<form action="#" name="receiving_password_form" class="why_benefit_form">
				<p>
					<textarea name="why_benefit" placeholder="Описание в свободной форме"></textarea>
				</p>
				<p>
					<input type="submit" value="Отправить">
				</p>
			</form>
		</div>


        <div class="popup add_promocode_popup" style="display: none;">
			<div class="close_popup close_popup_svg">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
					<g clip-path="url(#clip0_1158_108032)">
						<path d="M11.1049 10L19.7712 1.33372C20.0763 1.0286 20.0763 0.533915 19.7712 0.228837C19.4661 -0.0762401 18.9714 -0.0762791 18.6663 0.228837L9.99999 8.89515L1.33372 0.228837C1.0286 -0.0762791 0.533915 -0.0762791 0.228837 0.228837C-0.0762401 0.533954 -0.0762792 1.02864 0.228837 1.33372L8.89511 9.99999L0.228837 18.6663C-0.0762792 18.9714 -0.0762792 19.4661 0.228837 19.7712C0.381376 19.9237 0.581337 20 0.781297 20C0.981258 20 1.18118 19.9237 1.33376 19.7712L9.99999 11.1049L18.6663 19.7712C18.8188 19.9237 19.0188 20 19.2187 20C19.4187 20 19.6186 19.9237 19.7712 19.7712C20.0763 19.4661 20.0763 18.9714 19.7712 18.6663L11.1049 10Z" fill="black"></path>
					</g>
					<defs>
						<clipPath id="clip0_1158_108032">
							<rect width="20" height="20" fill="white"></rect>
						</clipPath>
					</defs>
				</svg>
			</div>
			<p class="title_popup">
				Создание нового промокода
			</p>
			<p class="description_popup">
				Внимание!<br>
				Производите настройку тщательно, так как изменить данные в созданном промокоде будет невозможно.
			</p>
			<form action="#" id="form_add_promocode">
				<div class="form_add_promocode__input nick_new_promocode">
					<div class="nick_new_promocode__before">
						<p class="promocode_question">
							<img src="assets/images/question.svg" alt="">
							<span>Совокупность букв и цифр, дающая покупателям скидку в магазине и % отчисления партнёру с их покупок. Рекомендация: не используйте в качестве промокода случайный набор символов. Задайте какое-нибудь слово, связаное с тематикой сайта, чтобы “замаскировать” вашу ссылку.</span>
						</p>
						<label for="name_new_promocode">Название промокода:</label>
					</div>
					<div class="nick_new_promocode__inp">
						<input type="text" id="name_new_promocode" name="name_new_promocode">

						<span class="nick_promocode_notification nick_occupied">Название занято</span>
						<span class="nick_promocode_notification nick_open">Название свободно</span>
						<span class="nick_promocode_notification nick_disable">Неподходящее название</span>
					</div>
					<div class="nick_new_promocode__result">
						<p class="promocode_question">
							<img src="assets/images/question.svg" alt="">
							<span>Так будет выглядеть ваша партнёрская ссылка со “вшитым” в неё промокодом. При переходе пользователей по данной ссылке, промокод учитывается автоматически и будет действовать при всех последующих заходах клиентов на сайт. Следовательно, если они решат совершить покупки - вы получите % вознаграждение.</span>
						</p>
						<p>
							body-balance.com/<span class="result_nick_promocode"></span>
						</p>
					</div>
				</div>
				<div class="form_add_promocode__input target_link_promocode">
					<div class="target_link_promocode__before">
						<p class="promocode_question">
							<img src="assets/images/question.svg" alt="">
							<span>Введите в это поле url любой страницы сайта, на которую вы хотите направлять пользователей. Например: просто на главную страницу сайта “body-balance.com/ru” или страницу магазина “body-balance.com/ru/shop”. При переходе по вашей реферальной ссылке пользователи будут попадать на заданную вами страницу.
Совет: тщательно выбирайте страницу, это будет первое что увидят ваши клиенты. </span>
						</p>
						<label for="link_new_promocode">Целевая ссылка:</label>
					</div>
					<div class="target_link_promocode__inp">
						<input type="text" id="link_new_promocode" name="name_new_promocode">
					</div>
				</div>
				<div class="table_add_promocode_percents">
					<div class="promocode_percents__line">
						<div class="promocode_percents__group">
							<span class="promocode_question">
								<img src="assets/images/question.svg" alt="">
								<span>Разные группы товаров имеют разный % вознаграждения.</span>
							</span>
							<span class="promocode_line__title">Товарные группы</span>
						</div>
						<div class="promocode_percents__sale-clients">
							<span class="promocode_question">
								<img src="assets/images/question.svg" alt="">
								<span>Задайте процент скидки которую получит пользователь, перейдя по вашей партнёрской ссылке.
“Скидка покупателю” = “Сумма” - “Ваш процент”</span>
							</span>
							<span class="promocode_line__title">Процент скидки для клиента</span>
						</div>
						<div class="promocode_percents__you-prize">
							<span class="promocode_question">
								<img src="assets/images/question.svg" alt="">
								<span>Задайте процент вашего личного вознаграждения.
“Ваш процент” = “Сумма” - “Скидка покупателю”</span>
							</span>
							<span class="promocode_line__title">Процент вашего вознаграждения</span>
						</div>
					</div>
					<div class="promocode_percents__line">
						<div class="promocode_percents__group">
							<div class="promocode_percents_line__mob">
								<span class="promocode_question">
									<img src="assets/images/question.svg" alt="">
									<span>Разные группы товаров имеют разный % вознаграждения.</span>
								</span>
								Товарная группа: Физические товары (30%)
							</div>
							<span>Физические товары (30%):</span>
						</div>
						<div class="promocode_percents__sale-clients">
							<div class="promocode_percents_line__mob">
								<span class="promocode_question">
									<img src="assets/images/question.svg" alt="">
									<span>Задайте процент скидки которую получит пользователь, перейдя по вашей партнёрской ссылке.
“Скидка покупателю” = “Сумма” - “Ваш процент”</span>
								</span>
								Процент скидки для клиента
							</div>
							<p><input type="number" data-summ="30" group_percent="1" value="0"></p>
						</div>
						<div class="promocode_percents__you-prize">
							<div class="promocode_percents_line__mob">
								<span class="promocode_question">
									<img src="assets/images/question.svg" alt="">
									<span>Задайте процент вашего личного вознаграждения.
“Ваш процент” = “Сумма” - “Скидка покупателю”</span>
								</span>
								Процент вашего вознаграждения
							</div>
							<p><input type="number" data-summ="30" group_percent="1" value="0"></p>
						</div>

						<span class="percent_error percent_error_big">Вы не можете ввести суммарный процент больше чем есть у вас</span>
						<span class="percent_error percent_error_small">Вы не можете ввести суммарный процент меньше чем есть у вас</span>
					</div>
					<div class="promocode_percents__line">
						<div class="promocode_percents__group">
							<div class="promocode_percents_line__mob">
								<span class="promocode_question">
									<img src="assets/images/question.svg" alt="">
									<span>Разные группы товаров имеют разный % вознаграждения.</span>
								</span>
								Товарная группа: Инфопродукты (35%)
							</div>
							<span>Инфопродукты (35%):</span>
						</div>
						<div class="promocode_percents__sale-clients">
							<div class="promocode_percents_line__mob">
								<span class="promocode_question">
									<img src="assets/images/question.svg" alt="">
									<span>Задайте процент скидки которую получит пользователь, перейдя по вашей партнёрской ссылке.
“Скидка покупателю” = “Сумма” - “Ваш процент”</span>
								</span>
								Процент скидки для клиента
							</div>
							<p><input type="number" data-summ="35" group_percent="2" value="0"></p>
						</div>
						<div class="promocode_percents__you-prize">
							<div class="promocode_percents_line__mob">
								<span class="promocode_question">
									<img src="assets/images/question.svg" alt="">
									<span>Задайте процент вашего личного вознаграждения.
“Ваш процент” = “Сумма” - “Скидка покупателю”</span>
								</span>
								Процент вашего вознаграждения
							</div>
							<p><input type="number" data-summ="35" group_percent="2" value="0"></p>
						</div>

						<span class="percent_error percent_error_big">Вы не можете ввести суммарный процент больше чем есть у вас</span>
						<span class="percent_error percent_error_small">Вы не можете ввести суммарный процент меньше чем есть у вас</span>
					</div>
					<div class="promocode_percents__line">
						<div class="promocode_percents__group">
							<div class="promocode_percents_line__mob">
								<span class="promocode_question">
									<img src="assets/images/question.svg" alt="">
									<span>Разные группы товаров имеют разный % вознаграждения.</span>
								</span>
								Товарная группа: Мед. услуги (20%)
							</div>
							<span>Мед. услуги (20%):</span>
						</div>
						<div class="promocode_percents__sale-clients">
							<div class="promocode_percents_line__mob">
								<span class="promocode_question">
									<img src="assets/images/question.svg" alt="">
									<span>Задайте процент скидки которую получит пользователь, перейдя по вашей партнёрской ссылке.
“Скидка покупателю” = “Сумма” - “Ваш процент”</span>
								</span>
								Процент скидки для клиента
							</div>
							<p><input type="number" data-summ="20" group_percent="3" value="0"></p>
						</div>
						<div class="promocode_percents__you-prize">
							<div class="promocode_percents_line__mob">
								<span class="promocode_question">
									<img src="assets/images/question.svg" alt="">
									<span>Задайте процент вашего личного вознаграждения.
“Ваш процент” = “Сумма” - “Скидка покупателю”</span>
								</span>
								Процент вашего вознаграждения
							</div>
							<p><input type="number" data-summ="20" group_percent="3" value="0"></p>
						</div>

						<span class="percent_error percent_error_big">Вы не можете ввести суммарный процент больше чем есть у вас</span>
						<span class="percent_error percent_error_small">Вы не можете ввести суммарный процент меньше чем есть у вас</span>
					</div>
				</div>
				<p class="submit_add_promocode">
					<input type="submit" name="add_promocode" value="Сохранить">
				</p>
			</form>
		</div>