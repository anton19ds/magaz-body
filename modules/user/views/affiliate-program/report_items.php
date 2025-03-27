<?php
use app\models\PromoUser;
?>
<?php if (isset($model['order_summ'])): 
?>

    <div class="table_report__line table_report_buy">
        <div class="report__country">
            <div>
            <p>
                <?php $county = (isset($item['count']) ? $item['count'] : $item['country']);
                    if($county == 'ru' || $county == 'RU'){
                        echo 'Russia';
                    }
                ?>
            </p>
                <div class="report_mobile_icons">
                    <img src="/frontStyle/assets/images/icon-desctop.svg" alt="">
                    <img src="/frontStyle/assets/images/icon-safari.svg" alt="">
                </div>
            </div>
            <span class="number_report">#<?= $i ?></span>
        </div>
        <div class="report__ip">
            <p><?= $item['ip'] ?></p>
        </div>
        <div class="report__link">
            <p>
            https://<?= $_SERVER['SERVER_NAME']?>/<?= PromoUser::getProdLink($item['promocode'])?>
            </p>
        </div>
        <div class="report__data">
            <img src="/frontStyle/assets/images/icon-desctop.svg" alt="">
            <p><?php if (isset($item['user_agent'])): ?>
                    <?php try {
                        $arrt = explode(',', $item['user_agent']);
                        foreach ($arrt as $key => $value) {
                            if (strripos($value, 'YaBrowser') !== false) {
                                echo "Yandex";
                            }
                        }
                    } catch (\Exception $th) {
                        //throw $th;
                    } ?>
                <?php elseif (isset($item['user_data'])): ?>
                    <?php
                    $arr = unserialize($item['user_data']);
                    if (isset($arr['HTTP_SEC_CH_UA'])) {
                        if (strripos($arr['HTTP_SEC_CH_UA'], 'YaBrowser') !== false) {
                            echo "Yandex";
                        }
                    }
                    ?>
                <?php endif; ?></p>
        </div>
        <div class="report__date">
            <p><?= date('d/m/Y', $item["data"]) ?></p>
        </div>
        <div class="report__status">
            <div>
                <div class="report_status__info">
                    <span><?= Yii::t('app', "se-t3") ?></span>
                </div>
                <p class="report_summ_mob"><?= $item['order_summ'] ?></p>
                <p class="report_promocode"><span>Промокод:</span><?= PromoUser::getPromoName($item['promocode'])?></p>
                <p class="report_summ">Сумма заказа: <?= $item['order_summ'] ?></p>
            </div>
        </div>
    </div>
<?php elseif (isset($item['user_data'])): ?>
    <div class="table_report__line table_report_visit">
        <div class="report__country">
            <div>
                <p>
                    <?php $county = (isset($item['count']) ? $item['count'] : $item['country']);
                        if($county == 'ru' || $county == 'RU'){
                            echo 'Russia';
                        }
                    ?>
                </p>
                <div class="report_mobile_icons">
                    <img src="/frontStyle/assets/images/icon-ipad.svg" alt="">
                    <img src="/frontStyle/assets/images/icon-chrome.svg" alt="">
                </div>
            </div>
            <span class="number_report">#<?= $i ?></span>
        </div>
        <div class="report__ip">
            <p><?= $item['ip'] ?></p>
        </div>
        <div class="report__link">
        <p>
            https://<?= $_SERVER['SERVER_NAME']?>/<?= PromoUser::getProdLink($item['promocode_id'])?>
        </p>
        </div>
        <div class="report__data">
            <img src="/frontStyle/assets/images/icon-ipad.svg" alt="">
            <p>
                <?php if (isset($item['user_agent'])): ?>
                    <?php try {
                        $arrt = explode(',', $item['user_agent']);
                        foreach ($arrt as $key => $value) {
                            if (strripos($value, 'YaBrowser') !== false) {
                                echo "Yandex";
                            }
                        }
                    } catch (\Exception $th) {
                        //throw $th;
                    } ?>
                <?php elseif (isset($item['user_data'])): ?>
                    <?php
                    $arr = unserialize($item['user_data']);
                    if (isset($arr['HTTP_SEC_CH_UA'])) {
                        if (strripos($arr['HTTP_SEC_CH_UA'], 'YaBrowser') !== false) {
                            echo "Yandex";
                        }
                    }
                    ?>
                <?php endif; ?>
            </p>
        </div>
        <div class="report__date">
            <p><?= date('d/m/Y', $item["data"]) ?></p>
        </div>
        <div class="report__status">
            <div class="report_status__info">
                <span><?= Yii::t('app', "se-t1") ?></span>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- <div class="table_report__line table_report_buy">
    <div class="report__country">
        <div>
            <p>Russia</p>
            <div class="report_mobile_icons">
                <img src="/frontStyle/assets/images/icon-desctop.svg" alt="">
                <img src="/frontStyle/assets/images/icon-safari.svg" alt="">
            </div>
        </div>
        <span class="number_report">#112</span>
    </div>
    <div class="report__ip">
        <p>138.25.62.238</p>
    </div>
    <div class="report__link">
        <p>https://body-balance.com/ru/ingibitor-sinteza-hitina-evolyuciya-v-lechenii</p>
    </div>
    <div class="report__data">
        <img src="/frontStyle/assets/images/icon-desctop.svg" alt="">
        <p>Chrome</p>
    </div>
    <div class="report__date">
        <p>21/04/2020</p>
    </div>
    <div class="report__status">
        <div>
            <div class="report_status__info">
                <span><?= Yii::t('app', "se-t3") ?></span>
            </div>
            <p class="report_summ_mob">6.000 ₽</p>
            <p class="report_promocode"><span>Промокод:</span> discount</p>
            <p class="report_summ">Сумма заказа: 6.000 ₽</p>
        </div>
    </div>
</div>
<div class="table_report__line table_report_feedback">
    <div class="report__country">
        <div>
            <p>United Kingdom</p>
            <div class="report_mobile_icons">
                <img src="/frontStyle/assets/images/icon_phone.svg" alt="">
                <img src="/frontStyle/assets/images/icon-yandex.svg" alt="">
            </div>
        </div>
        <span class="number_report">#112</span>
    </div>
    <div class="report__ip">
        <p>138.25.62.238</p>
    </div>
    <div class="report__link">
        <p>https://body-balance.com/ru/ingibitor-sinteza-hitina-evolyuciya-v-lechenii</p>
    </div>
    <div class="report__data">
        <img src="/frontStyle/assets/images/icon_phone.svg" alt="">
        <p>Mozilla</p>
    </div>
    <div class="report__date">
        <p>21/04/2020</p>
    </div>
    <div class="report__status">
        <div>
            <div class="report_status__info">
                <span><?= Yii::t('app', "se-t2") ?></span>
            </div>
            <p class="report_summ_mob">6.000 ₽</p>
            <p class="report_promocode"><span><?= Yii::t('app', 'promocod') ?>:</span> discount</p>
            <p class="report_summ"><?= Yii::t('app', "per-desc-1") ?>: 6.000 ₽</p>
        </div>
    </div>
</div> -->