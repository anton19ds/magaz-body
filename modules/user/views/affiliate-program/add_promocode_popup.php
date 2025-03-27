<div class="popup add_promocode_popup" style="display: none;">
    <div class="close_popup close_popup_svg">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <g clip-path="url(#clip0_1158_108032)">
                <path
                    d="M11.1049 10L19.7712 1.33372C20.0763 1.0286 20.0763 0.533915 19.7712 0.228837C19.4661 -0.0762401 18.9714 -0.0762791 18.6663 0.228837L9.99999 8.89515L1.33372 0.228837C1.0286 -0.0762791 0.533915 -0.0762791 0.228837 0.228837C-0.0762401 0.533954 -0.0762792 1.02864 0.228837 1.33372L8.89511 9.99999L0.228837 18.6663C-0.0762792 18.9714 -0.0762792 19.4661 0.228837 19.7712C0.381376 19.9237 0.581337 20 0.781297 20C0.981258 20 1.18118 19.9237 1.33376 19.7712L9.99999 11.1049L18.6663 19.7712C18.8188 19.9237 19.0188 20 19.2187 20C19.4187 20 19.6186 19.9237 19.7712 19.7712C20.0763 19.4661 20.0763 18.9714 19.7712 18.6663L11.1049 10Z"
                    fill="black"></path>
            </g>
            <defs>
                <clipPath id="clip0_1158_108032">
                    <rect width="20" height="20" fill="white"></rect>
                </clipPath>
            </defs>
        </svg>
    </div>
    <p class="title_popup">
        <?= Yii::t('app', "create-promo") ?>
    </p>
    <p class="description_popup">
        <?= Yii::t('app', "desc-promo-1") ?>
    </p>
    <form action="#" id="form_add_promocode">
        <div class="form_add_promocode__input nick_new_promocode">
            <div class="nick_new_promocode__before">
                <p class="promocode_question">
                    <img src="assets/images/question.svg" alt="">
                    <span><?= Yii::t('app', "desc-promo-2") ?></span>
                </p>
                <label for="name_new_promocode"><?= Yii::t('app', 'promocode-name') ?>:</label>
            </div>
            <div class="nick_new_promocode__inp">
                <input type="text" id="name_new_promocode" name="name_new_promocode">
                <span class="nick_promocode_notification nick_occupied"><?= Yii::t('app', "st-promo-1") ?></span>
                <span class="nick_promocode_notification nick_open"><?= Yii::t('app', "st-promo-2") ?></span>
                <span class="nick_promocode_notification nick_disable"><?= Yii::t('app', "st-promo-3") ?></span>
            </div>
            <div class="nick_new_promocode__result">
                <p class="promocode_question">
                    <img src="assets/images/question.svg" alt="">
                    <span><?= Yii::t('app', "desc-promo-3") ?></span>
                </p>
                <p>
                    anticandida.com/<span class="result_nick_promocode"></span>
                </p>
            </div>
        </div>
        <div class="form_add_promocode__input target_link_promocode">
            <div class="target_link_promocode__before">
                <p class="promocode_question">
                    <img src="assets/images/question.svg" alt="">
                    <span><?= Yii::t('app', "desc-promo-4") ?></span>
                </p>
                <label for="link_new_promocode"><?= Yii::t('app', "sell-link") ?>:</label>
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
                        <span><?= Yii::t('app', "desc-promo-5") ?></span>
                    </span>
                    <span class="promocode_line__title"><?= Yii::t('app', "desc-promo-6") ?></span>
                </div>
                <div class="promocode_percents__sale-clients">
                    <span class="promocode_question">
                        <img src="assets/images/question.svg" alt="">
                        <span><?= Yii::t('app', "promo-desc-7") ?></span>
                    </span>
                    <span class="promocode_line__title"><?= Yii::t("app", '"promo-desc-8"') ?></span>
                </div>
                <div class="promocode_percents__you-prize">
                    <span class="promocode_question">
                        <img src="assets/images/question.svg" alt="">
                        <span><?= Yii::t('app', "promo-desc-9") ?></span>
                    </span>
                    <span class="promocode_line__title"><?= Yii::t('app', "promo-desc-10") ?></span>
                </div>
            </div>


            <!-- set-d -->

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
                            <span>Задайте процент скидки которую получит пользователь, перейдя по вашей партнёрской
                                ссылке.
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

                <span class="percent_error percent_error_big">Вы не можете ввести суммарный процент больше чем есть у
                    вас</span>
                <span class="percent_error percent_error_small">Вы не можете ввести суммарный процент меньше чем есть у
                    вас</span>
            </div>
            <!-- set-d -->



            <!-- <div class="promocode_percents__line">
                <div class="promocode_percents__group">
                    <div class="promocode_percents_line__mob">
                        <span class="promocode_question">
                            <img src="assets/images/question.svg" alt="">
                            <span><?= Yii::t('app', "promo-desc-11") ?></span>
                        </span>
                        <?= Yii::t('app', "promo-desc-12") ?>
                    </div>
                    <span><?= Yii::t('app', "promo-desc-13") ?>:</span>
                </div>
                <div class="promocode_percents__sale-clients">
                    <div class="promocode_percents_line__mob">
                        <span class="promocode_question">
                            <img src="assets/images/question.svg" alt="">
                            <span><?= Yii::t('app', "promo-desc-7") ?></span>
                        </span>
                        <?= Yii::t('app', "promo-desc-8") ?>
                    </div>
                    <p><input type="number" data-summ="30" group_percent="1" value="0"></p>
                </div>
                <div class="promocode_percents__you-prize">
                    <div class="promocode_percents_line__mob">
                        <span class="promocode_question">
                            <img src="assets/images/question.svg" alt="">
                            <span><?= Yii::t('app', "promo-desc-7") ?></span>
                        </span>
                        <?= Yii::t('app', "promo-desc-10") ?>
                    </div>
                    <p><input type="number" data-summ="30" group_percent="1" value="0"></p>
                </div>
                <span class="percent_error percent_error_big"><?= Yii::t('app', "promo-desc-14") ?></span>
                <span class="percent_error percent_error_small"><?= Yii::t('app', "promo-desc-15") ?></span>
            </div> -->

            <!-- <div class="promocode_percents__line">
                <div class="promocode_percents__group">
                    <div class="promocode_percents_line__mob">
                        <span class="promocode_question">
                            <img src="assets/images/question.svg" alt="">
                            <span><?= Yii::t('app', "promo-desc-11") ?></span>
                        </span>
                        <?= Yii::t('app', "promo-desc-16") ?>
                    </div>
                    <span><?= Yii::t('app', "promo-desc-17") ?>:</span>
                </div>
                <div class="promocode_percents__sale-clients">
                    <div class="promocode_percents_line__mob">
                        <span class="promocode_question">
                            <img src="assets/images/question.svg" alt="">
                            <span><?= Yii::t('app', "promo-desc-7") ?></span>
                        </span>
                        <?= Yii::t('app', "promo-desc-8") ?>
                    </div>
                    <p><input type="number" data-summ="35" group_percent="2" value="0"></p>
                </div>
                <div class="promocode_percents__you-prize">
                    <div class="promocode_percents_line__mob">
                        <span class="promocode_question">
                            <img src="assets/images/question.svg" alt="">
                            <span><?= Yii::t('app', "promo-desc-9") ?></span>
                        </span>
                        <?= Yii::t('app', "promo-desc-10") ?>
                    </div>
                    <p><input type="number" data-summ="35" group_percent="2" value="0"></p>
                </div>
                <span class="percent_error percent_error_big"><?= Yii::t('app', "promo-desc-14") ?></span>
                <span class="percent_error percent_error_small"><?= Yii::t('app', "promo-desc-15") ?></span>
            </div> -->

            <!-- <div class="promocode_percents__line">
                <div class="promocode_percents__group">
                    <div class="promocode_percents_line__mob">
                        <span class="promocode_question">
                            <img src="assets/images/question.svg" alt="">
                            <span><?= Yii::t('app', "promo-desc-11") ?></span>
                        </span>
                        Товарная группа: Мед. услуги (20%)
                    </div>
                    <span>Мед. услуги (20%):</span>
                </div>
                <div class="promocode_percents__sale-clients">
                    <div class="promocode_percents_line__mob">
                        <span class="promocode_question">
                            <img src="assets/images/question.svg" alt="">
                            <span><?= Yii::t('app', "promo-desc-7") ?></span>
                        </span>
                        <?= Yii::t('app', "promo-desc-8") ?>
                    </div>
                    <p><input type="number" data-summ="20" group_percent="3" value="0"></p>
                </div>
                <div class="promocode_percents__you-prize">
                    <div class="promocode_percents_line__mob">
                        <span class="promocode_question">
                            <img src="assets/images/question.svg" alt="">
                            <span><?= Yii::t('app', "promo-desc-9") ?></span>
                        </span>
                        <?= Yii::t('app', "promo-desc-10") ?>
                    </div>
                    <p><input type="number" data-summ="20" group_percent="3" value="0"></p>
                </div>
                <span class="percent_error percent_error_big"><?= Yii::t('app', "promo-desc-14") ?></span>
                <span class="percent_error percent_error_small"><?= Yii::t('app', "promo-desc-15") ?></span>
            </div> -->

        </div>
        <p class="submit_add_promocode">
            <input type="submit" name="add_promocode" value="<?= Yii::t('app', 'save') ?>">
        </p>
    </form>
</div>