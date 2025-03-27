<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\CategoryLang;
use app\models\Currencies;
use app\models\TelegramMessageUser;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * CategoryController implements the CRUD actions for Category model.
 */

class TelegaSettingController extends MainController
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TelegramMessageUser::find()->where(['lang' => 'ru']),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id){
        $model = $this->findModel($id);
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $text = $data['TelegramMessageUser']['content'];
        //     $array = array(
        //         "chat_id" 	=> '1270374546',
        //         "text"  	=> $text,
        //         'parse_mode' => 'html'
        //    );
        //    $token = '6249777943:AAGK4FfCtlSEfDD_72Mbi7KMVcB_CsqFefg';
        //    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?" . http_build_query($array);
        //    $ch = curl_init($url);
        //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //    curl_setopt($ch, CURLOPT_HEADER, false);
        //    $resultQuery = curl_exec($ch);
        //    curl_close($ch);
           //var_dump($resultQuery);
        }
        return $this->render('update',[
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = TelegramMessageUser::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
