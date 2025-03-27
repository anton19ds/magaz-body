<?php
use app\models\PromoUser;
$i = ++$key;
?>
<?php if(isset($request['start_filter']) && !empty($request['start_filter'])){
            try{
                $dtime = \DateTime::createFromFormat("d/m/Y", $request['start_filter']);
                if(!empty($dtime)){
                    $start = $dtime->getTimestamp();
                    if($model['data'] <= $start){
                        return;
                    }
                }
            }catch(Exception $e){
            }
}
if(isset($request['finish_filter']) && !empty($request['finish_filter'])){
    try{
        $dtime = \DateTime::createFromFormat("d/m/Y", $request['finish_filter']);
        if(!empty($dtime)){
            $finish = $dtime->getTimestamp();
            if($model['data'] > $finish){
                return;
            }
        }
    }catch(Exception $e){
    }
}
?>
<?php if (isset($model['order_summ'])): ?>
    <?php if ($model['status'] == 'pay' || $model['status'] == 'close'): ?>
        <?php if(isset($request['filter_reports__status']) && $request['filter_reports__status'] != "pay" && $request['filter_reports__status'] !="our"){
        return;
    }?>
        <div class="table_report__line table_report_buy">
            <div class="report__country">
                <div>
                    <p>
                        <?php $county = (isset($model['count']) ? $model['count'] : $model['country']);
                        if ($county == 'ru' || $county == 'RU') {
                            echo 'Russia';
                        }
                        ?>
                    </p>
                    <div class="report_mobile_icons">
                        <img src="/frontStyle/assets/images/icon-desctop.svg" alt="">
                        <img src="/frontStyle/assets/images/icon-safari.svg" alt="">
                    </div>
                </div>
                <span class="number_report">#<?= $model['order_id']?></span>
            </div>
            <div class="report__ip">
                <p><?= mb_strimwidth($model['ip'], 0, 12, "..."); ?></p>
            </div>
            <?= $this->render('url_data', [
                'model' => $model
            ]) ?>
            <div class="report__data">
                <img src="/frontStyle/assets/images/icon-desctop.svg" alt="">

                <p>
                    <?= $this->render('user_agent', [
                        'model' => $model
                    ]) ?>
                </p>
            </div>
            <div class="report__date">
                <p><?= date('d/m/Y', $model["data"]) ?></p>
            </div>
            <div class="report__status">
                <div>
                    <div class="report_status__info">
                        <span><?= Yii::t('app', "se-t3") ?></span>
                    </div>
                    <p class="report_summ_mob"><?= $model['order_summ'] ?></p>
                    <p class="report_promocode"><span>Промокод:</span><?= PromoUser::getPromoName($model['promocode']) ?></p>
                    <p class="report_summ">Сумма заказа: <?= $model['order_summ'] ?></p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php if(isset($request['filter_reports__status']) && $request['filter_reports__status'] != "new" && $request['filter_reports__status'] !="our"){
        return;
    }?>
        <div class="table_report__line table_report_feedback">
            <div class="report__country">
                <div>
                    <p>
                        <?php $county = (isset($model['count']) ? $model['count'] : $model['country']);
                        if ($county == 'ru' || $county == 'RU') {
                            echo 'Russia';
                        }else{
                            echo $county;
                        }
                        ?>
                    </p>
                    <div class="report_mobile_icons">
                        <img src="/frontStyle/assets/images/icon-desctop.svg" alt="">
                        <img src="/frontStyle/assets/images/icon-safari.svg" alt="">
                    </div>
                </div>
                <span class="number_report">#<?= $model['order_id']?></span>
            </div>
            <div class="report__ip">
                <p><?= $model['ip'] ?></p>
            </div>
            <?= $this->render('url_data', [
                'model' => $model
            ]) ?>
            <div class="report__data">
                <img src="/frontStyle/assets/images/icon-desctop.svg" alt="">
                <p><?= $this->render('user_agent', [
                    'model' => $model
                ]) ?>
                </p>
            </div>
            <div class="report__date">
                <p><?= date('d/m/Y', $model["data"]) ?></p>
            </div>
            <div class="report__status">
                <div>
                    <div class="report_status__info">
                        <span><?= Yii::t('app', "se-t2") ?></span>
                    </div>
                    <p class="report_summ_mob"><?= $model['order_summ'] ?></p>
                    <p class="report_promocode"><span>Промокод:</span> <?= PromoUser::getPromoName($model['promocode']) ?></p>
                    <p class="report_summ">Сумма заказа: <?= $model['order_summ'] ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php elseif (isset($model['user_data'])): ?>
    <?php if(isset($request['filter_reports__status']) && $request['filter_reports__status'] != "view" && $request['filter_reports__status'] !="our"){
        return;
    }?>
    <div class="table_report__line table_report_visit">
        <div class="report__country">
            <div>
                <p>
                    <?php $county = (isset($model['count']) ? $model['count'] : $model['country']);
                    if ($county == 'ru' || $county == 'RU') {
                        echo 'Russia';
                    }else{
                        echo $county;
                    }
                    ?>
                </p>
                <div class="report_mobile_icons">
                    <img src="/frontStyle/assets/images/icon-ipad.svg" alt="">
                    <img src="/frontStyle/assets/images/icon-chrome.svg" alt="">
                </div>
            </div>
            <span class="number_report"></span>
        </div>
        <div class="report__ip">
            <p><?= mb_strimwidth($model['ip'], 0, 13, "..."); ?></p>
        </div>
        <?= $this->render('url_data', [
            'model' => $model
        ]) ?>
        <div class="report__data">
            <img src="/frontStyle/assets/images/icon-ipad.svg" alt="">
            <p>
                <?= $this->render('user_agent', [
                    'model' => $model
                ]) ?>
            </p>
        </div>
        <div class="report__date">
            <p><?= date('d/m/Y', $model["data"]) ?></p>
        </div>
        <div class="report__status">
            <div class="report_status__info">
                <span><?= Yii::t('app', "se-t1") ?></span>
            </div>
        </div>
    </div>
<?php endif; ?>