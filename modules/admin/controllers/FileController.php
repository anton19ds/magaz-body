<?php

namespace app\modules\admin\controllers;

use yii;
use yii\web\Controller;


/**
 * Default controller for the `admin` module
 */
class FileController extends ParentController
{
  public function actionIndex()
  {
    $this->title = 'Файловый менеджер';
    $path = Yii::getAlias('@webroot').'/'.'file';
    $dirGall = scandir($path);
    $cat = array();
    foreach($dirGall as $key => $item){
        if($item !='.' && $item !='..' && !is_dir($path.$item)){
            $cat[] = $item;
        }
    }
    return $this->render('index', [
      'path' => $path,
      'dirGall' => $dirGall
    ]);
  }
}
