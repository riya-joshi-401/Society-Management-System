<?php

include '../../../config.php';

if (isset($_POST['update_bill'])) {

    $flatid = mysqli_escape_string($con, $_POST['flatid']);
    $recordid = mysqli_escape_string($con, $_POST['recordid']);
    $timestamp = mysqli_escape_string($con, $_POST['timestamp']);
    $bmonth = mysqli_escape_string($con, $_POST['bmonth']);
    $status_new = mysqli_escape_string($con, $_POST['status_new']);

    $sql = "UPDATE bills_paid set Status='$status_new', updated_at='$timestamp' where BillID='$recordid' and FlatID='$flatid'";
    mysqli_query($con, $sql);
}