<?php

namespace app\controllers;

use app\models\TelegramChatList;
use app\models\User;
use TelegramBot\Api\Client;
use Yii;

class TelegramController extends MainController
{
    public function beforeAction($action)
    {
        if (in_array($action->id, ['telegram', 'index', 'main'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    

    public function actionIndex()
    {
        try {
            $bot = new Client('.....');
            $bot->command('ping', function ($message) use ($bot) {
                $bot->sendMessage($message->getChat()->getId(), 'pong!');
            });
            $bot->command('start', function ($message) use ($bot) {
                $bot->sendMessage($message->getChat()->getId(), 'введите ваш Email');
            });

            $bot->on(function (\TelegramBot\Api\Types\Update $update) use ($bot) {
                $message = $update->getMessage();
                $id = $message->getChat()->getId();
                if (filter_var($message->getText(), FILTER_VALIDATE_EMAIL)) {
                    if (User::find()->where(['email' => $message->getText()])->exists()) {
                        $user = User::find()->where(['email' => $message->getText()])->one();
                        if (!TelegramChatList::find()->where(['chat' => $id])->andWhere(['user_id' => $user->id])->exists()) {
                            $bot->sendMessage($id, 'Email ' . $message->getText() . ' указан верно');
                            $newChat = new TelegramChatList(([
                                'chat' => $id,
                                'user_id' => $user->id
                            ]));
                            if (!$newChat->save()) {
                                return json_decode($newChat->getErrors());
                            };
                        }
                    }
                } else {
                    $bot->sendMessage($id, 'Email ' . $message->getText() . ' указан неверно');
                }
            }, function () {
                return true;
            });
            $bot->run();
        } catch (\TelegramBot\Api\Exception $e) {
            $e->getMessage();
        }
    }
}