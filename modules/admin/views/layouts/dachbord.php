<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">
                    <?= $title ?>
                </h2>
                <h5 class="text-white op-7 mb-2">
                    <?= $preTitle ?>
                </h5>
                <?php if ($lang): ?>
                    <div class="ul-nav-lang">
                        <?= $lang ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="ml-md-auto py-2 py-md-0 set-ger">
                <?php if ($actionType): ?>
                    <a href="<?= $actionType ?>" class="btn btn-white btn-border btn-round mr-2">Новый</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>