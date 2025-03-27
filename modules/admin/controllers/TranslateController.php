<?php

namespace app\modules\admin\controllers;

use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use Yii;

/**
 * TranslateController implements the CRUD actions for User model.
 */
class TranslateController extends MainController
{
    public $title;
    public $preTitle;
    public $actionType;
    public $lang;

    public function actionIndex(){
        $fileRu = Yii::getalias(Yii::$app->basePath."/messages/ru-RU/list.txt");
        $arrRuJson = file_get_contents($fileRu);
        $arrRu = json_decode($arrRuJson, true);

        $fileCs = Yii::getalias(Yii::$app->basePath."/messages/cs-CS/list.txt");
        $arrCsJson = file_get_contents($fileCs);
        $arrCs = json_decode($arrCsJson, true);

        $fileEn = Yii::getalias(Yii::$app->basePath."/messages/en-EN/list.txt");
        $arrEnJson = file_get_contents($fileEn);
        $arrEn = json_decode($arrEnJson, true);



        
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            file_put_contents($fileRu, json_encode($data["ru"], JSON_HEX_TAG), LOCK_EX);
            file_put_contents($fileCs, json_encode($data["cs"], JSON_HEX_TAG), LOCK_EX);
            file_put_contents($fileEn, json_encode($data["en"], JSON_HEX_TAG), LOCK_EX);
            return $this->refresh();
        }
        return $this->render(
            "index",[
                'arrRu' => $arrRu,
                'arrCs' => $arrCs,
                'arrEn' => $arrEn
            ]
        );
    }
}