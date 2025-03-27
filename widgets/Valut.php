<?php

namespace app\widgets;

use app\models\Currencies;
use Yii;

class Valut extends \yii\bootstrap5\Widget
{
    public $cur;
    public function run()
    {
        if($this->cur == 'ru'){
         return '₽';
        }else{
           return $this->cur; 
        }
    }
}
