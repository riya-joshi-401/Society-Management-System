<?php

include '../../../config.php';

if (isset($_POST['profile_submit'])) {
    $id =  mysqli_escape_string($con, $_POST['id']);
    $uname = mysqli_escape_string($con, $_POST['uname']);
    $uname_old = mysqli_escape_string($con, $_POST['uname_old']);
    $name = mysqli_escape_string($con, $_POST['name']);
    $contact = mysqli_escape_string($con, $_POST['contact']);
    $con_old = mysqli_escape_string($con, $_POST['con_old']);
    $shift = mysqli_escape_string($con, $_POST['shift']);

//validate for blank fields
    if ($uname == '' || $name == '' || $contact == '' || !isset($shift)) {
        $_SESSION['error_message'] = "Error! All the fields are required!";
        header("Location: ../../user_profile.php");
        exit();
    }
//validate contact length
    if (strlen($contact) != 10) {
        $_SESSION['error_message'] = "Error! Contact number exceeds 10!";
        header("Location: ../../user_profile.php");
        exit();
    }

//if no error, update

    //if ($_SESSION['login_role'] == 'security') {
        $sql = "UPDATE securitylogin set Username = '$uname' where SecurityID = '$id'";
        mysqli_query($con, $sql);
        if ($_SESSION['username'] == $uname_old) {
            echo "$uname";
            $_SESSION['username'] = $uname;
        }
        $sql1 = "UPDATE security set Name = '$name', ContactNumber = '$contact, Shift = '$shift where SecurityID = '$id'";
        mysqli_query($con, $sql1);
        /* if ($_SESSION['contactno'] == $alt_con_old) {
            $_SESSION['contactno'] = $altcontact;
        } */
        $_SESSION['success_message'] = 'Success! Profile updated successfully';
        header("Location: ../../user_profile.php");
        exit();
    //}
}