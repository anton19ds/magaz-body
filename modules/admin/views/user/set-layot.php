<div class="row">
    <section id="set-menu-user">
        <div class="col-md-12">
            <ul>
                <li><a href="/admin/user/update?id=<?= $model->id ?>">Общие данные</a> </li>
                <li><a href="/admin/user/adress?id=<?= $model->id ?>">Адреса</a> </li>
                <li><a href="/admin/user/balance?id=<?= $model->id ?>">Баланс</a> </li>
                <li><a href="/admin/user/orders?id=<?= $model->id ?>">Список заказов</a> </li>
                <li><a href="/admin/user/user-request?id=<?= $model->id ?>">Заявки</a> </li>
                <li><a href="/admin/user/user-rivers?id=<?= $model->id ?>">Отзывы</a> </li>
                
                <li><a href="/admin/user/user-tasks?id=<?= $model->id ?>">Выполненые задания</a> </li>
                <li><a href="/admin/user/partners?id=<?= $model->id ?>">Партнерская программа</a> </li>
                <li><a href="/admin/user/infocurs?id=<?= $model->id ?>">Доступ к инфокурсам</a> </li>
            </ul>
        </div>
    </section>
</div>
<div class="user-update">
    <?= $this->render($view, [
        'model' => $model,
        'provider' => $provider,
        'balanceUser' => (isset($balanceUser) ? $balanceUser : null)
    ]) ?>
</div>