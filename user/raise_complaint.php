<?php include './includes/shared/header.php';?>

<?php include './includes/shared/sidebar.php';?>

<?php include './includes/shared/topbar.php';?>

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
    <h3 class="my-4">Complaints</h3>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title text-info mb-4">Raise a complaint</h4>
                    <form action="./includes/queries/raise_complaint.php" method="POST" autocomplete="OFF">
                        <div class="form-group">
                            <label for="complaint_type">Complaint Type:</label>
                            <select class="form-control" name="complaint_type" aria-describedby="typeHelp" required>
                                <option selected value='0'>Choose a complaint type</option>
                                <?php 
                                
                                $sql = "SELECT * from complainttypes";
                                $res = mysqli_query($con,$sql);
                                while($row = mysqli_fetch_array($res)){
                                    echo "<option value= '" .$row['complaint_id']. "'>" . $row['complaint_type'] . "</option>"; 
                                }
                                ?>
                            </select>
                            <small id="typeHelp" class="form-text text-muted">Select the Complaint Type</small>
                        </div>
                        <div class="form-group">
                            <label for="complaint_desc">Complaint Description:</label>
                            <textarea class="form-control" id="complaint_desc" name="complaint_desc"
                                placeholder="Enter complaint description...." rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-themeblack" name='addcomplaint-btn'>Add</button>
                        <button type="reset" class="btn btn-themeblack">Clear</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php include './includes/shared/footer.php';
include './includes/shared/scripts.php';
?>