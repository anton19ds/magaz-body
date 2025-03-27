<?php
//debug($lavel->lavel_id);
use app\models\Lavel;
?>

<select name="" id="set-lavel-user" data-userId="<?= $lavel->user_id?>">

<?php
$dataLavel = Lavel::find()->all();
foreach($dataLavel as $item):
?>
<option value="<?= $item->id?>" <?= ($lavel->lavel_id == $item->id ? 'selected' : '')?>><?= $item->name?></option>
<?php endforeach;?>
</select>