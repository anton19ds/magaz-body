<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin([
  'id' => 'imageList'
]);
?>
<div class="row g-1">
  <?php if(!empty($model)):?>
  <?php foreach($model as $item => $key):?>
  <div class="col-3">
    <label class="imagecheck mb-1">
      <input name="imagecheck-<?= $item?>" type="checkbox" value="/file/<?= $key['name']?>" class="imagecheck-input">
      <figure class="imagecheck-figure">
        <img src="/file/<?= $key['name']?>" alt="title" class="imagecheck-image">
      </figure>
    </label>
  </div>
  <?php endforeach;?>
  <?php endif;?>
  <div class="col-md-12">
    <?= Html::submitButton('Добавить',['class' => 'btn btn-success'])?>
  </div>
</div>
<?php ActiveForm::end();?>