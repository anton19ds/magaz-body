<?php if($url == '/' || empty($url)):?>
<script>
    parent.postMessage({
        linkData: "/<?= $lang?>",
    }, '*');
</script>

<?php endif;?>





<?php $setArray = explode("/", $url);
//debug($url);
if($setArray[0] =='ru' || $setArray[0] =='en' || $setArray[0] =='cs'){?>
<script>
    parent.postMessage({
        linkData: "/<?= $url?>",
    }, '*');
</script>
<?php }?>



<script>
    parent.postMessage({
        linkData: "/<?= $url?>",
    }, '*');
</script>