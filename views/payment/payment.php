	<main>
		<div class="container-result_pay result_pay-success">
        <div class="title-set success">
            <?= Yii::t('app', 'payment-success-set')?>
        </div>
			<div class="section_result_pay__info">
				<h3>Вам на E-MAIL отправлена информация о заказе и платеже</h3>
				<p>Если сообщение не поступило, подождите несколько минут и проверьте папку СПАМ.</p>
				<p>Посылка с товаром будет отправлена в течение трех рабочих дней. После этого вы получите трек-номер почтового отправления, по которому сможете отслеживать статус доставки товара. Уведомление поступит на e-mail и в sms на указанный телефонный номер.</p>
				<p>В случае возникновения вопросов, напишите в службу поддержки <br>в один из мессенджеров или по адресу электронной почты:</p>
				<a href="mailto:<?= Yii::t('app', 'email')?>" class="result_pay_info__email"><?= Yii::t('app', 'email')?></a>
				<div class="result_pay_info__socials">
					<a href="<?= Yii::t('app', "whatsapp")?>" class="result_pay_info_socials__wa" target="_blank">
						<img src="/img/whatsapp.svg" alt="">
					</a>
					<a href="<?= Yii::t('app', "viber")?>" class="result_pay_info_socials__viber" target="_blank">
						<img src="/img/Viber.svg" alt="">
					</a>
					<a href="<?= Yii::t('app', "telegram")?>" class="result_pay_info_socials__tg" target="_blank">
						<img src="/img/telegram.png" alt="">
					</a>
				</div>
				<img src="/img/list1.png" class="list_mob" alt="">
			</div>
		</div>
	</main>