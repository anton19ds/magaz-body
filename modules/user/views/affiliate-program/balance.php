<?php
use app\models\UserBalance;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>

<div class="popup output_balance_popup">
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
        <?= Yii::t('app', "get-pay") ?>
    </p>
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'output_balance_form'
        ]
    ]) ?>
    <div class="output_balance_form__inp">
        <label for="summ_output"><?= Yii::t('app', "desc-bl-1") ?>:</label>
        <input type="text" id="summ_output"
            placeholder="<?= Yii::t('app', "desc-bl-2") ?> <?= $balanceUser ?><?= Yii::t('app', 'currency-symbol') ?>"
            data-summ="<?= $minSumm ?>" data-user="<?= $balanceUser ?>" name="summ">
        <span class="output_balance__error error-user-message min">
            <?= Yii::t('app', 'min-summ')?>
        </span>
        <span class="output_balance__error error-user-message max"><?= Yii::t('app', 'invalid-summ')?></span>
    </div>
    <div class="output_balance_form__inp">
        <label for="data_output"><?= Yii::t('app', "desc-bl-4") ?>:</label>
        <textarea name="data" id="data_output" placeholder="<?= Yii::t('app', "desc-bl-5") ?>" rows="4"></textarea>
    </div>
    <div class="output_balance_form__inp">
        <label for="link_output"><?= Yii::t('app', "desc-bl-6") ?>:</label>
        <textarea name="link" id="link_output" placeholder="<?= Yii::t('app', "desc-bl-7") ?>" rows="1"></textarea>
    </div>
    <div class="links_exit">
        <input type="submit" value="<?= Yii::t('app', 'order-sdf') ?>" id="form-send-bal">
        <a class="close_popup" href="#"><?= Yii::t('app', 'close') ?></a>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="popup success_benefit">
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
        <?= Yii::t('app', "desc-bl-8") ?>
    </p>
    <p class="description_popup">
        <?= Yii::t('app', "desc-bl-9") ?>
    </p>
</div>
<section id="count_balance">
    <div class="container">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'balance'
        ]) ?>
        <div class="infoproducts__main">
            <h1><?= Yii::t('app', 'balance') ?>: <?= ($balanceUser ? number_format($balanceUser, 0, ' ', ' ') : '0') ?>
                <?= Yii::t('app', 'currency-symbol') ?></h1>
            <p class="description_text">
                <?= Yii::t('app', 'deck-bal-1') ?>
            </p>
            <form action="/<?= $lang?>/user/balance" class="filter_balance" method="GET" id='form-filter'>
                <div class="filter_select">
                    <select name="filter_reports__link" id="promocodeNameFilter">
                        <option value="0" <?= (isset($request['filter_reports__link']) && $request['filter_reports__link'] == 0 ? 'selected' : '')?>><?= Yii::t('app', 'set-promo') ?></option>
                        <?php foreach($namePromocode as $key => $name):?>
                        <option value="<?= $name?>" <?= (isset($request['filter_reports__link']) && $request['filter_reports__link'] == $name ? 'selected' : '')?>><?= $name?></option>
                        <?php endforeach;?>
                    </select>

                    
                </div>
                <div class="filter_date">
                    <div class="calendar_container" data-val="start">
                        <div class="month">
                            <span class="prev_month">
                                <img src="/frontStyle/assets/images/arrow-left.svg" alt="<?= Yii::t('app', 'before') ?>">
                            </span>
                            <span class="now_month"></span>
                            <span class="next_month">
                                <img src="/frontStyle/assets/images/arrow-right.svg" alt="<?= Yii::t('app', 'after') ?>">
                            </span>
                        </div>
                        <div class="input_calendar">
                            <div class="line_calendar monday">
                                <p><?= Yii::t('app', 'monday') ?></p>

                            </div>
                            <div class="line_calendar tuesday">
                                <p><?= Yii::t('app', "tuesday") ?></p>

                            </div>
                            <div class="line_calendar wednesday">
                                <p><?= Yii::t('app', 'wednesday') ?></p>

                            </div>
                            <div class="line_calendar thursday">
                                <p><?= Yii::t('app', 'thursday') ?></p>

                            </div>
                            <div class="line_calendar friday">
                                <p><?= Yii::t('app', 'friday') ?></p>

                            </div>
                            <div class="line_calendar saturday">
                                <p><?= Yii::t('app', 'saturday') ?></p>

                            </div>
                            <div class="line_calendar sunday">
                                <p><?= Yii::t('app', 'sunday') ?></p>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="start_filter" value="<?= (isset($request['start_filter']) && !empty($request['start_filter']) ? $request['start_filter'] : Yii::t('app', "with"))?>" id="start_filter" data-val="start">
                </div>
                <div class="filter_date">
                    <div class="calendar_container" data-val="finish">
                        <div class="month">
                            <span class="prev_month">
                                <img src="/frontStyle/assets/images/arrow-left.svg" alt="<?= Yii::t('app', 'before') ?>">
                            </span>
                            <span class="now_month"></span>
                            <span class="next_month">
                                <img src="/frontStyle/assets/images/arrow-right.svg"
                                    alt="<?= Yii::t('app', 'before') ?>">
                            </span>
                        </div>
                        <div class="input_calendar">
                            <div class="line_calendar monday">
                                <p><?= Yii::t('app', 'monday') ?></p>
                            </div>
                            <div class="line_calendar tuesday">
                                <p><?= Yii::t('app', "tuesday") ?></p>

                            </div>
                            <div class="line_calendar wednesday">
                                <p><?= Yii::t('app', 'wednesday') ?></p>

                            </div>
                            <div class="line_calendar thursday">
                                <p><?= Yii::t('app', 'thursday') ?></p>

                            </div>
                            <div class="line_calendar friday">
                                <p><?= Yii::t('app', 'friday') ?></p>

                            </div>
                            <div class="line_calendar saturday">
                                <p><?= Yii::t('app', 'saturday') ?></p>

                            </div>
                            <div class="line_calendar sunday">
                                <p><?= Yii::t('app', 'sunday') ?></p>
                            </div>
                        </div>
                    </div>
                    <input type="text" name="finish_filter" value="<?= (isset($request['finish_filter']) && !empty($request['finish_filter']) ? $request['finish_filter'] : Yii::t('app', 'do'))?>" id="finish_filter" data-val="finish">
                </div>
                <div class="filter_balance_button">
                    <input type="submit" value="<?= Yii::t('app', "get-pay") ?>">
                </div>
            </form>
            <?php if (!empty($user->userBalance)): ?>

                <?php Pjax::begin([
                    'id' => 'balanceTable'
                ]); ?>
                <div class="table_balance">
                    <div class="table_balance__head">
                        <div class="table_balance__line">
                            <div class="balance__date">
                                <p><?= Yii::t('app', 'date') ?></p>
                            </div>
                            <div class="balance__prom">
                                <p><?= Yii::t('app', 'promocod') ?></p>
                            </div>
                            <div class="balance__order">
                                <p><?= Yii::t('app', "order-amount") ?></p>
                            </div>
                            <div class="balance__award">
                                <p><?= Yii::t('app', 'reward') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="table_balance__body">
                        <?php foreach ($dataArray as $item): ?>
                            <?php try{?>
                            <?php if ($item['type'] == UserBalance::STATUS_REFILL): ?>
                                <div class="table_balance__line">
                                    <div class="balance__date">
                                        <p><?= date('d/m/Y', $item['date']) ?></p>
                                    </div>
                                    <div class="balance__prom">
                                        <p><?= $item['name_promo'] ?></p>
                                    </div>
                                    <div class="balance__order">
                                        <p>
                                            <?= Yii::t('app', 'order') ?> №<?= $item['order_id'] ?> <?= Yii::t('app', 'for-the-amount')?> <?= (isset($item['summ_order']) && !empty($item['summ_order']) ? number_format($item['summ_order'], 0, '', ' ') : '') ?>
                                            <?= $item['icon']; ?>
                                        </p>
                                    </div>
                                    <div class="balance__award">
                                        <p><?= number_format($item['summ_prom'], 0, '', ' ') ?> <?= $item['icon']; ?></p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="table_balance__line table_balance_output">
                                    <div class="balance__date">
                                        <p><?= date('d/m/Y', $item['date']) ?></p>
                                    </div>
                                    <div class="balance__prom">
                                        <p></p>
                                    </div>
                                    <div class="balance__order">
                                        <p><?= Yii::t('app', "withdrawal-of-funds"); ?></p>
                                    </div>
                                    <div class="balance__award">
                                        <p> -<?= number_format($item['summ_prom'], 0,'', ' ') ?> <?= $item['icon']; ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php }catch(Exception $e){?>

                            <?php }?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php Pjax::end(); ?>
            <?php endif; ?>
            <?php if (!empty($user->userBalance)): ?>
                <div class="pagination_list">
                    <!-- <ul class="pagination_list__links">
                    <li>
                        <a href="#" class="pagination_list__prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="15" viewBox="0 0 10 15"
                                fill="none">
                                <rect x="8.12793" width="2" height="11" rx="1" transform="rotate(47.237 8.12793 0)"
                                    fill="#C1C1C1" />
                                <rect x="9.48535" y="13.3984" width="2" height="11" rx="1"
                                    transform="rotate(132.26 9.48535 13.3984)" fill="#C1C1C1" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="active_pagination">1</a>
                    </li>
                    <li>
                        <a href="#">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#" class="pagination_list__next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="15" viewBox="0 0 10 15"
                                fill="none">
                                <rect x="1.3584" y="15" width="2" height="11" rx="1"
                                    transform="rotate(-132.763 1.3584 15)" fill="#00A6CA" />
                                <rect x="0.000976562" y="1.60156" width="2" height="11" rx="1"
                                    transform="rotate(-47.74 0.000976562 1.60156)" fill="#00A6CA" />
                            </svg>
                        </a>
                    </li>
                </ul> -->
                    <!-- <p><?= Yii::t('app', "show") ?> 100 <?= Yii::t('app', "of") ?> 325</p> -->
                </div>
            <?php endif; ?>
            <div class="use_tg_link">
                <a href="<?= Yii::t('app', 'support-tg-link')?>" target="_blank">
                    <span><?= Yii::t('app', 'support-tg') ?></span>
                    <img src="/asset/images/tg_quadro.svg" alt="">
                </a>
            </div>
        </div>
    </div>
</section>
<script>
    var h2 = document.getElementById('pageSetBody').offsetHeight;
    parent.postMessage({
        heUserInfo: h2,
        top: true,
        path: document.location.pathname,
    }, '*');
</script>