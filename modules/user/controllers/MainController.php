<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Product;
use app\models\User;
use yii\web\ForbiddenHttpException;

class MainController extends Controller
{
    // public function beforeAction($action)
    // {
    //     if (parent::beforeAction($action)) {
    //         if (!\Yii::$app->user->can($action->id)) {
    //             throw new ForbiddenHttpException('Access denied');
    //         }
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}