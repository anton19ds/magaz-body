<?php

/**
* Translation map for ru-RU
*/
$jsonData = Yii::getalias(Yii::$app->basePath."/messages/ru-RU/list.txt");
$arrRuJson = file_get_contents($jsonData);
$arrRu = json_decode($arrRuJson, true);
return $arrRu;