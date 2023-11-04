<ul class="nav nav-primary">

    <li class="nav-item active">
        <a href="/admin" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Главная</p>
        </a>
    </li>

    <li class="nav-section">
        <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
        </span>
    </li>
    <li class="nav-item">
        <!-- <a data-toggle="collapse" href="#base">
      <i class="fas fa-layer-group"></i>
      <p>Склады</p>
      <span class="caret"></span>
    </a> -->
        <div class="collapse" id="base">
            <ul class="nav nav-collapse">
                <li>
                    <a href="components/avatars.html">
                        <span class="sub-item">Список складов</span>
                    </a>
                </li>
                <li>
                    <a href="components/buttons.html">
                        <span class="sub-item">Добавить склад</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a data-toggle="collapse" href="#sidebarLayouts">
            <i class="fas fa-th-list"></i>
            <p>Товары</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="sidebarLayouts">
            <ul class="nav nav-collapse">
                <li>
                    <a href="/admin/product">
                        <span class="sub-item">Список товаров</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/product/create">
                        <span class="sub-item">Простой товар</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/product-variable/create">
                        <span class="sub-item">Сборный товар</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/category/index">
                        <span class="sub-item">Категории</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
    <a href="/admin/user">
            <i class="fas fa-pen-square"></i>
            <p>Пользователи</p>
        </a>
    </li>
    <li class="nav-item">
        <a data-toggle="collapse" href="#tables">
            <i class="fas fa-table"></i>
            <p>Аналитика</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="tables">
            <ul class="nav nav-collapse">
                <li>
                    <a href="tables/tables.html">
                        <span class="sub-item">Basic Table</span>
                    </a>
                </li>
                <li>
                    <a href="tables/datatables.html">
                        <span class="sub-item">Datatables</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a data-toggle="collapse" href="#maps">
            <i class="fas fa-map-marker-alt"></i>
            <p>Инфокурсы</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="maps">
            <ul class="nav nav-collapse">
                <li>
                    <a href="/admin/info/index">
                        <span class="sub-item">Список инфокурсов</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/info/create">
                        <span class="sub-item">Новый инфокурсов</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a data-toggle="collapse" href="#charts">
            <i class="far fa-chart-bar"></i>
            <p>Настроки</p>
            <span class="caret"></span>
        </a>
        <div class="collapse" id="charts">
            <ul class="nav nav-collapse">
                <li>
                    <a href="/admin/currencies/index">
                        <span class="sub-item">Валюты</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/promocod/index">
                        <span class="sub-item">Промокоды</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/translations">
                        <span class="sub-item">Переводы</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/payment-type/index">
                        <span class="sub-item">Платежные системы</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a href="/admin/file">
            <i class="fas fa-desktop"></i>
            <p>Файлы</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="/admin/orders">
            <i class="fas fa-desktop"></i>
            <p>Заказы</p>
        </a>
    </li>
</ul>