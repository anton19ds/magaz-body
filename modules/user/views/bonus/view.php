<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="all_shadow"></div>
<div class="popup success_send_work">
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
        <?= Yii::t('app', 'task-sent-review') ?>
    </p>
    <p class="description_popup">
        <?= Yii::t('app', "desc-task") ?>
    </p>
</div>
<section id="bonuses">
    <div class="container">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'bonus'
        ]) ?>
        <div class="infoproducts__main">
            <h1><?= Yii::t('app', 'my-bonuses') ?></h1>

            <?php if (!empty($activeUserTasks)): ?>
                <div class="rewards">
                    <h4><?= Yii::t('app', "completed-tasks") ?></h4>
                    <div class="table_rewards">
                        <div class="table_rewards__line">
                            <p class="table_rewards_line__date"><?= Yii::t('app', 'date') ?></p>
                            <p class="table_rewards_line__work"><?= Yii::t('app', 'task') ?></p>
                            <p class="table_rewards_line__reward"><?= Yii::t('app', 'reward') ?></p>
                            <p class="table_rewards_line__coupon"><?= Yii::t("app", 'discount-coupon') ?></p>
                        </div>
                        <?php foreach ($activeUserTasks as $item): ?>
                            <div class="table_rewards__line">
                                <p class="table_rewards_line__date"><?= date('d/m/Y', $item->date) ?></p>
                                <p class="table_rewards_line__work"><?= $item->tasks->name ?></p>
                                <p class="table_rewards_line__reward"><?= $item->tasks->promocod->size ?> &#8381;</p>
                                <p class="table_rewards_line__coupon"><?= $item->tasks->promocod->promocode ?></p>
                                <p class="mobile-rewards_line__work"><?= $item->tasks->name ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="blue_notification">
                    <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" viewBox="0 0 54 54" fill="none">
                        <path
                            d="M41.0816 11.8133C41.3057 11.571 41.4985 11.3155 41.66 11.0453C42.2351 10.0862 42.6685 8.46953 41.4655 6.22006C39.8587 3.21089 37.9322 1.68652 35.7404 1.68652C33.2157 1.68652 30.5955 3.74815 27.9488 7.81699C27.6101 8.33938 27.2929 8.85851 27.0004 9.36118C26.708 8.85851 26.3907 8.33938 26.0512 7.81699C23.4054 3.74815 20.7842 1.68652 18.2613 1.68652C16.0695 1.68652 14.1421 3.21089 12.5345 6.22006C11.3324 8.46953 11.7658 10.0862 12.3409 11.0453C12.5024 11.3155 12.6952 11.571 12.9193 11.8133H0V27.5629H3.37505V52.3139H21.3751H32.6258H50.6249V27.5629H54V11.8133H41.0816ZM21.3751 50.0627H5.62537V27.5629H21.3751V50.0627ZM21.3751 25.3135H2.25032V14.0627H21.3751V25.3135ZM17.4142 11.8133C15.8132 11.3056 14.7246 10.6464 14.2707 9.88843C14.1207 9.63794 13.6651 8.87823 14.5195 7.27972C15.7052 5.06158 16.9643 3.936 18.2613 3.936C19.9216 3.936 22.0128 5.74218 24.1495 9.01998C24.7542 9.94781 25.2898 10.8806 25.7324 11.7078C25.7151 11.7441 25.6978 11.7787 25.6805 11.8133H21.3752H17.4142ZM30.3746 50.0627H23.6254V14.0627H30.3746V50.0627ZM28.3213 11.8133C28.3032 11.7787 28.285 11.7441 28.2686 11.7078C28.7102 10.8806 29.2458 9.94781 29.8505 9.01998C31.988 5.74218 34.0793 3.936 35.7404 3.936C37.0357 3.936 38.2948 5.06158 39.4814 7.27972C40.335 8.87823 39.8801 9.63962 39.7302 9.88843C39.277 10.6465 38.1877 11.3057 36.5875 11.8133H32.6258H28.3213ZM48.3755 50.0627H32.6258V27.5629H48.3755V50.0627ZM51.7505 25.3135H32.6258V14.0627H51.7505V25.3135Z"
                            fill="#00A6CA" />
                    </svg>
                    <div class="description_blue_notification">
                        <p><?= Yii::t('app', 'label-task-3') ?></p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="diss-alert" role="alert">
                    <?php echo Yii::$app->session->getFlash('success'); ?>
                </div>
                <br>
                <br>
            <?php endif; ?>

            <div class="list_exercise">
                <?php $i = 1; ?>
                <?php if ($lang == 'ru'): ?>
                    <?php foreach ($model as $item): ?>
                        <?php if (isset($item->promocod)): ?>
                            <div class="exercise__item <?= (in_array($item->id, $columnData) ? 'exercise_done' : '') ?> <?= (in_array($item->id, $columnView) ? 'exercise_view' : '') ?>"
                                id="<?= $item->id ?>">
                                <span class="price_exercise">
                                    <?= $item->getSizeCur($lang); ?>
                                    <?= Yii::t('app', 'currency-symbol') ?>
                                </span>
                                <p class="number_exercise">
                                    <span><?= Yii::t('app', 'task') ?> №
                                        <?= $i ?>
                                    </span>
                                </p>
                                <p class="title_exercise">
                                    <?= $item->name ?>
                                </p>
                                <div class="exercise__content-item">
                                    <?= $item->text ?>
                                </div>
                            </div>
                            <?php $i++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach ($model as $item): ?>
                        <?php if (isset($item->parent->promocod)): ?>
                            <div class="exercise__item <?= (in_array($item->parent_id, $columnData) ? 'exercise_done' : '') ?> <?= (in_array($item->parent_id, $columnView) ? 'exercise_view' : '') ?>"
                                id="<?= $item->parent_id ?>">
                                <span class="price_exercise">
                                    <?= $item->parent->getSizeCur($lang); ?>
                                    <?= Yii::t('app', 'currency-symbol') ?>
                                </span>
                                <p class="number_exercise">
                                    <span><?= Yii::t('app', 'task') ?> №
                                        <?= $i ?>
                                    </span>
                                </p>
                                <p class="title_exercise">
                                    <?= $item->name ?>
                                </p>
                                <div class="exercise__content-item">
                                    <?= $item->text ?>
                                </div>
                            </div>
                            <?php $i++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>


            <?php $form = ActiveForm::begin([
                'id' => "answer_bonus_exercise"
            ]) ?>
            <div>
                <select name="type_exercise" id="type_exercise" required>
                    <option value="" disabled selected hidden><?= Yii::t('app', 'label-task-2') ?></option>
                    <?php if($lang == 'ru'):?>
                        <?php foreach ($model as $item): ?>
                        <?php if (!in_array($item->id, $columnData) && !in_array($item->id, $columnView)): ?>
                            <option value="<?= $item->id ?>">
                                <?= $item->name ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                        <?php else:?>
                            <?php foreach ($model as $item): ?>
                        <?php if (!in_array($item->parent_id, $columnData) && !in_array($item->parent_id, $columnView)): ?>
                            <option value="<?= $item->parent_id ?>">
                                <?= $item->name ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                        <?php endif;?>
                    
                </select>
            </div>
            <div class="photo_files"> <!--error_photo_files - класс, чтобы стала красной кнопка выберите файл-->
                <p><?= Yii::t('app', 'photo-data') ?>:</p>
                <label for="answer_files_exercise">
                    <?= Yii::t('app', 'chek-file') ?>
                    <input type="file" name="answer_files_exercise[]" id="answer_files_exercise" multiple>
                </label>
                <div>
                    <ul class="list_download_files"></ul>
                    <p class="error_size_file"><?= Yii::t('app', 'label-rule-1') ?></p>
                    <p class="info-size-file"><?= Yii::t('app', "label-rule") ?></p>
                </div>
                <p class="error_empty_file"><?= Yii::t('app', 'label-task-1') ?></p>
            </div>
            <div>
                <textarea id="comment_exercise" name="comment_exercise" rows="1"
                    placeholder="<?= Yii::t('app', 'comment') ?>"></textarea>
            </div>
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="diss-alert" role="alert">
                    <?php echo Yii::$app->session->getFlash('success'); ?>
                </div>
            <?php endif; ?>
            <p>
                <?= Html::submitButton(Yii::t('app', 'send'), ["id" => "send-this-data"]) ?>
                <!-- <input type="submit" name="submit_exercise" value= > -->
            </p>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
<script>
    var h2 = document.getElementById('pageSetBody').offsetHeight;
    parent.postMessage({
        heUserInfo: h2,
        top: true
    }, '*');
</script>