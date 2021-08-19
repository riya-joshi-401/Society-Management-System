<?php

include 'includes/shared/header.php';
//include //'includes/shared/sidebar.php';
include 'includes/shared/topbar.php';

?>
<?php
//print_r($_SESSION);
//session_start();
$uname = $_SESSION['username'];
//echo "$uname";
$sql1 = "SELECT SecurityID from securitylogin where Username = '$uname' ";
//,Username
$res1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_assoc($res1);
$id = $row1['SecurityID'];
//$uname = $row1['Username'];
$sql = "SELECT * from security where SecurityID = '$id' ";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);
$name = $row['Name'];
$contact = $row['ContactNumber'];
$shift = $row['Shift'];

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
                                <label for="uname" class="font-weight-bold">Username:</label>
                                <input type="text" class="form-control" name="uname" value="<?php echo $uname ?>"
                                    id="uname">
                                <input type="hidden" name="uname_old" value="<?php echo $uname ?>">
                                <input type="hidden" class="form-control" name="id" value="<?php echo $id ?>" id="id">
                            </div>

                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Name:</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $name ?>"
                                    id="name">
                            </div>

                            <div class="form-group">
                                <label for="contact" class="font-weight-bold">Contact Number:</label>
                                <input type="number" class="form-control" name="contact" id="contact"
                                    value="<?php echo $contact ?>">
                                <input type="hidden" name="con_old" value="<?php echo $contact ?>">
                            </div>

                            <div class="form-group">
                                <label for="shift" class="font-weight-bold">Shift:</label>
                                <select class="form-control" name="shift" id="shift">
                                    <option value="Morning" <?php $shift=='Morning' ? print("selected"): ""; ?>>Morning
                                    </option>
                                    <option value="Afternoon" <?php $shift=='Afternoon' ? print("selected"): ""; ?>>
                                        Afternoon </option>
                                    <option value="Evening" <?php $shift=='Evening' ? print("selected"): ""; ?>>Evening
                                    </option>
                                    <option value="Night" <?php $shift=='Night' ? print("selected"): ""; ?>>Night
                                    </option>
                                </select>
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