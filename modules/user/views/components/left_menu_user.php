<div class="title_block_user">
    Welcome!
    <span>
    <?= Yii::$app->user->identity->email;?>
    </span>
    <div class="menu-user">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<ul id="menuUser">
    <li><a href="/<?= $lang ?>/user/info-product" data-id="infoproduct">Инфопродукты</a></li>
    <li><a href="/<?= $lang ?>/user/info" data-id="data-user">Личные данные</a></li>
    <li><a href="/<?= $lang ?>/user" data-id="user">История заказов</a></li>
    <!-- <li><a href="">Партнер</a></li> -->
    <li class="exit"><a href="/<?= $lang;?>/logout">Выход</a></li>
</ul>
<!-- class="active" -->



<?php $this->registerJs('
var punckt = "'.$active.'";
$("#menuUser a").each(function(e){
    if($(this).data("id") == punckt){
        $(this).addClass("active");
    }
})
');?>