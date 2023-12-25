<?php if (!empty($model->raite)): ?>
    <?php $endRaite = 5 - $model->raite ?>
    <?php for ($i = 0; $i < $model->raite; $i++): ?>
        <span class="star active"></span>
    <?php endfor; ?>
    <?php for ($i = 0; $i < $endRaite; $i++): ?>
        <span class="star"></span>
    <?php endfor; ?>
<?php else: ?>
    <span class="star active"></span>
    <span class="star active"></span>
    <span class="star active"></span>
    <span class="star active"></span>
    <span class="star"></span>
<?php endif; ?>
<?php if ($view): ?>
    <span>(
        <?= count($raite) ?>)
    </span>
<?php else: ?>
    <span>
        <?= count($raite) ?> оценок
    </span>
<?php endif; ?>


<!-- <div class="card-details__rating flex-box"> -->




<!-- </div> -->

