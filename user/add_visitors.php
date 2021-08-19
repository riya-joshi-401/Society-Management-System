<?php

include 'includes/shared/header.php';
include 'includes/shared/sidebar.php';
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

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <h3 class="my-4">Visitors</h3>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card mt-2">
                <div class="card shadow pt-1 pb-5">
                    <div class="card-body">
                        <div class="col-12 mb-3">
                            <h4 class="font-weight-bold text-primary">Add Visitors</h4>
                        </div>
                        <!--Main Form section starts-->
                        <form action="includes/queries/visitors.php" method="POST" autocomplete="">
                            <div class="form-group">
                                <label for="block">Block:</label>
                                <input type="text" class="form-control" id="block" name="block"
                                    aria-describedby="blockHelp" value="<?php echo $_SESSION['blockno'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="fno">Flat no:</label>
                                <input type="text" class="form-control" id="fno" name="fno" aria-describedby="fnoHelp"
                                    value="<?php echo $_SESSION['flatno'] ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="name">Visitor Name:</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    aria-describedby="nameHelp" required>
                                <small id="nameHelp" class="form-text text-muted">Enter the visitor's name</small>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact No.:</label>
                                <input type="text" class="form-control" id="contact" name="contact"
                                    aria-describedby="contactHelp" required>
                                <small id="contactHelp" class="form-text text-muted">Enter the visitor's contact
                                    number</small>
                            </div>
                            <div class="form-group">
                                <label for="contact1">Alternate Contact No.:</label>
                                <input type="text" class="form-control" id="contact1" name="contact1"
                                    aria-describedby="contact1Help" required>
                                <small id="contact1Help" class="form-text text-muted">Enter the visitor's alternate
                                    contact number</small>
                            </div>
                            <div class="form-group">
                                <label for="people">Number of People:</label>
                                <input type="number" class="form-control" id="people" name="people"
                                    aria-describedby="peopleHelp">
                                <small id="peopleHelp" class="form-text text-muted">Enter the number of people</small>
                            </div>
                            <div class="form-group">
                                <label for="reasonToMeet">Reason to Meet:</label>
                                <textarea class="form-control" id="reasonToMeet" name="reasonToMeet"
                                    aria-describedby="reasonToMeetHelp" rows="3"></textarea>
                                <small id="reasonToMeetHelp" class="form-text text-muted">Enter the reason to
                                    meet</small>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="startDate">Start Date:</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate"
                                        aria-describedby="startDateHelp">
                                    <small id="startDateHelp" class="form-text text-muted">Enter the start date to
                                        visit</small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="duration">Duration:</label>
                                    <input type="number" class="form-control" id="duration" name="duration"
                                        aria-describedby="durationHelp">
                                    <small id="durationHelp" class="form-text text-muted">Enter the duration in days</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-themeblack" name='addvisitors-btn'>Add</button>
                            <button type="reset" class="btn btn-themeblack">Clear</button>
                        </form>
                        <!--Main Form section ends-->
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