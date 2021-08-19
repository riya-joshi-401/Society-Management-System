<?php

include 'includes/shared/header.php';
include 'includes/shared/sidebar.php';
include 'includes/shared/topbar.php';

?>

<?php

$sql = "SELECT * from allotments where BlockNumber='{$_SESSION['blockno']}' and FlatNumber='{$_SESSION['flatno']}'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);
// now according to the login contact number, we have to get info from the db -> owner or rentee

if ($_SESSION['login_role'] == 'owner') {
    $name = $row['OwnerName'];
    $contact = $row['OwnerContactNumber'];
    $alternate_contact = $row['OwnerAlternateContactNumber'];
    $email = $row['OwnerEmail'];
    $membercount = $row['OwnerMemberCount'];
} else {
    $name = $row['RenteeName'];
    $contact = $row['RenteeContactNumber'];
    $alternate_contact = $row['RenteeAlternateContactNumber'];
    $email = $row['RenteeEmail'];
    $membercount = $row['RenteeMemberCount'];
}

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
                        <h4 class="font-weight-bold text-primary mb-5">Profile</h4>
                        <form action="includes/queries/user_profile.php" method="POST" name="profile_form">
                            <div class="form-group">
                                <label for="blockno" class="font-weight-bold">Block Number:</label>
                                <input type="text" class="form-control" name="blockno" id="blockno"
                                    value="<?php echo $_SESSION['blockno'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="flatno" class="font-weight-bold">Flat Number:</label>
                                <input type="text" class="form-control" name="flatno" id="flatno"
                                    value="<?php echo $_SESSION['flatno'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Name:</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $name ?>"
                                    id="name">
                            </div>

                            <div class="form-group">
                                <label for="contact" class="font-weight-bold">Contact Number:</label>
                                <input type="text" class="form-control" name="contact" id="contact"
                                    value="<?php echo $contact ?>">
                                <input type="hidden" name="con_old" value="<?php echo $contact ?>">
                            </div>

                            <div class=" form-group">
                                <label for="acontact" class="font-weight-bold">Alternate Contact Number:</label>
                                <input type="number" class="form-control" name="acontact" id="acontact"
                                    value="<?php echo $alternate_contact ?>">
                                <input type="hidden" name="alt_con_old" value="<?php echo $alternate_contact ?>">
                            </div>

                            <div class="form-group">
                                <label for="email" class="font-weight-bold">Email Address:</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="<?php echo $email ?>">
                            </div>

                            <div class="form-group">
                                <label for="members" class="font-weight-bold">Total Members:</label>
                                <input type="number" class="form-control" name="members" id="members"
                                    value="<?php echo $membercount ?>">
                            </div>

                            <input type="submit" class="btn btn-primary" value="Update" name="profile_submit">
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