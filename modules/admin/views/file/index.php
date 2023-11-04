
<?php
use \mihaildev\elfinder\InputFile;
use \mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
mihaildev\elfinder\Assets::noConflict($this);

?>
<section class="fgh" style="height:80vh">
<?php
echo ElFinder::widget([
    'language'         => 'ru',
    'controller'       => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'filter'           => array('image', 'video/mp4', 'application/pdf'),    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'callbackFunction' => new JsExpression('function(file, id){}'), // id - id виджета
    // 'uploadAllow'   => array('image/x-ms-bmp', 'image/gif', 'image/jpeg', 'image/png', 'image/x-icon', 'text/plain', ),
]);
?>
</section>
    

<style>
  .fgh div{
    height: 100%;
  }
</style>
