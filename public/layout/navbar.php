<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <h6 class="font-weight-bolder text-white mb-0">
                <?php
                echo $title ?? '';
                ?>
            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center search-bar">
                <?php
                $fields = ['Comptes', 'Matériels', 'Utilisateurs RH',];
                if (in_array($title, $fields)): ?>

                    <form method="get">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="bx bx-search" aria-hidden="true"></i></span>
                            <input type="text" name="q" class="form-control search-input" value="<?= $query ?? '' ?>"
                                placeholder="Trouver...">
                        </div>
                    </form>
                <?php endif; ?>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <span class="text-white bonjour-text font-weight-bold">Bonjour</span>
                    <a href="javascript:;" class="nav-link text-white showProfileDropdown font-weight-bold px-0">
                        <span class="d-sm-inline d-none">
                            <?php echo $_SESSION['user']['username'] ?>
                        </span>
                    </a>

                    <div class="profileDropdown dropdown-menu dropdown-menu-end mt-7 py-0" style="right:0">
                        <a class="dropdown-item rounded-top py-2" href="javascript:;">
                            <i class='bx bxs-user
                                text-dark'></i>
                            <span class="ms-2">
                                <?php echo $_SESSION['userrole'] ?>
                            </span>
                        </a>
                        <a class="dropdown-item log_out rounded-bottom py-2" href="javascript:;">
                            <i class='bx bx-log-out-circle
                                text-dark'></i>
                            <span class="ms-2">Se Déconnecter</span>
                        </a>
                    </div>
                </li>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>