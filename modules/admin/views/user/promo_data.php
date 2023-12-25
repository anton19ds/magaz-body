<?php

use app\models\CategoryPromo;
use app\models\PromoUserSize;

?>
<?php foreach ($model->promo as $elem): ?>
    
    <p><a href="/ru/p/<?= $elem->name ?>"><?= $elem->name ?></a>
    <?php if (!empty($elem->promoUserSize)): ?>
        <?php $arrayData = $elem->promoUserSize;
        $arrayElem = [];
        foreach($arrayData as $item){
            $arrayElem[$item->category_promo_id][] = $item;
        }
        
        ?>

        <table style="width:100%">
            <?php foreach ($arrayElem as $key => $sizePromo): ?>
                <tr>
                    <td colspan="2" style="text-align:center">
                        <?= CategoryPromo::getName($key)?>
                    </td>
                </tr>
                <?php foreach($sizePromo as $set):?>
                <tr>
                    <td style="text-align:center">
                        <?= $set['size'] ?>%
                    </td>
                    <td style="text-align:center">
                        <?= PromoUserSize::getType()[$set['type']] ?>
                    </td>
                </tr>
                <?php endforeach;?>

            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php endforeach; ?>


<style>
    table, td, th {
  border-collapse: collapse;
  border: 1px solid #000;
}
</style>