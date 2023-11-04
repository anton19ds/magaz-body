<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

/**
 * Default controller for the `admin` module
 */
class MainController extends ParentController
{
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'denyCallback' => function ($rule, $action) {
    //                 // return $action->controller->goHome();
    //             },
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'actions' => ['index'],
    //                     'roles' => ['user'],
    //                 ],
    //             ],
    //         ],
    //     ];
    // }
  
  
  public function actionIndex()
  {
    Yii::$app->params['title'] = 'Главная';
    $this->title = 'Главная';
    $this->preTitle = 'параметры главной страницы';
    return $this->render('index',[
      'title' => $this->title,
      'preTitle' => $this->preTitle
    ]);
  }
}