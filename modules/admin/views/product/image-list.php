<?php if(!empty($image)):?>
<?php $imageList = json_decode($image, true)?>
<?php foreach($imageList['array'] as $key => $item):?>
  <img src="<?= $item['value']?>" alt="">
<?php endforeach;?>
<?php endif;?>
