<?php

namespace app\modules\admin\controllers;

use app\models\Currencies;
use app\models\MailTemplate;
use app\models\MailTemplateLang;
use app\models\SettingData;
use app\models\Shortcode;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

/**
 * Default controller for the `admin` module
 */
class MailController extends MainController
{
    public $title = "Настройка шаблонов писем";
    public $preTitle;

    public $actionType = "/admin/mail/create";
    public $lang;
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MailTemplate::find(),
            'pagination' => [
                'pageSize' => 50,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionSend()
    {
        Yii::$app->mailer->compose('contact/html', ['content' => '$form'])
            ->setFrom('info@body-balance.com')
            ->setTo('bar2018ka@gmail.com')
            ->setSubject('$form->subject')
            ->send();
        //return $this->render('index');
    }

    public function actionCreat()
    {
        $model = new MailTemplate();
        return $this->render('create', []);
    }

    public function actionUpdate($id, $lang = null)
    {
        //debug($lang);
        $arrrayTemplate = array();
        $request = Yii::$app->request->get();
        $currensy = Currencies::find()->all();
        $navLangStr = '<ul><li><a href="/admin/mail/update?id=' . $id . '">RU</a></li>';
        foreach ($currensy as $item) {
            $navLangStr .= '<li><a href="/admin/mail/update?id=' . $id . '&lang=' . $item->tag . '">' . $item->tag . '</a></li>';
        }
        //$lang = 'ru';
        // if($lang)
        $navLangStr .= "</ul>";
        $this->lang = $navLangStr;
        if (isset ($request['lang']) && $request['lang'] != 'ru') {
            if (MailTemplateLang::find()->where(['parent_id' => $id])->andWhere(['lang' => $request['lang']])->exists()) {
                $model = MailTemplateLang::find()->where(['parent_id' => $id])->andWhere(['lang' => $request['lang']])->one();
            } else {
                $parent = MailTemplate::findOne($id);
                $model = new MailTemplateLang([
                    'parent_id' => $id,
                    'lang' => $request['lang'],
                    'name' => $parent->name
                ]);
            }
        } else {
            $model = MailTemplate::findOne($id);
        }
        
            $arrrayTemplate = [
                ['order_id',"[order_id]"],
                ['lastname',"[lastname]"],
                ['name',"[name]"],
                ['surname',"[surname]"],
                ['phone',"[phone]"],
                ['email',"[email]"],
                ['postcode',"[postcode]"],
                ['country',"[country]"],
                ['city',"[city]"],
                ['area',"[area]"],
                ['home',"[home]"],
                ['comment',"[comment]"],
                ['viewData',"[viewData]"],
                ['delivery',"[delivery]"],
                ['payment',"[payment]"],
                ['password', "[userData password=true]"],
                ['username', "[userData username=true]"],
            ];
        
        //debug(serialize($arrrayTemplate));
        $arrrayTemplate = '';
        if(!empty($model->template)){
            $arrrayTemplate = unserialize($model->template);
        }
        // debug($arrrayTemplate);
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if ($model->load($data) && $model->save()) {
                return $this->refresh();
            } else {
                debug($model->getErrors());
            }
        }
        return $this->render('update', [
            'model' => $model,
            'arrrayTemplate' => $arrrayTemplate,
            'lang' => $lang
        ]);
    }

    public function actionSendTest($id, $lang = null)
    {
        if($lang && $lang != 'ru'){
            $model = MailTemplateLang::find()->where(['id' => $id])->andWhere(['lang' => $lang])->one();
            $set = $model->parent_id;
        }else{
            $model = MailTemplate::findOne($id);
            $set = $model->id;
        }
        

        $emailDev = SettingData::find()->where(['meta' => 'email-dev'])->asArray()->one();
        try {
            $attr = [];
                $title = new Shortcode($attr);
                $messag = Yii::$app->mailer->compose('contact/html', ['content' => $model->content, 'attr' => $attr])
                ->setFrom('info@body-balance.com')
                ->setTo($emailDev['value'])
                ->setSubject($title->parse($model->title))
                ->send();
                if($lang && $lang != 'ru'){
                    $link = "/admin/mail/update?id=" . $set."&lang=".$lang;
                }else{
                    $link = "/admin/mail/update?id=" . $set;
                }
                
            return $this->redirect($link);
        } catch (\Exception $e) {
            echo "Ошибка отправки";
        }
    }

    public function actionView($id){
        $model = MailTemplate::findOne($id);
        return $this->renderPartial('view', [
            'model' => $model
        ]);
    }
}