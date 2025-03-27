

<div class="pay-success-bg">
    <div class="block-data">
        <div class="title-set">
            Данные по оплате
        </div>
        <div class="block-text">
            <div class="lb-s">
                <h1>Для оплаты потвердите переход</h1>
                    <a href="/<?= $currensy?>/payment-inteleckt-succes?orderId=<?= $data?>" >Оплатить</a>                
            </div>
            <div class="rt-s">
                <h2>заказ №<?= $data?> от <?= date('d.m.Y')?></h2>
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
                        Итого: <?= $cart['totalData']['salePrice']?>₽
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