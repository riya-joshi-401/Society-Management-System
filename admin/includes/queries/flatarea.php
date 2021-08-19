<?php

include '../../../config.php';
// if(isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role']=="admin")
// {
if (isset($_POST['addflatarea-btn'])) {

    //define the form input variables and extract their values
    $block = mysqli_escape_string($con, $_POST['block']);
    $fseries = mysqli_escape_string($con, $_POST['series']);
    $ftype = mysqli_escape_string($con, $_POST['flattype']);
    $farea = mysqli_escape_string($con, $_POST['area']);
    $rate = mysqli_escape_string($con, $_POST['rate']);
    $timestamp = date("Y-m-d H:i:s");
    $added_by = $_SESSION['username'];
    // $added_by = 'admin1';

    // echo "hi";

    $check_query = "SELECT * from flatarea where BlockNumber='" . $block . "' AND FlatSeries=" . $fseries . ";";
    $check_res = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_res) != 0) {
        $_SESSION['error_message'] = "<strong>Failure!</strong> Record for this series and block already exists!";
        header("Location: ../../add_flat_area.php");
        exit();

    } else {
        // store in the database; check if error doesnt occur while storing
        $query = "INSERT INTO flatarea(`FlatAreaID`, `BlockNumber`, `FlatSeries`, `FlatArea`, `FlatType`, `Ratepsq` , `Updatedby`, `UpdatedAt`) VALUES ('' , '$block' , '$fseries' , '$farea' , '$ftype' , '$rate' , '$added_by' , '$timestamp' )";
        mysqli_query($con, $query);

        //Start the session if already not started.
        $_SESSION['success_message'] = "<strong>Success!</strong> Area added successfully!";

        // redirect to the form page again with success message or to the datatable page
        header("Location: ../../add_flat_area.php");
        exit();
    }
}

if (isset($_POST['delete_flatarea'])) {
    $recordID = mysqli_escape_string($con, $_POST['record_id']);
    $sql = "DELETE FROM flatarea WHERE FlatAreaID='$recordID'";
    mysqli_query($con, $sql);
    // header("Location: ../bla.php");
    exit();
}

if (isset($_POST['update_flatarea'])) {
    // echo "hi";
    $block_new = mysqli_escape_string($con, $_POST['blockno_new']);
    $series_new = mysqli_escape_string($con, $_POST['series_new']);
    $area_new = mysqli_escape_string($con, $_POST['area_new']);
    $rate_new = mysqli_escape_string($con, $_POST['rate_new']);
    $recordID = mysqli_escape_string($con, $_POST['recordID']);
    $flattype_new = mysqli_escape_string($con, $_POST['flattype_new']);
    // $added_by = 'Admin1';
    $added_by = $_SESSION['username'];
    $timestamp = date("Y-m-d H:i:s");
    $block_old = mysqli_escape_string($con, $_POST['blockno_old']);
    $series_old = mysqli_escape_string($con, $_POST['series_old']);

    // if the admin is changing unique value constraints, we check if they already exist or not
    if (($block_new != $block_old) || ($series_new != $series_old)) {

        $check_query = "SELECT * from flatarea where BlockNumber='$block_new' AND FlatSeries='$series_new';";
        // echo $check_query;
        $check_result = mysqli_query($con, $check_query);
        if (mysqli_num_rows($check_result) != 0) {
            echo "Exists_record";
        } else {
            $sql = "UPDATE flatarea SET BlockNumber='$block_new', FlatSeries='$series_new',FlatArea='$area_new',FlatType='$flattype_new',Ratepsq='$rate_new',Updatedby='$added_by',UpdatedAt='$timestamp' WHERE FlatAreaID='$recordID';";
            // echo $sql;
            mysqli_query($con, $sql);
            exit();
        }
    }
    //and agar exist nahi karta toh it will be unique and we can directly update
    else {
        $sql = "UPDATE flatarea SET BlockNumber='$block_new', FlatSeries='$series_new',FlatArea='$area_new',FlatType='$flattype_new',Ratepsq='$rate_new',Updatedby='$added_by',UpdatedAt='$timestamp' WHERE FlatAreaID='$recordID';";
        // echo $sql;
        mysqli_query($con, $sql);
        exit();
    }

}
// }