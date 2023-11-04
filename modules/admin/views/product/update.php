<?php

use app\models\Product;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>


<?php

echo $this->render('_form', [
  'model' => $model,
  'arrayData' => $arrayData,
  'meta' => $meta,
  'lang' => $lang
]);

?>