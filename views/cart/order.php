<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>
<input type="hidden" id="currensy" value="<?= $currensy ?>">

<?php $form = ActiveForm::begin([
    'id' => 'form-order'
]); ?>
<?php
function getValue($cart, $type)
{
    if (isset($cart['user'][$type]) && !empty($cart['user'][$type])) {
        return $cart['user'][$type];
    }
}


?>
<div class="product-wrapper">
    <div class="top-prod-header">
        <div>Контактная информация</div>
        <div>Вы уже зарегестрированы? <a href="/<?= $currensy?>/login?page=order">Войти</a></div>
    </div>

    <div class="form-order-user">
        <div class="block-form">
            <input type="text" name="email" class="set-input-data" id="email" placeholder="  "
                value="<?php echo getValue($cart, 'email'); ?>" />
            <label for="email"> E-mail </label>
        </div>
        <div class="block-form checkbox">
            <div class="chekbox  set-ceck active">
                <input type="checkbox" name="smms-get" id="smms-get" checked />
                <label for="smms-get">Сообщать мне об акциях и скидках<input type="checkbox" name="smms-get"
                        id="smms-get" /></label>
            </div>
        </div>
        <div class="block-form phone">
            <div class="after-block-proms">
                <div class="prom">
                    Введите телефон, если хотите, чтобы мы <br />
                    присылали информацию о вашем заказе в СМС
                </div>
            </div>
            <input type="text" name="phone" class="set-input-data" id="phone" placeholder=" "
                value="<?php echo getValue($cart, 'phone'); ?>" />
            <label for="phone"> Телефон </label>
        </div>

        <div class="block-form checkbox border-s">
            <div class="chekbox active">
                <input type="checkbox" name="sms-set" id="sms-set" checked />
                <label for="sms-set" style="margin-top: -2px;">
                    <p>
                        Получать СМС оповещения о моем заказе
                        <span>Сразу после отправки заказа вы получите трек-номер
                            посылки на e-mail и в sms для отслеживания актуальной
                            информации о местонахождении отправления.</span>
                    </p>
                </label>
            </div>
        </div>

        <div class="set-asset">Адрес доставки</div>

        <div class="block-form">
            <input type="text" name="country" class="set-input-data" id="country" placeholder=" "
                value="<?php echo getValue($cart, 'country'); ?>" />
            <label for="country"> Страна </label>
        </div>

        <div class="flex-set-col">
            <div class="col-block-set-form">
                <div class="block-form">
                    <input type="text" name="postcode" class="set-input-data" id="postcode" placeholder=" "
                        value="<?php echo getValue($cart, 'postcode'); ?>" />
                    <label for="postcode">Индекс</label>
                </div>
                <div class="block-form">
                    <input type="text" name="city" class="set-input-data" id="city" placeholder=" "
                        value="<?php echo getValue($cart, 'city'); ?>" />
                    <label for="city">Город</label>
                </div>
            </div>

            <div class="col-block-set-form">
                <div class="block-form">
                    <input type="text" name="area" class="set-input-data" id="area" placeholder=" "
                        value="<?php echo getValue($cart, 'area'); ?>" />
                    <label for="area">Область</label>
                </div>
                <div class="block-form">
                    <input type="text" name="street" class="set-input-data" id="street" placeholder=" "
                        value="<?php echo getValue($cart, 'street'); ?>" />
                    <label for="street">Улица</label>
                </div>
            </div>
        </div>

        <div class="block-form">
            <input type="text" name="house" class="set-input-data" id="house" placeholder=" "
                value="<?php echo getValue($cart, 'house'); ?>" />
            <label for="house">Дом, корпус, строение, квартира</label>
        </div>

        <div class="flex-set-trit-col">
            <div class="block-form">
                <input type="text" name="surname" class="set-input-data" id="surname" placeholder=" "
                    value="<?php echo getValue($cart, 'surname'); ?>" />
                <label for="surname">Фамилия</label>
            </div>
            <div class="block-form">
                <input type="text" name="name" class="set-input-data" id="name" placeholder=" "
                    value="<?php echo getValue($cart, 'name'); ?>" />
                <label for="name">Имя</label>
            </div>
            <div class="block-form">
                <input type="text" name="lastname" class="set-input-data" id="lastname" placeholder=" "
                    value="<?php echo getValue($cart, 'lastname'); ?>" />
                <label for="lastname">Отчество</label>
            </div>
        </div>
        <div class="block-form text-area">
            <textarea name="comment" id="comment" cols="30" rows="6"
                placeholder=" "><?php echo getValue($cart, 'comment'); ?></textarea>
            <label for="for">Комментарии к заказу</label>
        </div>
        <div class="set-end-block">
            <a href="" class="back-cart"> Вернуться в корзину </a>
            <?= Html::submitButton('Продолжить', ['class' => 'next-step', 'id' => 'send-form']) ?>
        </div>
    </div>
</div>
</div>




<div class="left-block">
    <?= $this->render('min-cart', [
        'cart' => $cart,
    ]) ?>
</div>
<?php ActiveForm::end(); ?>