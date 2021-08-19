<?php

include '../../../config.php';
// if(isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role']=="admin")
// {
if (isset($_POST['addsecurity-btn'])) {

    //define the form input variables and extract their values
    $securityid = mysqli_escape_string($con, $_POST['securityid']);
    $name = mysqli_escape_string($con, $_POST['name']);
    $contactnumber = mysqli_escape_string($con, $_POST['contactnumber']);
    $shift = mysqli_escape_string($con, $_POST['shift']);
    $timestamp = date("Y-m-d H:i:s"); // created at

    $check_query = "SELECT * from security where SecurityID='" . $securityid . "';";
    $check_res = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_res) != 0) {
        $_SESSION['error_message'] = "<strong>Failure!</strong> Record for this ID already exists!";
        header("Location: ../../add_security.php");
        exit();

    } else {
        // store in the database; check if error doesnt occur while storing
        $query = "INSERT INTO security(`SecurityID`, `Name`, `ContactNumber`, `Shift`,`created_at`,`updated_at`) VALUES ('$securityid' , '$name' , '$contactnumber' , '$shift' , '$timestamp','$timestamp' )";
        mysqli_query($con, $query);

        //Start the session if already not started.
        $_SESSION['success_message'] = "<strong>Success!</strong> Details added successfully!";

        // redirect to the form page again with success message or to the datatable page
        header("Location: ../../add_security.php");
        exit();
    }
}

// :)
//}