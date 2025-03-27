<div class="table_contacts_order_info__list">
    <p>
        <span>
            <?= Yii::t('app', 'placeholder-name') ?>:
        </span>
        <?= (isset($user['surname']) ? $user['surname'] : "") ?>
        <?= (isset($user['name']) ? $user['name'] : "") ?>
        <?= (isset($user['lastname']) ? $user['lastname'] : "") ?>
    </p>
    <p>
        <span>
            <?= Yii::t('app', 'placeholder-adress') ?>:
        </span>
        <?= (isset($user['postcode']) ? $user['postcode'].', ' : '')?>
        <?= (isset($user['country']) ? $user['country'].', ': '') ?>
        <?= (isset($user['area']) ? $user['area'].', ': '') ?>
        <?= (isset($user['city']) ? $user['city'].', ': '') ?>
        <?= (isset($user['street'])? $user['street'].', ': '') ?>
        <?= (isset($user['house']) ? $user['house'] : '') ?>
    </p>
    <p>
        <span>
            <?= Yii::t('app', 'placeholder-phone') ?>:
        </span>
        <?= $user['phone'] ?>
    </p>
    <p>
        <span>E-Mail:</span>
        <?= $user['email'] ?>
    </p>
    <!-- <a href="#" class="step_prev">Изменить</a> -->
</div>