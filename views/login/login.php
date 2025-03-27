<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(); ?>
<main id="mainLogin">
    <input type="hidden" value="<?= $lang?>" id="lang-data">
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
            <?= Yii::t('app', 'last-pass')?>
        </p>
        <p class="description_popup">
            <?= Yii::t('app', 'desclare-recover-pass')?>
        </p>
        <form action="#" name="receiving_password_form" class="receiving_password_form">
            <p>
                <input type="text" name="receiving_name" placeholder="E-Mail" class="recoverPass">
            </p>
            <p>
                <input type="submit" value="<?= Yii::t('app', 'btn-recover-pass')?>" id="btn-recover-pass">
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
        <?= Yii::t('app', 'title-recover-pass')?>
        </p>
        <p class="description_popup">
            <?= Yii::t('app', 'text-recover-pass')?>
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
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => true,
                        'options' => [
                            'class' => 'auth_reg_form'
                        ],
                    ]); ?>
                    <div>
                        <p>
                            <?= Html::textInput('username', '', ['placeholder' => "E-Mail", 'enableAjaxValidation' => true]) ?>
                        </p>
                        <p>
                            <?= Html::textInput('password', '', ['placeholder' => Yii::t('app', 'pass'), 'enableAjaxValidation' => true]) ?>
                        </p>
                        <p class="error_message">
                            <span>
                                <?= Yii::t('app', 'error-pass') ?>
                            </span>
                        </p>
                    </div>
                    <p>
                        <?php
                        $dataPage = false;
                        if(isset($request['page']) && !empty($request['page'])){
                            if($request['page'] == 'order'){
                                $dataPage = 'order';
                            }else{
                                $dataPage = $request['page'];
                            }
                        }?>
                        <?= Html::submitButton(Yii::t('app', 'in-log'), ["id" => "login-btn" , "data-login" => $dataPage]) ?>
                    </p>
                    <?php ActiveForm::end(); ?>

                    <p class="where_password">
                        <a href="#">
                            <?= Yii::t('app', 'last-pass') ?>
                        </a>
                    </p>
                </div>
                <div class="door_socials" style="display:none">
                    <p>
                        <?= Yii::t('app', 'in-set') ?>
                    </p>
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
                    <h2>
                        <?php echo \Yii::t('app', 'regs'); ?>
                    </h2>
                    <?php $form = ActiveForm::begin([
                        'id' => 'refister-form',
                        'options' => [
                            'class' => 'auth_reg_form'
                        ],
                    ]); ?>

                    <div>
                        <p>
                            <?= Html::textInput('Register[register]', '', ['placeholder' => "E-Mail"]) ?>
                        </p>
                        <div>
                            <p>
                                <?= Yii::t('app', 'tab1') ?>
                            </p>
                            <p>
                                <?= Yii::t('app', 'tab2') ?>
                            </p>
                        </div>
                        <p class="error_message reg-err" style="display:none">
                            <span>
                                <?= Yii::t('app', 'register-error') ?>
                            </span>
                        </p>
                        <p class="error_message inval-err" style="display:none">
                            <span>
                                <?= Yii::t('app', 'invalid-email-error') ?>
                            </span>
                        </p>
                    </div>
                    <p>
                        <?= Html::submitButton(Yii::t('app', 'btn-reg'), ["id" => "register-btn", "data-login" => (isset($request['page']) && !empty($request['page']) && $request['page'] == 'order' ? 'order' : null)]) ?>
                    </p>
                    <?php ActiveForm::end(); ?>


                </div>
            </div>
            <div class="door_socials" style="display:none">
                <p>
                    <?= Yii::t('app', 'in-set') ?>
                </p>
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
<?php Pjax::end(); ?>


<style>
    #login-btn {
        width: 280px;
        max-width: 90%;
        min-width: 230px;
        height: 55px;
        font-weight: 500;
        border-radius: 3px;
        font-size: 20px;
        transition: 0.3s ease;
        background: #00A6CA;
        border: 2px solid #00A6CA;
        color: #fff;
    }

    #login-btn:hover {
        color: #00A6CA;
        background: transparent;
    }

    #register-btn {
        width: 280px;
        max-width: 90%;
        min-width: 230px;
        height: 55px;
        font-weight: 500;
        border-radius: 3px;
        font-size: 20px;
        transition: 0.3s ease;
        background: transparent;
        border: 2px solid #00A6CA;
        color: #00A6CA;
    }

    #register-btn:hover {
        color: #fff;
        background: #00A6CA;
    }

    .container__registration form>div.name_error input {
        border: 1px solid #D43C46 !important;
        box-shadow: 0 0 0 1px #D43C46 !important;
    }

    .recoverPass {
        font-size: 16px;
        display: block;
        width: 100%;
        font-weight: 350;
        padding: 18px 18px 16px 18px;
        border: 1px solid #C1C1C1;
        border-radius: 3px;
        cursor: pointer;
        transition: 0.2s ease;


    }

    .recoverPass:focus,
    .recoverPass:hover {
        border: 1px solid #00A6CA;
        box-shadow: 0 0 0 1px #00A6CA;
    }
    .door_socials,
    #criterion{
        display: none;
    }
</style>



<script>
        var h2 = document.getElementById('mainLogin').offsetHeight;
        parent.postMessage({
            heLogin : h2,
            top: true,
            path: document.location.pathname,
        }, '*');
</script>