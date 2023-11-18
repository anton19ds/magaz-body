<?php

namespace app\controllers;

use app\models\Currencies;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;


class MainController extends Controller
{
    public function beforeAction($action)
    {
        
        if($action->id != 'test'){
            $requestGet = Yii::$app->request->get();
        if (isset($requestGet['lang']) && !empty($requestGet['lang']) && $requestGet['lang'] != 'ru') {
            if (!Currencies::find()->where(['tag' => $requestGet['lang']])->exists()) {
                $this->owner->redirect(['/ru']);
                return false;
            }
        } elseif (!isset($requestGet['lang']) || empty($requestGet['lang'])) {
            $this->owner->redirect(['/ru']);
            return false;
        }
        }
        return parent::beforeAction($action);
    }
}