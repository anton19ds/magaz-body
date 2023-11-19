<div class="currency" id="currency">
    <button class="currency-btn currency-btn_top active">
        <a href="/ru">₽</a>
    </button>
    <?php foreach($model as $item):?>
    <button class="currency-btn currency-btn_buttom" data-tag="<?= $item['tag'];?>">
        <!-- € -->
        <a href="/<?= $item['tag'];?>"><?= $item['tag'];?></a>
    </button>
    <?php endforeach;?>
</div>
<style>
.currency-btn a{
    color: inherit;
}
</style>

