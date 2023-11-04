<?php

namespace app\widgets;

use Yii;

class ImageGallery extends \yii\bootstrap5\Widget
{


  public function run()
  {
    $path = Yii::getAlias('@webroot') . '/file/';
    $res = scandir($path);
    $listDir = array();
    foreach ($res as $key => $item) {
      if ($item != '.' && $item != '..') {
        $listDir[] = array(
          'name' => $item,
        );
      }
    }
    return $this->render('image', [
      'model' => $listDir
    ]);
  }
}