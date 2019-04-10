    <ul class="side-nav-menu scrollable">
        <li class="nav-item active">
            <a class="mrg-top-30" href="<?= url::to(['site/index']) ?>">
                <span class="icon-holder">
                    <i class="ti-palette"></i>
                </span>
                <span class="title">Tableau de bord</span>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="ti-package"></i>
                </span>
                <span class="title">Menu</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="<?= url::to(['menu/index']) ?>">Liste</a>
                </li>
            </ul>
        </li>
<!--         <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="ti-package"></i>
                </span>
                <span class="title">Niveau d'accès</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="<?= url::to(['menu/index']) ?>">Liste</a>
                </li>
            </ul>
        </li> -->
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="ti-package"></i>
                </span>
                <span class="title">Profile</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="<?= url::to(['profile/index']) ?>">Liste</a>
                </li>
                <li>
                    <a href="<?= url::to(['profile/droit']) ?>">Droit</a>
                </li>
            </ul>
        </li>        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="ti-user"></i>
                </span>
                <span class="title">Utilisateurs</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="<?= url::to(['user/index']) ?>">Liste</a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="ti-user"></i>
                </span>
                <span class="title">Client</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="invoice.html">Liste</a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="ti-user"></i>
                </span>
                <span class="title">Personnel</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li class="nav-item dropdown">
                    <a href="javascript:void(0);">
                        <span>Liste</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="ti-file"></i>
                </span>
                <span class="title">Produit</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="form-elements.html">Catégorie</a>
                </li>
                <li>
                    <a href="form-layouts.html">Article</a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="ti-layout-media-overlay"></i>
                </span>
                <span class="title">Stock</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="basic-table.html">Stock quatité</a>
                </li>
                <li>
                    <a href="data-table.html">Stock prix</a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="ti-pie-chart"></i>
                </span>
                <span class="title">Statitique</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="nvd3.html">Bilan stock quatité</a>
                </li>
                <li>
                    <a href="chartjs.html">Bilan stock prix</a>
                </li>
                <li>
                    <a href="sparkline.html">Graphes</a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="ti-map-alt"></i>
                </span>
                <span class="title">Charges</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="google-map.html">Liste des charges</a>
                </li>
                <li>
                    <a href="vector-map.html">Bilan des charges</a>
                </li>
            </ul>
        </li>
    </ul>