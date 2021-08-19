<?php include './includes/shared/header.php'; ?>
<?php include './includes/shared/sidebar.php'; ?>
<?php include './includes/shared/topbar.php'; ?>


<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mt-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h4 class="m-0 font-weight-bold text-primary">View Security Guards</h4>
                        </div>
                    </div>
                </div>

    <div class="container-fluid mt-3">
    <table class="table table-bordered" style="width:100%">
    <thead>
    <tr>
    <th>SecurityID</th>
    <th>Name</th>
    <th>ContactNumber</th>
    <th>Shift</th>
    </tr>
    </thead>
    <tbody>
    <!------php display part :) ------>
    <?php

    $query = "SELECT * FROM security";
    if ($result = mysqli_query($con, $query)) {

    $rowcount = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result)) {
    ?>
    <tr>
    <td><?php echo $row['SecurityID'];?></td>
    <td><?php echo $row['Name'];?></td>
    <td><?php echo $row['ContactNumber'];?></td>
    <td><?php echo $row['Shift'];?></td>
    </tr>
    <?php
    }
}
    ?>
    </tbody>
    </table>
</div>
<?php
include './includes/shared/footer.php';
include './includes/shared/scripts.php';
?>