<div class="pay-success-bg">
    <div class="block-data">
        <div class="title-set">
            Данные по оплате
        </div>
        <div class="block-text">
            <div class="lb-s">
                <h1>Для оплаты заказа сделайте ручной перевод на карту банка РФ или EU</h1>
                
                <h3>Данное сообщение было продублировано на ваш e-mail.</h3>
                <h3>Если вы не получили письмо подождите несколько минут и проверьте папку СПАМ.</h3>

                СБЕРБАНК: 4276 2000 1123 7893 <br>
                АЛЬФА-БАНК: 4261 0127 0871 0026 <br>
                ТИНЬКОВ-БАНК: 5536 9138 1328 1959
                <br>
                <br>
                <h3>Европейская карта для переводов:</h3>
                WISE: 5167 9856 6062 4099 / IBAN: KZAA BBBХ ХХХХ ХХХХ ХХХХ

                <br>
                В комментариях к платежу ничего не указывайте. <br>
                Чека c номером вашего заказа отправьте на e-mail менеджеру.
            </div>
            <div class="rt-s">
                <h2>заказ №3238 от 28.12.2023</h2>
                Статус: “В ожидании оплаты”
                <ul>
                    <li>
                        <span>Товар:</span>
                        <span>Скидка</span>
                    </li>
                    <?php foreach($cart['data'] as $item):?>
                    <li>
                        
                    
                        <span><?= $item['productName']?> × <?= $item['count']?> -  <?= $item['price']?> <?= $item['symbol']?></span>
                        <span>- 800 ₽</span>
                    </li>
                    <?php endforeach;?>
                    <li>
                        Итого: <?= $cart['summCart']?> ₽
                    </li>
                </ul>
                <h3>Адрес доставки:</h3>

                <?= $user['firstName']; ?> <?= $user['LastName']; ?> <?= $user['secondName']; ?><br>
                <?= $userAdress['postcode']?>, <?= $userAdress['city']?>, <?= $userAdress['country']?>, <?= $userAdress['area']?>, <?= $userAdress['flat']?>, <?= $userAdress['street']?><br>
                <?= $user['phone']; ?><br>
                <?= $user['email']; ?>
            </div>
        </div>
        <div class="em-bl">
        <a href="">info@body-balance.com</a>
        </div>
        <div class="soc-chat">
            <a href="" style = "background-color: #34C456;"><img src="/img/whatsapp.svg" alt=""></a>
            <a href="" style = "background-color: #7B59E9;"><img src="/img/Viber.svg" alt=""></a>
            <a href="" style = "background-color: #039BE5;"><img src="/img/telegram.png" alt=""></a>
        </div>
    </div>
</div>