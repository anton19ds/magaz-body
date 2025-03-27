<?php
use app\models\Product;
use app\widgets\Raite;
use yii\bootstrap5\Modal;

?>
<main id="topBody">
    <section id="infoproducts">
        <div class="container">
            <?php echo $this->render('../components/left_menu_user.php', [
                'lang' => $lang,
                'active' => 'infoproduct'
            ]) ?>
            <div class="infoproducts__main">
                <h1>
                    <?= Yii::t('app','info-products')?>
                </h1>
                <div class="list-infoproducts" id="infoproducts-active-list">
                    <?php foreach ($query as $item): ?>
                        <?= $this->render('infoproduct-view',[
                            'item' => $item,
                            'lang' => $lang,
                            'listArray' => $listArray
                        ])?>
                        
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </section>
</main>
<style>
    .infoproduct_img img {
        max-width: 100%
    }

    .data-raite{
        display: flex;
        align-items: center;
    }
    .data-raite span:last-child:not(".rate_active"){
        margin-left: 10px;
    }
    .star {
        display: block;
        width: 14px;
        height: 14px;
        background: url('/img/star.svg') no-repeat center;
    }
    .star.active {
        background: url('/img/star-active.svg') no-repeat center;
    }
    .infoproduct_in_stock .icon_has_stock:after {
        content: '<?= Yii::t('app', 'accsess-no')?>';
        border: 1px solid #5ECD52;
    }
    .infoproduct_no_stock .icon_has_stock:after {
    content: '<?= Yii::t('app', 'accsess-ok')?>';
    border: 1px solid #D72E1F;
}
</style>
<script>
    var h2 = document.getElementById('pageSetBody').offsetHeight;
    parent.postMessage({
        heUserInfo: h2,
        top: true
    }, '*');
</script>
<?php $this->registerJs('
$(document).on("click", ".referInfoc", function(e){
    e.preventDefault();
    var dataLink = $(this).data("link");
    parent.postMessage({
        linkData : dataLink,
    }, "*");
})
')?>






