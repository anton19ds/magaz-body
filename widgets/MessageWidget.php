<?php
namespace app\widgets;
use app\models\Reviews;
use app\models\UserBalance;
use app\models\UserRequest;
use app\models\UserTasks;
use Yii;

class MessageWidget extends \yii\bootstrap5\Widget
{

    public function run()
    {
        $taskMessage = UserTasks::find()->where(['status' => '0'])->select(['user_id', 'date', 'id', 'tasks_id'])->asArray()->all();
        $reviewsMessage = Reviews::find()->where(['status' => '1'])->select(['user_id', 'date', 'id', 'star'])->asArray()->all();
        $requestMessage = UserRequest::find()->where(['status' => '0'])->select(['user_id', 'date', 'id', 'type'])->asArray()->all();
        $userBlance = UserBalance::find()
            ->where(['status' => '0'])
            ->select(['user_id', 'date', 'id', 'summ'])
            ->asArray()
            ->all();
        $sortArray = array_merge($requestMessage, $reviewsMessage, $taskMessage, $userBlance);
        
        usort($sortArray, function ($age1, $age2) {
            if ($age1["date"] == $age2["date"]) {
              return 0;
            }
            return ($age1["date"] < $age2["date"]) ? 1 : -1;
            });
        return $this->render('view-message', [
            'sortArray' => $sortArray
        ]);
    }
}