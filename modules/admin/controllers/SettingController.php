<?php

namespace app\modules\admin\controllers;

use app\models\Cart;
use app\models\Category;
use app\models\CategoryLang;
use app\models\Currencies;
use app\models\TelegramUser;
use app\models\ViewDelivery;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use app\models\SettingData;
use yii\helpers\ArrayHelper;

/**
 * CategoryController implements the CRUD actions for Category model.
 */


class SettingController extends MainController
{
    public $data = [
        'insurance' => 'размер страховки',
        'insuranceSale' => 'скидка страховки',
    ];

    public $delivery = [
        Cart::TYPE_RUSS => 'Цена доставки По России',
        Cart::TYPE_EMS => 'Цена доставки EMS',
        Cart::TYPE_SNG => 'Цена доставки Страны Балтии и СНГ',
        Cart::TYPE_CS => 'Цена доставки по Чехии',
        Cart::TYPE_EURO => 'Цена доставки по Евросоюзу',
        Cart::TYPE_INFO => 'Инфокурс',
    ];

    public $langSet = [
        'ru',
        'cs',
        'en',
    ];

    public $field = [
        'seo-title' => 'Снипет Заголовок',
        'seo-desc' => 'Снипет Текст'
    ];


    public $title;
    public $preTitle;
    public $actionType;
    public $lang;
    public function actionIndex()
    {
        $settingData = ArrayHelper::map(SettingData::find()->asArray()->all(), 'meta', 'value');
        $langData = Currencies::find()->all();

        $SeoDataArray = [];
        $SeoData = SettingData::find()->where(['meta' => 'seo-title'])->orWhere(['meta' => 'seo-desc'])->asArray()->all();
        foreach($SeoData as $d => $f){
            $SeoDataArray[$f['lang']][$f['meta']]= $f['value'];
        }
        
        $langData = ArrayHelper::getColumn($langData, 'tag');
        $langData[] = 'ru';
        $dataProvider = new ActiveDataProvider([
            'query' => TelegramUser::find(),
        ]);

        $viewDelivery = ViewDelivery::find()->asArray()->all();
        //debug($viewDelivery);
        $resViewDelivery = [];
        foreach($viewDelivery as $rt => $ty){
            $resViewDelivery[$ty['data']][$ty['meta']] = $ty['value'];
        }
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            foreach ($data['Data'] as $key => $value) {
                if (SettingData::find()->where(['meta' => $key])->exists()) {
                    $model = SettingData::find()->where(['meta' => $key])->one();
                } else {
                    $model = new SettingData([
                        'meta' => $key
                    ]);
                }
                $model->value = $value;
                $model->save();
            }
            
            if($data['Seo']){
                foreach($data['Seo'] as $el => $item){
                    foreach($item as $ch => $er){
                        if (SettingData::find()->where(['meta' => $ch])->andWhere(['lang' => $el])->exists()) {
                            $model = SettingData::find()->where(['meta' => $ch])->andWhere(['lang' => $el])->one();
                            $model->value = $er;
                        } else {
                            $model = new SettingData([
                                'meta' => $ch,
                                'value' => $er,
                                'lang' => $el
                            ]);
                        }
                        $model->save();       
                    }
                }
            }






            if($data['Data']['del-data']){
                foreach($data['Data']['del-data'] as $el => $item){
                    foreach($item as $ch => $er){
                        if(!ViewDelivery::find()->where(['data' => $el])->andWhere(['meta' => strtoupper($ch)])->exists()){
                            $mod = new ViewDelivery([
                                'data' => $el,
                                'meta' => strtoupper($ch),
                                'value' => $er
                            ]);
                        }else{
                            $mod = ViewDelivery::find()->where(['data' => $el])->andWhere(['meta' => strtoupper($ch)])->one();
                            $mod->value = $er;
                        }
                        if(!$mod->save()){
                            return var_dump($mod->getErrors());
                        };
                    }

                }
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'data' => $this->data,
            'delivery' => $this->delivery,
            'settingData' => $settingData,
            'dataProvider' => $dataProvider,
            'langData' => $langData,
            'resViewDelivery' => $resViewDelivery,
            'langSet' => $this->langSet,
            'field' => $this->field,
            'SeoDataArray' => $SeoDataArray
        ]);
    }

    public function actionAddUserTel()
    {
        $model = new TelegramUser();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('index');
            }
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdateTel($id)
    {
        $model = TelegramUser::findOne($id);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('index');
            }
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionDeleteTel($id)
    {
        $model = TelegramUser::findOne($id);
        if ($model->delete()) {
            return $this->redirect('index');
        }
    }
}