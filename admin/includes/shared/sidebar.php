<ul class="navbar-nav bg-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center my-3" href="index.php">
        <div class="sidebar-brand-icon ">
            <i class="fas fa-fw fa-home"></i>
        </div>
        <div class="sidebar-brand-text mx-3 my-5">SMS</div>
    </a>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="far fa-user fa-fw"></i>
            <span>Admin</span></a>
    </li>
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse12" aria-expanded="true"
            aria-controls="collapseTwoone">
            <i class="fas fa-building fa-fw"></i>
            <span>Flat Area</span>
        </a>
        <div id="collapse12" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="add_flat_area.php">Add Flat Area</a>
                <a class="collapse-item" href="manage_flat_area.php">Manage Flat Area</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-building fa-fw"></i>
            <span>Flats</span>
        </a>
        <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="add_flat.php">Add Flats</a>
                <a class="collapse-item" href="manage_flats.php">Manage Flats</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true"
            aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Allotments</span>
        </a>
        <div id="collapsePages2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="add_allotments.php">Add Allotments</a>
                <a class="collapse-item" href="manage_allotments.php">Manage Allotments</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true"
            aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-tags"></i>
            <span>Bills</span>
        </a>
        <div id="collapsePages3" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="add_bills.php">Add Bills</a>
                <a class="collapse-item" href="manage_charges_flats.php">Manage Additional <br>Charges</a>
                <a class="collapse-item" href="manage_bills.php">Manage Bills</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages4" aria-expanded="true"
            aria-controls="collapseUtilities">
            <i class="fas fa-users" aria-hidden="true"></i>
            <span>Complaints</span>
        </a>
        <div id="collapsePages4" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="unresolved_complaints.php">Unresolved</a>
                <a class="collapse-item" href="inprogress_complaints.php">In Progress</a>
                <a class="collapse-item" href="resolved_complaints.php">Resolved</a>
                <a class="collapse-item" href="total_complaints.php">Total Complaints</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages5" aria-expanded="true"
            aria-controls="collapseUtilities">
            <i class="fa fa-eye" aria-hidden="true"></i>
            <span>Visitors</span>
        </a>
        <div id="collapsePages5" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="add_visitors.php">Add Visitors</a>
                <a class="collapse-item" href="manage_visitors.php">Manage Visitors</a>
            </div>
        </div>
    </li>
    <!-- <hr class="sidebar-divider"> -->

    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages6" aria-expanded="true"
            aria-controls="collapseUtilities">
            <i class="fas fa-search" aria-hidden="true"></i>
            <span>Search</span>
        </a>
        <div id="collapsePages6" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="search_flat.php">Search Flat</a>
                <a class="collapse-item" href="search_visitor.php">Search Visitor</a>
                <a class="collapse-item" href="search_allotment.php">Search Allotment</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages7" aria-expanded="true"
            aria-controls="collapseUtilities">
            <i class="fas fa-file" aria-hidden="true"></i>
            <span>Report</span>
        </a>
        <div id="collapsePages7" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="flat_reports.php">Flats b/w dates</a>
                <a class="collapse-item" href="allotment_reports.php">Allotments b/w dates</a>
                <a class="collapse-item" href="visitor_reports.php">Visitors b/w dates</a>
            </div>
        </div>
    </li> -->

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages8" aria-expanded="true"
            aria-controls="collapseUtilities">
            <i class="fas fa-shield-alt" aria-hidden="true"></i>
            <span>Security</span>
        </a>
        <div id="collapsePages8" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="add_security.php">Add Security</a>
                <a class="collapse-item" href="manage_security.php">Manage Security</a>
            </div>
        </div>
    </li>

    <!-- <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages9" aria-expanded="true"
            aria-controls="collapseUtilities">
            <i class="fas fa-clock" aria-hidden="true"></i>
            <span>Meetings</span>
        </a>
        <div id="collapsePages9" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="schedule_meetings.php">Schedule Meetings</a>
                <a class="collapse-item" href="manage_meetings.php">Manage Meetings</a>
            </div>
        </div>
    </li> -->

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="shoutbox.php">
            <i class="fas fa-fw fa-volume-up"></i>
            <span>Shoutbox</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block mb-5">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">