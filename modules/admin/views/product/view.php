<div class="row g-1">
  <?php foreach ($data['array'] as $key => $item): ?>
    <div class="col-3 img-element-<?= $key?>" data-id="<?= $key?>">
    <span class="remove-image" data-id="<?= $key?>"><i class="far fa-times-circle" style="color:red"></i></span>
      <label class="imagecheck mb-1">
        <figure class="imagecheck-figure">
          <img src="<?= $item['value'] ?>" alt="заголовок" class="imagecheck-image">
        </figure>
      </label>
    </div>
  <?php endforeach; ?>
</div>