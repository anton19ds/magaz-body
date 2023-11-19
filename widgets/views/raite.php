<div class="infoproduct_rate">
    <div class="infoproduct_rate_table">

        <?php if (!empty($model->raite)): ?>
            <?php $endRaite = 5 - $model->raite ?>
            <?php for ($i = 0; $i < $model->raite; $i++): ?>
                <span class="infoproduct_rate_active"></span>
            <?php endfor; ?>
            <?php for ($i = 0; $i < $endRaite; $i++): ?>
                <div class="star no"></div>
            <?php endfor; ?>
        <?php else: ?>
            <span class="infoproduct_rate_active"></span>
            <span class="infoproduct_rate_active"></span>
            <span class="infoproduct_rate_active"></span>
            <span class="infoproduct_rate_active"></span>
            <span></span>
        <?php endif; ?>
    </div>
    <p class="count_rate">(95)</p>
</div>