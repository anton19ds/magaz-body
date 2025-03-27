<div class="type_currency">
    <a data-lang="ru" href="/ru" class="<?= ($request['lang'] == 'ru' ? 'active' : '')?>">₽</a>
    <?php foreach($model as $item):?>
        <a data-lang="<?= mb_strtolower($item['tag'])?>" href="/<?= mb_strtolower($item['tag'])?>" class="<?= ($request['lang'] == mb_strtolower($item['tag']) ? 'active' : '')?>"><?= $item['icon']?></a>
    <?php endforeach;?>
</div>

<?php $this->registerJs('
$(document).on("click", ".type_currency a", function(e){
    e.preventDefault();
    parent.postMessage({
		langRefer: $(this).attr("data-lang")
	}, "*");
})

')?>