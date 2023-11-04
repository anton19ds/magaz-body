<?php

namespace app\modules\admin\controllers;

use app\assets\AdminAsset;
use app\models\Currencies;
use app\models\Product;
use app\models\ProductMeta;
use app\models\Translations;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `admin` module
 */
class TranslationsController extends ParentController
{
    protected $arraParam = [
        'add_cart',
        'more_details',
        'quantity'
    ];
    public function actionIndex()
    {
        $this->title = 'Переводы';
        $this->preTitle = 'Переводы и поля';

        $param = $this->arraParam;
        $currens = Currencies::find()->select('tag')->asArray()->all();
        $currens = ArrayHelper::getColumn($currens, 'tag');
        $currens[] = 'ru';
        $dataTran = Translations::find()->asArray()->all();

        $arrayDataTran = [];
        foreach ($dataTran as $item) {
            $arrayDataTran[$item['param']][$item['tag']] = $item['value'];
        }
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            if (isset($data['data']) && !empty($data['data'])) {
                foreach ($data['data'] as $key => $value) {
                    foreach ($value as $elem => $item) {
                        if (Translations::find()->where(['param' => $key])->andWhere(['tag' => $elem])->exists()) {
                            $model = Translations::find()->where(['param' => $key])->andWhere(['tag' => $elem])->one();
                            $model->value = $item;
                        } else {
                            $model = new Translations([
                                'param' => $key,
                                'value' => $item,
                                'tag' => $elem
                            ]);
                        }
                        $model->save();
                    }
                }
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'param' => $param,
            'currens' => $currens,
            'arrayDataTran' => $arrayDataTran
        ]);
    }

}