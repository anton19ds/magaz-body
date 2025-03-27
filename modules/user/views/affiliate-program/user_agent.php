<?php if (isset($model['user_agent'])): ?>
    <?php try {
        $arrt = explode(';', $model['user_agent']);
        echo $arrt[0];
    } catch (\Exception $th) {
        //throw $th;
    } ?>
<?php elseif (isset($model['user_data'])): ?>
    <?php
    try{
    $arr = unserialize($model['user_data']);
    if (isset($arr['HTTP_SEC_CH_UA'])) {
        if (strripos($arr['HTTP_SEC_CH_UA'], 'YaBrowser') !== false) {
            echo '"Yandex"';
        } elseif (strripos($arr['HTTP_SEC_CH_UA'], 'Microsoft') !== false) {
            echo '"Microsoft Edge"';
        }elseif (strripos($arr['HTTP_SEC_CH_UA'], 'Chrome') !== false){
            echo 'Google Chrome';
        }else{
            echo 'Safari';
        }
    }
}catch(Exception $e){echo 'Google Chrome';  }
?>
<?php endif; ?>