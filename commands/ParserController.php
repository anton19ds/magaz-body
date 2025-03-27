<?php

namespace app\commands;

use app\models\OrderStatus;
use Yii;
use app\controllers\ParserDataController;
use app\models\OrdersMeta;
use yii\console\Controller;
use yii\console\ExitCode;


class ParserController extends Controller
{
    public function actionInit()
    {
        //ParserDataController.php
        $model = OrderStatus::find()->where(['id' => '111'])->asArray()->all();
        print_r($model);
        //echo $result;
        return ExitCode::OK;
    }
}
