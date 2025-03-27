<?php
namespace app\widgets;
use app\models\User;
use Yii;

class UserData extends \yii\bootstrap5\Widget
{
    public $password = false;
    public $username = false;
    // public $order_id = false;

    public function run()
    {
        if(!Yii::$app->user->isGuest){
            $user = User::findOne(Yii::$app->user->identity->id);
            $username = $user->username;
            $password = $user->password;
        }else{
            $username = 'username';
            $password = 'password';
        }
        if($this->password){
            return $password;
        }
        if($this->username){
            return $username;
        }
        // if($this->order_id){
        //     return $this->order_id;
        // }
        return 'userData';
    }
}
