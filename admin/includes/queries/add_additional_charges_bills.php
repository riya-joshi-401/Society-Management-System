<?php
include '../../../config.php';
?>
<?php
// Adding charges for a particular flat 
if (isset($_POST['add_charges_single'])) {
    // echo "hi";
    $flat = mysqli_escape_string($con, $_POST['flatno']);
    $block = mysqli_escape_string($con, $_POST['blockno']);
    $flatid = mysqli_escape_string($con, $_POST['flat_id']);
    $bill_month = mysqli_escape_string($con, $_POST['bill_month']);
    $charges = mysqli_escape_string($con, $_POST['additional_charges']);
    $reason = mysqli_escape_string($con, $_POST['charges_reason']);
    $timestamp = date("Y-m-d H:i:s");
    $added_by = $_SESSION['username']; 

//check for flatid correct for the given flat
    $check_sql = mysqli_query($con, "SELECT FlatID from flats where FlatNumber='$flat' and BlockNumber='$block'");
    $check_row = mysqli_fetch_assoc($check_sql);
    $flatid_check = $check_row['FlatID'];
    //check if charges are greater than 0
    if ($charges <= 0) {
        $_SESSION['error_message'] = "Additional Charges cannot be negative";
        header("Location: ../../add_bills.php");
        exit();
    } elseif ($flatid != $flatid_check) {
        $_SESSION['error_message'] = "Flat does not exist";
        header("Location: ../../add_bills.php");
        exit();
    } else {
        $sql = "INSERT INTO additional_charges(`ChargeID`, `FlatID`, `Amount`, `Reason`, `Bill_month`, `Updated_at`, `Updated_by`) VALUES ('','$flatid','$charges','$reason','$bill_month','$timestamp','$added_by')";
        mysqli_query($con, $sql);

        $_SESSION['success_message'] = "Additional Charges for " . $block . '-' . $flat . ' inserted successfully!';
        header("Location: ../../add_bills.php");
        exit();
    }

}

if(isset($_POST['delete_charges'])){
    $recordID = mysqli_escape_string($con, $_POST['record_id']);
    $sql = "DELETE FROM additional_charges WHERE ChargeID='$recordID'";
    mysqli_query($con, $sql);
    // header("Location: ../bla.php");
    exit();
}

if (isset($_POST['update_charges'])){
    // echo "hi";
    $block_new = mysqli_escape_string($con, $_POST['blockno_new']);
    $block_old = mysqli_escape_string($con, $_POST['blockno_old']);
    $flat_new = mysqli_escape_string($con, $_POST['flatno_new']);
    $flat_old = mysqli_escape_string($con, $_POST['flatno_old']);
    $charges_new = mysqli_escape_string($con, $_POST['charges_new']);
    $charges_old = mysqli_escape_string($con, $_POST['charges_old']);
    $reason_new = mysqli_escape_string($con, $_POST['reason_new']);
    $reason_old = mysqli_escape_string($con, $_POST['reason_old']);
    $recordID = mysqli_escape_string($con, $_POST['recordID']);
    $timestamp = mysqli_escape_string($con, $_POST['timestamp']);

    //check if all the new fields arent empty
    if($block_new == '' || $flat_new == '' || $charges_new == '' || $reason_new == ''){
        echo "fieldsRequired_0";
        exit();
    }
    //if block or flat has changed
    if(($block_old != $block_new) || $flat_new != $flat_old){
        if(($block_new != $block_old) && ($flat_new == $flat_old)){
            //if only block has changed and flat is old, check if the flat record exists
            $c1sql = mysqli_query($con,"SELECT * from flats where BlockNumber='$block_new ' and FlatNumber='$flat_old'");
            if(mysqli_num_rows($c1sql)>0){
                //get the new flat id and update the record
                $c1row = mysqli_fetch_assoc($c1sql);
                $flatid = $c1row['FlatID'];
                $updatesql1 = "UPDATE additional_charges set FlatID='$flatid', Amount='$charges_new', Reason='$reason_new', Updated_by='{$_SESSION['username']}', Updated_at='$timestamp' where ChargeID='$recordID'";
                mysqli_query($con,$updatesql1);
                exit();
            }else{
                //echo error that flat does not exist
                echo "FlatExists_0";
                exit();
            }
        }
        if(($block_new == $block_old) && ($flat_new != $flat_old)){
            //if only flat has changed and block is old, check if flat record exists
            $c2sql = mysqli_query($con,"SELECT * from flats where BlockNumber=' $block_old' and FlatNumber='$flat_new'");
            if(mysqli_num_rows($c2sql)>0){
               //get the new flat id and update the record 
                $c2row = mysqli_fetch_assoc($c2sql);
                $flatid = $c2row['FlatID'];
                $updatesql2 = "UPDATE additional_charges set FlatID='$flatid', Amount='$charges_new', Reason='$reason_new', Updated_by='{$_SESSION['username']}', Updated_at='$timestamp' where ChargeID='$recordID'";
                mysqli_query($con,$updatesql2);
                exit();
            }else{
                //echo error that flat does not exist
                echo "FlatExists_0";
                exit();
            }
        }
        if(($block_new != $block_old) && ($flat_new != $flat_old)){
            //if both have changed, check if flat record exists
            $c3sql = mysqli_query($con,"SELECT * from flats where BlockNumber='$block_new' and FlatNumber='$flat_new'");
            if(mysqli_num_rows($c3sql)>0){
                //get the new flat id and update the record
                $c3row = mysqli_fetch_assoc($c3sql);
                $flatid = $c3row['FlatID'];
                $updatesql3 = "UPDATE additional_charges set FlatID='$flatid', Amount='$charges_new', Reason='$reason_new', Updated_by='{$_SESSION['username']}', Updated_at='$timestamp' where ChargeID='$recordID'";
                mysqli_query($con,$updatesql3);
                exit();
            }else{
                //echo error that flat does not exist
                echo "FlatExists_0";
                exit();
            }
        }
    }
    else{
        //if no flat or block has changed, only charges or reason has changed, then update directly
        $updatesql = "UPDATE additional_charges set Amount='$charges_new', Reason='$reason_new', Updated_by='{$_SESSION['username']}', Updated_at='$timestamp' where ChargeID='$recordID'";
        mysqli_query($con,$updatesql);
        exit();
    }
}

if(isset($_POST['addchargesall-btn'])){
    $bill_month = mysqli_escape_string($con, $_POST['bill_month']);
    $charges = mysqli_escape_string($con, $_POST['additional_charges']);
    $reason = mysqli_escape_string($con, $_POST['charges_reason']);
    $timestamp = date("Y-m-d H:i:s");
    $added_by = $_SESSION['username']; 
    
    if($bill_month == '' || $charges=='' || $reason==''){
        $_SESSION['error_message'] = "All the fields are required";
        header("Location: ../../add_bills.php");
        exit();
    }

    if($charges<=0){
        $_SESSION['error_message'] = "Additional Charges cannot be negative";
        header("Location: ../../add_bills.php");
        exit();
    }
    
    else{
    $get_flats_sql = mysqli_query($con,"SELECT * from flats");
    while($frow = mysqli_fetch_assoc($get_flats_sql)){
        
        $flatid = $frow['FlatID'];
        
        $sql = "INSERT INTO additional_charges(`ChargeID`, `FlatID`, `Amount`, `Reason`, `Bill_month`, `Updated_at`, `Updated_by`) VALUES ('','$flatid','$charges','$reason','$bill_month','$timestamp','$added_by')";
        mysqli_query($con, $sql);
    }
 
    $_SESSION['success_message'] = "Additional Charges for all the flats inserted successfully!";
    header("Location: ../../add_bills.php");
    exit();   
    }
}



?>