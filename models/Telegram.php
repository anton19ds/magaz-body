<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class Telegram extends Model
{
    public static function senMessege($text, $chat){
        
        // $array = array(
        //      "chat_id" 	=> $chat,
        //      "text"  	=> $text,
        // );
        // //https://t.me/AadevMagaz_bot
        // $token = '6249777943:AAGK4FfCtlSEfDD_72Mbi7KMVcB_CsqFefg';
        // $url = "https://api.telegram.org/bot" . $token . "/sendMessage?" . http_build_query($array);
        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HEADER, false);
        // $resultQuery = curl_exec($ch);
        // curl_close($ch);
        // var_dump($resultQuery);
    }
}