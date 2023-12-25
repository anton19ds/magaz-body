<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>










<main>
    <div class="all_shadow"></div>
    <div class="popup recovery_password">
        <div class="close_popup close_popup_svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <g clip-path="url(#clip0_1158_108032)">
                    <path
                        d="M11.1049 10L19.7712 1.33372C20.0763 1.0286 20.0763 0.533915 19.7712 0.228837C19.4661 -0.0762401 18.9714 -0.0762791 18.6663 0.228837L9.99999 8.89515L1.33372 0.228837C1.0286 -0.0762791 0.533915 -0.0762791 0.228837 0.228837C-0.0762401 0.533954 -0.0762792 1.02864 0.228837 1.33372L8.89511 9.99999L0.228837 18.6663C-0.0762792 18.9714 -0.0762792 19.4661 0.228837 19.7712C0.381376 19.9237 0.581337 20 0.781297 20C0.981258 20 1.18118 19.9237 1.33376 19.7712L9.99999 11.1049L18.6663 19.7712C18.8188 19.9237 19.0188 20 19.2187 20C19.4187 20 19.6186 19.9237 19.7712 19.7712C20.0763 19.4661 20.0763 18.9714 19.7712 18.6663L11.1049 10Z"
                        fill="black" />
                </g>
                <defs>
                    <clipPath id="clip0_1158_108032">
                        <rect width="20" height="20" fill="white" />
                    </clipPath>
                </defs>
            </svg>
        </div>
        <p class="title_popup">
            Забыли пароль?
        </p>
        <p class="description_popup">
            Укажите ваш E-Mail или имя пользователя.
            <br>
            Новый пароль вы получите по электронной почте.
        </p>
        <form action="#" name="receiving_password_form" class="receiving_password_form">
            <p>
                <textarea name="receiving_name" placeholder="Имя пользователя или E-Mail"></textarea>
            </p>
            <p>
                <input type="submit" value="Сбросить пароль">
            </p>
        </form>
    </div>
    <div class="popup success_recovery_password">
        <div class="close_popup close_popup_svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <g clip-path="url(#clip0_1158_108032)">
                    <path
                        d="M11.1049 10L19.7712 1.33372C20.0763 1.0286 20.0763 0.533915 19.7712 0.228837C19.4661 -0.0762401 18.9714 -0.0762791 18.6663 0.228837L9.99999 8.89515L1.33372 0.228837C1.0286 -0.0762791 0.533915 -0.0762791 0.228837 0.228837C-0.0762401 0.533954 -0.0762792 1.02864 0.228837 1.33372L8.89511 9.99999L0.228837 18.6663C-0.0762792 18.9714 -0.0762792 19.4661 0.228837 19.7712C0.381376 19.9237 0.581337 20 0.781297 20C0.981258 20 1.18118 19.9237 1.33376 19.7712L9.99999 11.1049L18.6663 19.7712C18.8188 19.9237 19.0188 20 19.2187 20C19.4187 20 19.6186 19.9237 19.7712 19.7712C20.0763 19.4661 20.0763 18.9714 19.7712 18.6663L11.1049 10Z"
                        fill="black" />
                </g>
                <defs>
                    <clipPath id="clip0_1158_108032">
                        <rect width="20" height="20" fill="white" />
                    </clipPath>
                </defs>
            </svg>
        </div>
        <p class="title_popup">
            Письмо с новым паролем отправлено
        </p>
        <p class="description_popup">
            Письмо с новым паролем было направлено на адрес электронной почты, привязанный к вашей учетной записи.
            Доставка сообщения может занять несколько минут. Если вы не получите от нас сообщение, проверьте папку
            “спам”.
        </p>
    </div>

    <section id="authorization_registration">
        <div class="container">
            <div class="authorization_registration__forms">
                <div class="container__authorization">
                    <h2>
                        <?php echo \Yii::t('app', 'aut'); ?>
                    </h2>
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => [
                            'class' => 'auth_reg_form'
                        ],
                    ]); ?>
                    <div>
                        <p>
                            <?= Html::textInput('LoginForm[username]', '', ['placeholder' => "Имя пользователя или E-Mail"]) ?>
                        </p>
                        <p>
                            <?= Html::textInput('LoginForm[password]', '', ['placeholder' => "Пароль"]) ?>
                        </p>
                        <p class="error_message">
                            <span>Неверно указан логин или пароль</span>
                        </p>
                    </div>
                    <p>
                        <input type="submit" name="door_submit" value="Войти" id="login-btn">
                    </p>
                    <?php ActiveForm::end(); ?>
                    
                    <p class="where_password">
                        <a href="#">Забыли свой пароль?</a>
                    </p>
                </div>
                <div class="door_socials">
                    <p>Войти с помощью</p>
                    <ul>
                        <li>
                            <a href="#">
                                <img src="/asset/images/vk.svg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="/asset/images/facebook.svg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="/asset/images/inst.svg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="/asset/images/gmail.svg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="/asset/images/yandex.svg" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="container__registration">
                    <h2>Регистрация</h2>
                    <?php $form = ActiveForm::begin([
                        'id' => 'refister-form',
                        'options' => [
                            'class' => 'auth_reg_form'
                        ],
                    ]); ?>
                    
                        <div>
                            <p>
                            <?= Html::textInput('Register[register]', '', ['placeholder' => "Имя пользователя или E-Mail"]) ?>
                            </p>
                            <div>
                                <p>На ваш почтовый ящик будет отправлен пароль.</p>
                                <p>Ваши личные данные будут использоваться для упрощения работы с сайтом, управления
                                    доступом к учетной записи, использования инфопродуктов, а также для других целей,
                                    описанных в нашей <a href="#">политике конфиденциальности.</a></p>
                            </div>
                            <p class="error_message">
                                <span>Личный кабинет с указанным почтовым ящиком уже существует</span>
                            </p>
                        </div>
                        <p>
                            <input type="submit" name="door_submit" value="Регистрация" id="register-btn">
                        </p>
                        <?php ActiveForm::end(); ?>


                </div>
            </div>
            <div class="door_socials">
                <p>Войти с помощью</p>
                <ul>
                    <li>
                        <a href="#">
                            <img src="/asset/images/vk.svg" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/asset/images/facebook.svg" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/asset/images/inst.svg" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/asset/images/gmail.svg" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/asset/images/yandex.svg" alt="">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</main>