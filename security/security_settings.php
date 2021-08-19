<?php

include 'includes/shared/header.php';
//include //'includes/shared/sidebar.php';
include 'includes/shared/topbar.php';

?>


<!-- Begin Page Content -->
<div class="container-fluid">
    <?php
if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) {
    ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success_message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php
unset($_SESSION['success_message']);
}
?>

    <?php
if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
    ?>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error_message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php
unset($_SESSION['error_message']);
}
?>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow pt-1 pb-5">
                <div class="card-body">
                    <div class="col-12 mb-3">
                        <h4 class="font-weight-bold text-primary mb-5">Settings</h4>
                        <form action="includes/queries/settings.php" method="POST" name="settings_form">
                            <div class="form-group">
                                <label for="curr_pass" class="font-weight-bold mr-2">Current Password:</label>
                                <input type="password" class="form-control mr-2" name="curr_pass" id="curr_pass"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="new_pass" class="font-weight-bold">New Password:</label>
                                <input type="password" class="form-control" name="new_pass" id="new_pass" required>
                            </div>

                            <div class="form-group">
                                <label for="confirm_new_pass" class="font-weight-bold">Confirm Password:</label>
                                <input type="password" class="form-control" name="confirm_new_pass"
                                    id="confirm_new_pass" required>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Change" name="settings_submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /container-fluid -->



<?php

include './includes/shared/footer.php';
include './includes/shared/scripts.php';

?>