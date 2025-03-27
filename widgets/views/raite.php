<?php if (!$front): ?>
    <?php if ($grade != 5): ?>
            <?php for ($i = 0; $i < 5; $i++): ?>
                <?php if ($i < $grade): ?>
                    <span class="rate_active"></span>
                <?php else: ?>
                    <span></span>
                <?php endif; ?>
            <?php endfor; ?>
        <?php else: ?>
            <span class="rate_active"></span>
            <span class="rate_active"></span>
            <span class="rate_active"></span>
            <span class="rate_active"></span>
            <span class="rate_active"></span>
        <?php endif; ?>
    <?php if ($view): ?>
        <p class="count_rate">( <?= count($raite) ?> )
        </p>
    <?php else: ?>
        <p class="count_rate">
            <?= count($raite) ?> <?= Yii::t('app', "ratings")?>
        </p>
    <?php endif; ?>
<?php else: ?>
    <div class="list_rate_table">
        <?php if ($grade != 5): ?>
            <?php for ($i = 0; $i < 5; $i++): ?>
                <?php if ($i < $grade): ?>
                    <span class="rate_active"></span>
                <?php else: ?>
                    <span></span>
                <?php endif; ?>
            <?php endfor; ?>
        <?php else: ?>
            <span class="rate_active"></span>
            <span class="rate_active"></span>
            <span class="rate_active"></span>
            <span class="rate_active"></span>
            <span class="rate_active"></span>
        <?php endif; ?>
    </div>

    <p class="count_rate">
        <?php if ($view): ?>
            ( <?= count($raite) ?> )
        <?php else: ?>
            <?= count($raite) ?> <?= Yii::t('app', "ratings")?>
        <?php endif; ?>
    </p>
<?php endif; ?>

<!-- <div class="card-details__rating flex-box"> -->




<!-- </div> -->