<?php

include '../../../config.php';
// if(isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role']=="user")
// {
if (isset($_POST['addcomplaint-btn'])) {

    //define the form input variables and extract their values
    $ctype = mysqli_escape_string($con, $_POST['complaint_type']);
    $cdesc = mysqli_escape_string($con, $_POST['complaint_desc']);
    $timestamp = date("Y-m-d H:i:s");
    $added_by = $_SESSION['flatno'];
    // $added_by = '802';
    $contactno = $_SESSION['contactno'];
    $block = $_SESSION['blockno'];
    // $contactno = '9029996333';
    // $block = 'A';
    $admin_remark = "No remark";
    // echo "hi";
    //define the default status, 0- unresolved, 1-in progress, 2- resolved
    $query = "INSERT INTO `complaints`(`RequestID`, `ComplaintType`, `Description`,`BlockNumber`,`FlatNumber`, `ContactNumber`, `RaisedDate`, `AdminRemark`, `Status`, `ResolvedDate`, `updated_at`) VALUES ('','$ctype','$cdesc','$block','$added_by' ,'$contactno','$timestamp','$admin_remark','0','0','$timestamp')"; //add the insert query
    mysqli_query($con, $query);
    $_SESSION['success_message'] = "Complaint has been raised!";
    header("Location: ../../raise_complaint.php");
    exit();
} elseif (isset($_POST['update_complaints'])) {
    $ctype = mysqli_escape_string($con, $_POST['ctype_new']);
    $cdesc = mysqli_escape_string($con, $_POST['cdesc_new']);
    $recordID = mysqli_escape_string($con, $_POST['recordID']);
    $timestamp = mysqli_escape_string($con, $_POST['timestamp']);
    $flatno = $_SESSION['flatno'];
    $contact = $_SESSION['contactno'];
    $block = $_SESSION['blockno'];
    // $flatno = '802';
    // $contact = '9029996333';
    // $block = 'A';

    $row = mysqli_fetch_array(mysqli_query($con, "SELECT complaint_id from complainttypes where complaint_type='$ctype ' "));
    $cid = $row['complaint_id'];
    $query = "UPDATE complaints set ComplaintType= '$cid', Description='$cdesc ', updated_at='$timestamp ' where RequestID='$recordID' and BlockNumber='$block' and FlatNumber='$flatno' and ContactNumber='$contact'";
    //echo $query;
    mysqli_query($con, $query);
    exit();
} elseif (isset($_POST['delete_complaints'])) {

    $recordID = mysqli_escape_string($con, $_POST['record_id']);
    $flatno = $_SESSION['flatno'];
    $contact = $_SESSION['contactno'];
    $block = $_SESSION['blockno'];
    // $flatno = '802';
    // $contact = '9029996333';
    // $block = 'A';
    $status = mysqli_escape_string($con, $_POST['status']);
    if ($status == 'Unresolved') {
        $query = "DELETE from complaints where RequestID='$recordID' and BlockNumber='$block' and FlatNumber='$flatno' and ContactNumber=' $contact'";
        // echo $query;
        mysqli_query($con, $query);
        exit();
    } else {
        echo "Status_0";
    }
    exit();
}

// }