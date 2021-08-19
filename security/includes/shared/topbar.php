<style>
.sms a:hover {
    text-decoration: none;
}

.sms .sidebar-brand-text,
.sidebar-brand-icon {
    font-size: 20px;
}
</style>
<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <div class="sms">
        <a class="sidebar-brand d-flex align-items-center justify-content-center my-3" href="index.php">
            <div class="sidebar-brand-icon ">
                <i class="fas fa-fw fa-home"></i>
            </div>
            <div class="sidebar-brand-text mx-2 my-5">SMS</div>
        </a>
    </div>
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <?php
?>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">

            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <div class="topbar-divider d-none d-sm-block">

        </div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <!-- <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-lg-inline d-sm-block text-gray-600 small">NAME</span>
            </a> -->
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">

                <div class="mr-2 d-lg-inline profile-icon-parent"> <i class="fas fa-user fa-fw"></i></div>
            </a>
            <!-- Dropdown - Security Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown"
                style="background:black;">
                <a class="dropdown-item" href="#" style="color:white;">
                    <div>
                        <span class="prof-drop-name"><?php echo $_SESSION['name']; ?></span>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="user_profile.php" style="color:white;">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="security_settings.php" style="color:white;">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" style="color:white;">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>

</nav>
<!-- End of Topbar -->