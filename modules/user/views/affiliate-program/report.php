<?php
use yii\widgets\LinkPager;
use yii\widgets\ListView;
?>
<section id="partner_programm">
    <div class="container">
        <?php echo $this->render('../components/left_menu_user.php', [
            'lang' => $lang,
            'active' => 'report'
        ]) ?>
        <div class="infoproducts__main">
            <h1><?= Yii::t('app', "report") ?></h1>
            <form action="/<?= $lang?>/user/report" class="filter_reports" method="GET">
                <div class="filter_reports__inp filter_date">
                    <div class="calendar_container">
                        <div class="month">
                            <span class="prev_month">
                                <img src="/frontStyle/assets/images/arrow-left.svg"
                                    alt="<?= Yii::t('app', 'before') ?>">
                            </span>
                            <span class="now_month"></span>
                            <span class="next_month">
                                <img src="/frontStyle/assets/images/arrow-right.svg"
                                    alt="<?= Yii::t('app', 'after') ?>">
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
                    <input type="text" name="start_filter" value="<?= (isset($request['start_filter']) && !empty($request['start_filter']) ? $request['start_filter'] : Yii::t('app', "with")) ?>">
                    
                </div>
                <div class="filter_reports__inp filter_date">
                    <div class="calendar_container">
                        <div class="month">
                            <span class="prev_month">
                                <img src="/frontStyle/assets/images/arrow-left.svg"
                                    alt="<?= Yii::t('app', 'before') ?>">
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
                    <input type="text" name="finish_filter" value="<?= (isset($request['finish_filter']) && !empty($request['finish_filter']) ? $request['finish_filter'] : Yii::t('app', 'do'))?>">
                </div>
                <div class="filter_reports__inp">
                    <select name="filter_reports__country">
                        <option value="0"><?= Yii::t('app', 'country') ?></option>
                        <?php foreach($countData as $el => $it):?>
                            <option <?= (isset($request['filter_reports__country']) && $el ==  $request['filter_reports__country']? 'selected' : '')?> value="<?= $el?>"><?= $el?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <!-- <div class="filter_reports__inp">
                    <select name="filter_reports__link">
                        <option selected disabled><?= Yii::t('app', "link-int") ?></option>
                        <option value="1">https://link.ru</option>
                        <option value="2">https://link2.ru</option>
                    </select>
                </div> -->
                <div class="filter_reports__inp">
                    <select name="filter_reports__status">
                        <option value="our" <?= (isset($request['filter_reports__status']) && $request['filter_reports__status'] == 'our' ? 'selected' : '')?>><?= Yii::t('app', 'statys') ?></option>
                        <option value="pay" <?= (isset($request['filter_reports__status']) && $request['filter_reports__status'] == 'pay' ? 'selected' : '')?>><?= Yii::t('app', "se-t3") ?></option>
                        <option value="new" <?= (isset($request['filter_reports__status']) && $request['filter_reports__status'] == 'close' ? 'selected' : '')?>><?= Yii::t('app', "se-t2") ?></option>
                        <option value="view" <?= (isset($request['filter_reports__status']) && $request['filter_reports__status'] == 'view' ? 'selected' : '')?>><?= Yii::t('app', "se-t1") ?></option>
                    </select>
                </div>
                <div class="filter_reports__inp">
                    <input type="submit" name="filter_reports" value="<?= Yii::t('app', "apply") ?>">
                </div>
            </form>
            <?php $i = 1;?>
            <?php echo ListView::widget([
                'id' => 'viewReport',
                'layout' => '<div class="table_reports"><div class="table_reports__head"><div class="table_report__line"><div class="report__country"><p>' . Yii::t('app', 'country') . '</p></div><div class="report__ip"><p>IP</p></div><div class="report__link"><p>' . Yii::t('app', "per-desc-3") . '</p></div><div class="report__data"><p>' . Yii::t('app', "per-desc-2") . '</p></div><div class="report__date"><p>' . Yii::t('app', 'date') . '</p></div><div class="report__status"><p>' . Yii::t('app', 'statys') . '</p></div></div></div><div class="table_reports__body">{items}</div><div class="pagination_list">{pager}{summary}</div></div>',
                'dataProvider' => $provider,
                'itemView' => function ($model, $key, $index, $widget) use ($request){
                    return $this->render('_post',['model' => $model, 'key' => $key, 'request' => $request]);
                },
                'summary' => '<p>' . Yii::t('app', "show") . ' ' . '{begin} - {end}' . ' ' . Yii::t('app', "of") . ' ' . '{totalCount}</p>',
                'pager' => [
                    'prevPageLabel' => '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="15" viewBox="0 0 10 15" fill="none"><rect x="8.12793" width="2" height="11" rx="1" transform="rotate(47.237 8.12793 0)" fill="#C1C1C1" /><rect x="9.48535" y="13.3984" width="2" height="11" rx="1" transform="rotate(132.26 9.48535 13.3984)" fill="#C1C1C1" /></svg>',
                    'nextPageLabel' => '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="15" viewBox="0 0 10 15" fill="none"><rect x="1.3584" y="15" width="2" height="11" rx="1" transform="rotate(-132.763 1.3584 15)" fill="#00A6CA" /><rect x="0.000976562" y="1.60156" width="2" height="11" rx="1" transform="rotate(-47.74 0.000976562 1.60156)" fill="#00A6CA" /></svg>',
                    'activePageCssClass' => 'active_pagination',
                    'options' => ['class' => 'pagination_list__links']
                ]
            ]); ?>
            <?php $i++;?>
        </div>
    </div>
</section>


<style>
    #viewReport {
        display: contents;
    }
</style>
<script>
    var h2 = document.getElementById('pageSetBody').offsetHeight;
    parent.postMessage({
        heUserInfo: h2,
        top: true
    }, '*');
</script>