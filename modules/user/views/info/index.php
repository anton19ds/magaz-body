<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

?>

<?php Modal::begin([
    'id' => 'new-pass',
]) ?>
<?php $form = ActiveForm::begin() ?>
<?php echo $form->field($user, 'password')->passwordInput(['value' => ''])->label('Новый пароль') ?>
<?php echo $form->field($user, 'rePass')->passwordInput()->label('Повторить пароль') ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-info', 'style' => 'color: #fff']) ?>
<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<div class="all_shadow"></div>

<section id="personal_data">
    <div class="container">

        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'info'
        ]) ?>

        <div class="infoproducts__main">
            <h1>Личные данные</h1>
            <div class="contacts_information">
                <div class="contacts_information__item">
                    <p class="info_item__title">
                        E-mail и имя пользователя
                        <span class="edit_contact_information">
                            Редактировать
                        </span>
                    </p>
                    <p>
                        <?= $user->email?>
                    </p>
                    <p>
                        info-cz
                        <span class="description_meta_contacts">
                            Так ваше имя будет отображаться в разделе учётной записи и при просмотрах.
                        </span>
                    </p>
                </div>
                <div class="contacts_information__item">
                    <p class="info_item__title">
                        Пароль
                        <span class="edit_contact_information">
                            Редактировать
                        </span>
                    </p>
                </div>
                <div class="contacts_information__item">
                    <p class="info_item__title">
                        Контакты
                        <span class="edit_contact_information">
                            Редактировать
                        </span>
                    </p>
                    <ul class="info_item__socials">
                        <li class="required_social">
                            <a href="#">
                                <svg fill="#9B9B9B" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30"
                                    viewBox="0 0 260 260" enable-background="new 0 0 260 260" xml:space="preserve">
                                    <path d="M164.58,64H95.42C78.1,64,64,78.1,64,95.42v69.16C64,181.9,78.1,196,95.42,196h69.16c17.32,0,31.42-14.1,31.42-31.42V95.42
                                                C196,78.1,181.9,64,164.58,64z M130,171.1c-22.66,0-41.1-18.44-41.1-41.1s18.44-41.1,41.1-41.1s41.1,18.44,41.1,41.1
                                                S152.66,171.1,130,171.1z M172.22,97.3c-5.3,0-9.6-4.3-9.6-9.61c0-5.3,4.3-9.6,9.6-9.6c5.31,0,9.61,4.3,9.61,9.6
                                                C181.83,93,177.53,97.3,172.22,97.3z M130,102.9c-14.94,0-27.1,12.16-27.1,27.1s12.16,27.1,27.1,27.1s27.1-12.16,27.1-27.1
                                                S144.94,102.9,130,102.9z M130,2C59.31,2,2,59.31,2,130s57.31,128,128,128s128-57.31,128-128S200.69,2,130,2z M210,164.58
                                                c0,25.04-20.38,45.42-45.42,45.42H95.42C70.38,210,50,189.62,50,164.58V95.42C50,70.38,70.38,50,95.42,50h69.16
                                                C189.62,50,210,70.38,210,95.42V164.58z" />
                                </svg>
                            </a>
                        </li>
                        <li class="required_social">
                            <a href="#">
                                <svg fill="#9B9B9B" width="30" height="30" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12c0-6.627-5.373-12-12-12zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <svg fill="#9B9B9B" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30"
                                    viewBox="0 0 97.75 97.75" xml:space="preserve">
                                    <g>
                                        <path d="M48.875,0C21.883,0,0,21.882,0,48.875S21.883,97.75,48.875,97.75S97.75,75.868,97.75,48.875S75.867,0,48.875,0z
                                                     M73.667,54.161c2.278,2.225,4.688,4.319,6.733,6.774c0.906,1.086,1.76,2.209,2.41,3.472c0.928,1.801,0.09,3.776-1.522,3.883
                                                    l-10.013-0.002c-2.586,0.214-4.644-0.829-6.379-2.597c-1.385-1.409-2.67-2.914-4.004-4.371c-0.545-0.598-1.119-1.161-1.803-1.604
                                                    c-1.365-0.888-2.551-0.616-3.333,0.81c-0.797,1.451-0.979,3.059-1.055,4.674c-0.109,2.361-0.821,2.978-3.19,3.089
                                                    c-5.062,0.237-9.865-0.531-14.329-3.083c-3.938-2.251-6.986-5.428-9.642-9.025c-5.172-7.012-9.133-14.708-12.692-22.625
                                                    c-0.801-1.783-0.215-2.737,1.752-2.774c3.268-0.063,6.536-0.055,9.804-0.003c1.33,0.021,2.21,0.782,2.721,2.037
                                                    c1.766,4.345,3.931,8.479,6.644,12.313c0.723,1.021,1.461,2.039,2.512,2.76c1.16,0.796,2.044,0.533,2.591-0.762
                                                    c0.35-0.823,0.501-1.703,0.577-2.585c0.26-3.021,0.291-6.041-0.159-9.05c-0.28-1.883-1.339-3.099-3.216-3.455
                                                    c-0.956-0.181-0.816-0.535-0.351-1.081c0.807-0.944,1.563-1.528,3.074-1.528l11.313-0.002c1.783,0.35,2.183,1.15,2.425,2.946
                                                    l0.01,12.572c-0.021,0.695,0.349,2.755,1.597,3.21c1,0.33,1.66-0.472,2.258-1.105c2.713-2.879,4.646-6.277,6.377-9.794
                                                    c0.764-1.551,1.423-3.156,2.063-4.764c0.476-1.189,1.216-1.774,2.558-1.754l10.894,0.013c0.321,0,0.647,0.003,0.965,0.058
                                                    c1.836,0.314,2.339,1.104,1.771,2.895c-0.894,2.814-2.631,5.158-4.329,7.508c-1.82,2.516-3.761,4.944-5.563,7.471
                                                    C71.48,50.992,71.611,52.155,73.667,54.161z" />
                                    </g>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <svg fill="#9B9B9B" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30"
                                    viewBox="0 0 97.75 97.75" xml:space="preserve">
                                    <g>
                                        <path
                                            d="M48.875,0C21.882,0,0,21.882,0,48.875S21.882,97.75,48.875,97.75S97.75,75.868,97.75,48.875S75.868,0,48.875,0z
                                                 M67.521,24.89l-6.76,0.003c-5.301,0-6.326,2.519-6.326,6.215v8.15h12.641L67.07,52.023H54.436v32.758H41.251V52.023H30.229V39.258
                                                h11.022v-9.414c0-10.925,6.675-16.875,16.42-16.875l9.851,0.015V24.89L67.521,24.89z" />
                                    </g>
                                </svg>
                            </a>
                        </li>
                        <li class="required_social">
                            <a href="#">
                                <svg fill="#9B9B9B" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="30" height="30"
                                    viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                                    xml:space="preserve">
                                    <g>
                                        <path
                                            d="M256,0C114.62,0,0,114.62,0,256s114.62,256,256,256s256-114.62,256-256S397.38,0,256,0z M259.35,402.4h-0.06 c-25.05,0-49.66-6.29-71.51-18.21L108.44,405l21.24-77.55c-13.1-22.69-19.99-48.44-19.98-74.81 C109.73,170.13,176.86,103,259.35,103c40.03,0.02,77.61,15.6,105.86,43.89c28.25,28.28,43.81,65.88,43.79,105.87 C408.97,335.27,341.83,402.4,259.35,402.4z M259.4,128.27c-68.61,0-124.41,55.8-124.43,124.38c-0.01,23.5,6.56,46.39,19.01,66.19 l2.96,4.71l-12.56,45.9l47.07-12.35l4.54,2.69c19.1,11.34,40.99,17.33,63.31,17.34h0.05c68.56,0,124.36-55.8,124.38-124.38 c0.02-33.24-12.91-64.49-36.39-88C323.85,141.24,292.62,128.29,259.4,128.27z M332.56,306.12c-3.11,8.74-18.05,16.71-25.24,17.78 c-6.44,0.97-14.59,1.37-23.55-1.48c-5.43-1.72-12.39-4.02-21.31-7.87c-37.51-16.2-62.01-53.97-63.88-56.47 c-1.87-2.49-15.27-20.27-15.27-38.68c0-18.4,9.66-27.45,13.09-31.19c3.43-3.74,7.48-4.68,9.97-4.68s4.99,0.02,7.17,0.13 c2.29,0.12,5.37-0.87,8.41,6.42c3.11,7.49,10.59,25.89,11.53,27.77c0.93,1.87,1.56,4.05,0.31,6.55c-1.25,2.49-1.87,4.05-3.74,6.23 c-1.87,2.19-3.93,4.88-5.61,6.56c-1.87,1.86-3.82,3.88-1.64,7.63c2.18,3.74,9.69,15.98,20.8,25.9 c14.29,12.74,26.33,16.69,30.07,18.56c3.74,1.87,5.92,1.56,8.1-0.94c2.19-2.49,9.35-10.92,11.84-14.66 c2.5-3.74,4.99-3.12,8.42-1.87c3.42,1.25,21.81,10.29,25.55,12.17c3.74,1.87,6.23,2.8,7.16,4.36 C335.68,289.9,335.68,297.39,332.56,306.12z" />
                                    </g>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="edit_contact_information_forms">
                <form action="#" method="post" class="form_pers-data edit_contact__forms">
                    <div class="title_edit_contact__forms">
                        <span>E-mail и имя пользователя:</span>
                        <p>
                            <input type="submit" class="submit_edit_contacts" value="Сохранить">
                            <span class="close_edit_contacts">Отменить</span>
                        </p>
                    </div>
                    <div class="form_pers-data__inputs">
                        <p class="form_w50">
                            <label for="e-mail" style="top: 7px; font-size: 14px;">E-mail*</label>
                            <input type="text" id="e-mail" value="<?= $user->email?>" name="User[email]">
                        </p>
                        <p class="form_w50">
                            <label for="main_name">Отображаемое имя*</label>
                            <input type="text" id="main_name">
                        </p>
                    </div>
                </form>
                <form action="#" method="post" class="form_pers-data edit_contact__forms">
                    <div class="title_edit_contact__forms">
                        <span>Сменить пароль?</span>
                        <p>
                            <input type="submit" class="submit_edit_contacts" value="Сохранить">
                            <span class="close_edit_contacts">Отменить</span>
                        </p>
                    </div>
                    <div class="form_pers-data__inputs">
                        <p class="form_w100 now_pass">
                            <label for="now_pass">Введите действующий пароль</label>
                            <input type="text" id="now_pass">
                            <span class="error_message">
                                <span>Неверно указан действующий пароль</span>
                            </span>
                        </p>
                        <p class="form_w100 confirm_pass">
                            <label for="new_pass">Введите новый пароль</label>
                            <input type="text" id="new_pass">
                        </p>
                        <p class="form_w100 confirm_pass">
                            <label for="confirm_new_pass">Подтвердите новый пароль</label>
                            <input type="text" id="confirm_new_pass">
                            <span class="error_message">
                                <span>Пароли не совпадают</span>
                            </span>
                        </p>
                    </div>
                </form>
                <form action="#" method="post" class="form_pers-data edit_contact__forms">
                    <div class="title_edit_contact__forms">
                        <span>Контакты:</span>
                        <p>
                            <input type="submit" class="submit_edit_contacts" value="Сохранить">
                            <span class="close_edit_contacts">Отменить</span>
                        </p>
                    </div>
                    <div class="form_pers-data__inputs">
                        <p class="form_w50">
                            <label for="social_inst">Instagram</label>
                            <input type="text" id="social_inst">
                        </p>
                        <p class="form_w50">
                            <label for="social_tg">Telegram</label>
                            <input type="text" id="social_tg">
                        </p>
                        <p class="form_w50">
                            <label for="social_vk">Vkontakte</label>
                            <input type="text" id="social_vk">
                        </p>
                        <p class="form_w50">
                            <label for="social_facebook">Facebook</label>
                            <input type="text" id="social_facebook">
                        </p>
                        <p class="form_w50">
                            <label for="social_wa">Whatsapp</label>
                            <input type="text" id="social_wa">
                        </p>
                    </div>
                </form>
            </div>
            <div class="delivery_addresses">
                <h2>Данные для доставки</h2>
                <div class="notification_not_addresses">
                    <svg xmlns="http://www.w3.org/2000/svg" width="53" height="53" viewBox="0 0 53 53" fill="none">
                        <path
                            d="M17.076 34.2641H17.0785C17.0805 34.2641 17.0825 34.2637 17.0845 34.2637H45.2363C45.9294 34.2637 46.5388 33.8039 46.7292 33.1375L52.9402 11.3993C53.074 10.9306 52.9802 10.4268 52.687 10.0378C52.3935 9.64879 51.9345 9.41992 51.4473 9.41992H13.495L12.3851 4.42489C12.227 3.71443 11.597 3.20898 10.8691 3.20898H1.55273C0.695091 3.20898 0 3.90408 0 4.76172C0 5.61936 0.695091 6.31445 1.55273 6.31445H9.62372C9.82024 7.19959 14.9354 30.2181 15.2297 31.5423C13.5796 32.2597 12.4219 33.905 12.4219 35.8164C12.4219 38.3849 14.5116 40.4746 17.0801 40.4746H45.2363C46.094 40.4746 46.7891 39.7795 46.7891 38.9219C46.7891 38.0642 46.094 37.3691 45.2363 37.3691H17.0801C16.2241 37.3691 15.5273 36.6724 15.5273 35.8164C15.5273 34.9616 16.2216 34.2661 17.076 34.2641ZM49.3887 12.5254L44.0649 31.1582H18.3255L14.1849 12.5254H49.3887Z"
                            fill="#00A6CA" />
                        <path
                            d="M15.5273 45.1328C15.5273 47.7013 17.6171 49.791 20.1855 49.791C22.754 49.791 24.8437 47.7013 24.8437 45.1328C24.8437 42.5643 22.754 40.4746 20.1855 40.4746C17.6171 40.4746 15.5273 42.5643 15.5273 45.1328ZM20.1855 43.5801C21.0416 43.5801 21.7383 44.2768 21.7383 45.1328C21.7383 45.9888 21.0416 46.6855 20.1855 46.6855C19.3295 46.6855 18.6328 45.9888 18.6328 45.1328C18.6328 44.2768 19.3295 43.5801 20.1855 43.5801Z"
                            fill="#00A6CA" />
                        <path
                            d="M37.4727 45.1328C37.4727 47.7013 39.5624 49.791 42.1309 49.791C44.6993 49.791 46.7891 47.7013 46.7891 45.1328C46.7891 42.5643 44.6993 40.4746 42.1309 40.4746C39.5624 40.4746 37.4727 42.5643 37.4727 45.1328ZM42.1309 43.5801C42.9869 43.5801 43.6836 44.2768 43.6836 45.1328C43.6836 45.9888 42.9869 46.6855 42.1309 46.6855C41.2748 46.6855 40.5781 45.9888 40.5781 45.1328C40.5781 44.2768 41.2748 43.5801 42.1309 43.5801Z"
                            fill="#00A6CA" />
                    </svg>
                    <p>У вас пока нет данных для доставки</p>
                    <span class="add_delivery_address">Добавить контакты</span>
                </div>
            </div>
            <form action="#" method="post" class="form_pers-data add_new_address_form">
                <h4>Новый адрес доставки:</h4>
                <div class="form_pers-data__inputs">
                    <p class="form_w100">
                        <label for="country">Страна</label>
                        <select name="country" id="country">
                            <option disabled selected></option>
                            <option value="Россия">Россия</option>
                            <option value="Белоруссия">Белоруссия</option>
                            <option value="Канада">Канада</option>
                        </select>
                        <span class="form_pers-data__inputs-error">Введите страну</span>
                    </p>
                    <p class="form_w50">
                        <label for="index_number">Индекс</label>
                        <input type="text" id="index_number">
                        <span class="form_pers-data__inputs-error">Введите индекс</span>
                    </p>
                    <p class="form_w50">
                        <label for="region">Область</label>
                        <input type="text" id="region">
                        <span class="form_pers-data__inputs-error">Введите область</span>
                    </p>
                    <p class="form_w50">
                        <label for="city">Город</label>
                        <input type="text" id="city">
                        <span class="form_pers-data__inputs-error">Введите город</span>
                    </p>
                    <p class="form_w50">
                        <label for="street">Улица</label>
                        <input type="text" id="street">
                        <span class="form_pers-data__inputs-error">Введите улицу</span>
                    </p>
                    <p class="form_w100">
                        <label for="address">Дом, корпус, строение, квартира</label>
                        <input type="text" id="address">
                        <span class="form_pers-data__inputs-error">Введите данные</span>
                    </p>
                    <p class="form_w33">
                        <label for="surname">Фамилия</label>
                        <input type="text" id="surname">
                        <span class="form_pers-data__inputs-error">Введите фамилию</span>
                    </p>
                    <p class="form_w33">
                        <label for="name">Имя</label>
                        <input type="text" id="name">
                        <span class="form_pers-data__inputs-error">Введите имя</span>
                    </p>
                    <p class="form_w33">
                        <label for="fname">Отчество</label>
                        <input type="text" id="fname">
                        <span class="form_pers-data__inputs-error">Введите отчество</span>
                    </p>
                    <p class="form_w50">
                        <label for="email">E-mail</label>
                        <input type="text" id="email">
                        <span class="form_pers-data__inputs-error">Введите E-mail</span>
                    </p>
                    <p class="form_w50">
                        <label for="phone">Телефон</label>
                        <input type="text" id="phone">
                        <span class="form_pers-data__inputs-error">Введите телефон</span>
                    </p>
                </div>
                <div class="form_pers-data__buttons">
                    <input type="reset" class="reset_pers_data" value="Отменить">
                    <input type="submit" class="submit_pers_data" value="Сохранить">
                </div>
            </form>
        </div>
    </div>
</section>