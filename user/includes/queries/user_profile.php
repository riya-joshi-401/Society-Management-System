<?php

include '../../../config.php';

if (isset($_POST['profile_submit'])) {

    $name = mysqli_escape_string($con, $_POST['name']);
    $contact = mysqli_escape_string($con, $_POST['contact']);
    $con_old = mysqli_escape_string($con, $_POST['con_old']);
    $alt_con_old = mysqli_escape_string($con, $_POST['alt_con_old']);
    $altcontact = mysqli_escape_string($con, $_POST['acontact']);
    $email = mysqli_escape_string($con, $_POST['email']);
    $members = mysqli_escape_string($con, $_POST['members']);

//validate for blank fields
    if ($name == '' || $contact == '' || $altcontact == '' || $email == '' || $members == '') {
        $_SESSION['error_message'] = "Error! All the fields are required!";
        header("Location: ../../user_profile.php");
        exit();
    }
//validate contact length
    if (strlen($contact) != 10 || strlen($altcontact) != 10) {
        $_SESSION['error_message'] = "Error! Contact number exceeds 10!";
        header("Location: ../../user_profile.php");
        exit();
    }

//validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Error! Invalid Email Address!";
        header("Location: ../../user_profile.php");
        exit();
    }

//validate members->numeric and non zero
    if (!preg_match("/^[0-9]+$/", $members) || $members <= 0) {
        $_SESSION['error_message'] = "Error! Invalid number of members!";
        header("Location: ../../user_profile.php");
        exit();
    }

//if no error, update in allotments

    if ($_SESSION['login_role'] == 'owner') {
        $sql = "UPDATE allotments set OwnerName='$name',OwnerEmail='$email',OwnerContactNumber='$contact',OwnerAlternateContactNumber='$altcontact',OwnerMemberCount='$members' where BlockNumber='{$_SESSION['blockno']}' and FlatNumber='{$_SESSION['flatno']}';";
        mysqli_query($con, $sql);
        if ($_SESSION['contactno'] == $con_old) {
            $_SESSION['contactno'] = $contact;
        }
        if ($_SESSION['contactno'] == $alt_con_old) {
            $_SESSION['contactno'] = $altcontact;
        }
        $_SESSION['success_message'] = 'Success! Profile updated successfully';
        header("Location: ../../user_profile.php");
        exit();
    } else {
        $sql = "UPDATE allotments set RenteeName='$name',RenteeEmail='$email',RenteeContactNumber='$contact',RenteeAlternateContactNumber='$altcontact',RenteeMemberCount='$members' where BlockNumber='{$_SESSION['blockno']}' and FlatNumber='{$_SESSION['flatno']}';";
        mysqli_query($con, $sql);
        if ($_SESSION['contactno'] == $con_old) {
            $_SESSION['contactno'] = $contact;
        }
        if ($_SESSION['contactno'] == $alt_con_old) {
            $_SESSION['contactno'] = $altcontact;
        }
        $_SESSION['success_message'] = 'Success! Profile updated successfully';
        header("Location: ../../user_profile.php");
        exit();
    }

}