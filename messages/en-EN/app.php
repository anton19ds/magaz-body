<?php

/**
* Translation map for en-EN
*/

$jsonData = Yii::getalias(Yii::$app->basePath."/messages/en-EN/list.txt");
$arrCsJson = file_get_contents($jsonData);
$arrCs = json_decode($arrCsJson, true);
return $arrCs;
