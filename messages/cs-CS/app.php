<?php

/**
* Translation map for ru-RU
*/

$jsonData = Yii::getalias(Yii::$app->basePath."/messages/cs-CS/list.txt");
$arrCsJson = file_get_contents($jsonData);
$arrCs = json_decode($arrCsJson, true);
return $arrCs;
