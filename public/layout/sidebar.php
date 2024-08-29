<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/">
            <img src="/assets/img/logos/AGS_Emblème_RVB_Noir.jpg" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">AGS</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link
                    <?php
                    echo 'dashboard' === $route ? 'active' : '';
                    ?>
                    " href="<?php echo "/dashboard" ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bx bxs-dashboard text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tableau de bord</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                <?php
                echo 'comptes' === $route ? 'active' : '';
                ?>
                " href="<?php echo "/dataCollect" ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bx bxs-group text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1"></span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<!-- <div class="sidebar">
    <div class="logo-details">
        <i class="bx bxl-c-plus-plus"></i>
        <span class="logo_name">D-CLIC</span>
    </div>
    <ul class="nav-links">
        <li class="dashoard">
            <a href="#" class="active">
                <i class="bx bx-grid-alt"></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bx bx-box"></i>
                <span class="links_name">Site</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bx bx-user"></i>
                <span class="links_name">Admin</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bx bx-pie-chart-alt-2"></i>
                <span class="links_name">Analyses</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bx bx-coin-stack"></i>
                <span class="links_name">Matériel</span>
            </a>
        </li>
        <li class="salarieUpdate">
            <a href="#">
                <i class="bx bx-user"></i>
                <span class="links_name">Utilisateur</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bx bx-cog"></i>
                <span class="links_name">Configuration</span>
            </a>
        </li>
        <li class="log_out">
            <a href="" id="logout">
                <i class="bx bx-log-out"></i>
                <span class="links_name">
                    Déconnexion
                </span>
            </a>
        </li>
    </ul>
</div> -->