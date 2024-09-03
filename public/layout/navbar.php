<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-md-9">
        <nav aria-label="breadcrumb">
            <h6 class="font-weight-bolder text-white mb-0">
                <?php
                echo $title ?? '';
                ?>
            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center search-bar">

            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a class="dropdown-item text-white log_out rounded-bottom py-2" href="javascript:;">
                        <i class='bx bx-log-out-circle
                                text-white text-2xl'></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>