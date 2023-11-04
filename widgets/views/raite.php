<div class="strag">
    <div class="rating-list">
        <?php if (!empty($model->raite)): ?>
            <?php $endRaite = 5 - $model->raite ?>
            <?php for ($i = 0; $i < $model->raite; $i++): ?>
                <div class="star"></div>
            <?php endfor; ?>
            <?php for ($i = 0; $i < $endRaite; $i++): ?>
                <div class="star no"></div>
            <?php endfor; ?>
        <?php else: ?>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
        <?php endif; ?>
    </div>
    <span>89 оценок</span>
</div>