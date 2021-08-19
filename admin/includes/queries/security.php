<?php

include '../../../config.php';

if (isset($_POST['addsecurity-btn'])) {

    //define the form input variables and extract their values
    $securityid = mysqli_escape_string($con, $_POST['SecurityID']);
    $name = mysqli_escape_string($con, $_POST['Name']);
    $contactnumber = mysqli_escape_string($con, $_POST['ContactNumber']);
    $shift = mysqli_escape_string($con, $_POST['Shift']);

    $timestamp = date("Y-m-d H:i:s");
    $added_by = $_SESSION['username'];
    // $added_by = 'admin1';

    //Fetching the SecurityID from Security table
    $fetch_query = "SELECT SecurityID from security where Name='" . $name . "' AND ContactNumber=" . $contactnumber . " AND Shift='" . $shift . "' ;";
    $result = mysqli_query($con, $fetch_query);
    $SecurityID = mysqli_fetch_array($result);

    $check_query = "SELECT * from security where SecurityID=" . $securityid . " AND Name='" . $name . "' AND ContactNumber=" . $contactnumber . " AND Shift='" . $shift . "' ;";
    $check_res = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_res) != 0) {
        $_SESSION['error_message'] = "<strong>Failure!</strong> Record for this SecurityID already exists!";
        header("Location: ../../add_security.php");
        exit();

    } else {
        // store in the database; check if error doesnt occur while storing
        $query = "INSERT INTO security(`SecurityID`,`Name`, `ContactNumber`,`Shift`,`updated_at`)
                  VALUES ('$securityid' ,'$name' , '$contactnumber' , ' $shift' , '$timestamp' )";

        echo "\n" . $query;
        echo "\n";
        if (mysqli_query($con, $query)) {
            echo "Security Guard Added successfully\n";
            //Start the session if already not started.
            $_SESSION['success_message'] = "<strong>Success!</strong> Security Guard added successfully!";

            // redirect to the form page again with success message or to the datatable page
            header("Location: ../../add_security.php");

            exit();

        } else {
            $_SESSION['error_message'] = "<strong>Failure!</strong>Could not able to execute the query!";
            header("Location: ../../add_security.php");
            exit();
            // echo "ERROR: Could not able to execute " .mysqli_error($con);
        }
    }
}

if (isset($_POST['delete_security'])) {
    //echo "<script>console.log('Entered delete security')</script>";
    $securityid = mysqli_escape_string($con, $_POST['security_id']);
    $sql = "DELETE FROM security WHERE SecurityID='$securityid'";
    //echo '<script>console.log('.$sql.')</script>';
    mysqli_query($con, $sql);
    // header("Location: ../bla.php");
    exit();
}

if (isset($_POST['update_security'])) {

    //echo "<script>console.log('Entered update security')</script>";
    $securityid = mysqli_escape_string($con, $_POST['security_id']);
    $name_new = mysqli_escape_string($con, $_POST['name_new']);
    $contactnumber_new = mysqli_escape_string($con, $_POST['contactnumber_new']);
    $shift_new = mysqli_escape_string($con, $_POST['shift_new']);
    // $added_by = 'Admin1';
    $added_by = $_SESSION['username'];
    $timestamp = date("Y-m-d H:i:s");

    $name_old = mysqli_escape_string($con, $_POST['name_old']);
    $contactnumber_old = mysqli_escape_string($con, $_POST['contactnumber_old']);
    $shift_old = mysqli_escape_string($con, $_POST['shift_old']);

    // if the admin is changing unique value constraints, we check if they already exist or not
    if (($name_new != $name_old) || ($contactnumber_new != $contactnumber_old) || ($shift_new != $shift_old)) {

        $check_query = "SELECT * from security where Name='$name_new' AND ContactNumber='$contactnumber_new';";
        $check_result = mysqli_query($con, $check_query);
        if (mysqli_num_rows($check_result) != 0) {
            echo "Exists_record";
            exit();
        } else {
            $sql = "UPDATE security
                    SET Name='$name_new', ContactNumber='$contactnumber_new',Shift = '$shift_new',
                    updated_at='$timestamp' WHERE SecurityID='$securityid';";

            mysqli_query($con, $sql);
            exit();
        }
    }
    //unique value constraints are not changing, so will be update it directly
    else {

        $sql = "UPDATE security
                    SET Name='$name_new', ContactNumber='$contactnumber_new',Shift = '$shift_new',
                    updated_at='$timestamp' WHERE SecurityID='$securityid';";
        // echo $sql;
        mysqli_query($con, $sql);
        exit();
    }

}
// }