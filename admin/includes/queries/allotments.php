<?php

include '../../../config.php';
// if(isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role']=="admin")
// {
if (isset($_POST['addallotment-btn'])) {

    //define the form input variables and extract their values
    $block = mysqli_escape_string($con, $_POST['block']);
    $fno = mysqli_escape_string($con, $_POST['fno']);
    $oname = mysqli_escape_string($con, $_POST['oname']);
    $ocontact = mysqli_escape_string($con, $_POST['ocontact']);
    $oacontact = mysqli_escape_string($con, $_POST['oacontact']);
    $oemail = mysqli_escape_string($con, $_POST['oemail']);
    $omembers = mysqli_escape_string($con, $_POST['omembers']);
    $isRent = 0;
    // echo $_POST['isRent'];
    if (isset($_POST['isRent'])) {
        $isRent = mysqli_escape_string($con, $_POST['isRent']);
    }
    echo $isRent;
    // echo '<script>console.log($isRent)</script>';
    $rname = mysqli_escape_string($con, $_POST['rname']);
    $rcontact = mysqli_escape_string($con, $_POST['rcontact']);
    $racontact = mysqli_escape_string($con, $_POST['racontact']);
    $remail = mysqli_escape_string($con, $_POST['remail']);
    $rmembers = mysqli_escape_string($con, $_POST['rmembers']);
    $updated_at = date("Y-m-d H:i:s");
    $updated_by = $_SESSION['username'];
    // $updated_by = 'admin1';

    // echo "hi";

    $check_query = "SELECT * from allotments where BlockNumber='" . $block . "' AND FlatNumber=" . $fno . ";";
    $check_res = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_res) > 0) {
        $_SESSION['error_message'] = "<strong>Failure!</strong> Record already exists!";
        header("Location: ../../add_allotments.php");
        exit();
    } else {
        $res = mysqli_query($con, "SELECT FlatNumber from flats where FlatNumber = '$fno'");
        if (strlen($ocontact) != 10 || strlen($oacontact) != 10) {
            $_SESSION['error_message'] = "<strong>Failure!</strong> Contact number should be of length 10 !";
            header("Location: ../../add_allotments.php");
        } else if (!is_numeric($fno) && is_numeric($block)) {
            $_SESSION['error_message'] = "<strong>Failure!</strong> Flat Number or block invalid !";
            header("Location: ../../add_allotments.php");
        } else if (mysqli_num_rows($res) == 0) {
            $_SESSION['error_message'] = "<strong>Failure!</strong> Flat does not exist !";
            header("Location: ../../add_allotments.php");
        } else {
            $res2 = mysqli_query($con, "SELECT FlatID from flats where FlatNumber = '$fno'");
            $row2 = mysqli_fetch_assoc($res2);
            $flatid = $row2['FlatID'];
            if ($isRent == 1) {
                if (strlen($rcontact) != 10 || strlen($racontact) != 10) {
                    $_SESSION['error_message'] = "<strong>Failure!</strong> Contact number should be of length 10 !";
                    header("Location: ../../add_allotments.php");
                    exit();
                } else {
                    echo $isRent;

                    // store in the database; check if error doesnt occur while storing
                    $query = "INSERT INTO allotments(`AllotmentID`,`FlatID`,`FlatNumber`, `BlockNumber`, `OwnerName`, `OwnerEmail`, `OwnerContactNumber`, `OwnerAlternateContactNumber`, `OwnerMemberCount`,`isRent`, `RenteeName`, `RenteeEmail`, `RenteeContactNumber`, `RenteeAlternateContactNumber`, `RenteeMemberCount`,  `updated_by`, `updated_at`) VALUES ('' ,'$flatid','$fno', '$block' , '$oname', '$oemail', '$ocontact', '$oacontact','$omembers', '$isRent', '$rname', '$remail', '$rcontact', '$racontact','$rmembers','$updated_by','$updated_at')";
                    echo $query;
                    mysqli_query($con, $query);
                }
            } else {

                echo '<script>console.log($isRent)</script>';
                // store in the database; check if error doesnt occur while storing
                $query = "INSERT INTO allotments(`AllotmentID`,`FlatID`,`FlatNumber`, `BlockNumber`, `OwnerName`, `OwnerEmail`, `OwnerContactNumber`, `OwnerAlternateContactNumber`, `OwnerMemberCount`,`isRent`, `RenteeName`, `RenteeEmail`, `RenteeContactNumber`, `RenteeAlternateContactNumber`, `RenteeMemberCount`, `updated_by`, `updated_at`) VALUES ('' ,'$flatid','$fno', '$block' , '$oname', '$oemail', '$ocontact', '$oacontact','$omembers', '$isRent', '', '', '', '', '','$updated_by','$updated_at')";
                // echo '<script>console.log($query)</script>';
                mysqli_query($con, $query);
            }
            $_SESSION['success_message'] = "<strong>Success!</strong> Allotment added successfully!";

            // redirect to the form page again with success message or to the datatable page
            header("Location: ../../add_allotments.php");
            exit();
        }
    }
}

if (isset($_POST['delete_allotments'])) {
    $recordID = mysqli_escape_string($con, $_POST['record_id']);
    $sql = "DELETE FROM allotments WHERE AllotmentID='$recordID'";
    mysqli_query($con, $sql);
    // header("Location: ../bla.php");
    exit();
}

if (isset($_POST["update_allotments"])) {
    $block = mysqli_escape_string($con, $_POST['blockno_new']);
    $fno = mysqli_escape_string($con, $_POST['fno_new']);
    $isRent = mysqli_escape_string($con, $_POST['isRent']);
    $recordid = mysqli_escape_string($con, $_POST['recordID']);
    $oname = mysqli_escape_string($con, $_POST['oname_new']);
    $ocontact = mysqli_escape_string($con, $_POST['ocontact_new']);
    $oacontact = mysqli_escape_string($con, $_POST['oacontact_new']);
    $oemail = mysqli_escape_string($con, $_POST['oemail_new']);
    $omembers = mysqli_escape_string($con, $_POST['omembers_new']);

    $rname = $rcontact = $racontact = $remail = $rmembers = '';

    if ($isRent == '1') {
        $rname = mysqli_escape_string($con, $_POST['rname_new']);
        $rcontact = mysqli_escape_string($con, $_POST['rcontact_new']);
        $racontact = mysqli_escape_string($con, $_POST['racontact_new']);
        $remail = mysqli_escape_string($con, $_POST['remail_new']);
        $rmembers = mysqli_escape_string($con, $_POST['rmembers_new']);
    }
    // echo "Rname:" . $rname;

    $updated_by = mysqli_escape_string($con, $_POST['updated_by']);
    $timestamp = mysqli_escape_string($con, $_POST['timestamp']);

    $block_old = mysqli_escape_string($con, $_POST['blockno_old']);
    $fno_old = mysqli_escape_string($con, $_POST['fno_old']);
    $error_array = array(); // to push validation errors
    //check all the form validations, contact length, and email id and all

    //check for null fields
    if ($block == '' || $fno == '' || $oname == '' || $oemail == '' || $ocontact == '' || $oacontact == '' || $omembers == '') {

        array_push($error_array, "All the owner fields are required!<br>");
    }

    //check for owner contact
    if (strlen($ocontact) != 10 || strlen($oacontact) != 10) {
        array_push($error_array, "Owner's contact number is invalid!");
    }

    //check for owner email
    if (!filter_var($oemail, FILTER_VALIDATE_EMAIL)) {
        array_push($error_array, "Owner's email address is invalid!");
    }
    //check for rentee email and contact
    if ($isRent == '1') {
        if (strlen($rcontact) != 10 || strlen($racontact) != 10) {
            array_push($error_array, "Rentee's contact number is invalid!");
        }
        if (!filter_var($remail, FILTER_VALIDATE_EMAIL)) {
            array_push($error_array, "Rentee's email address is invalid!");
        }
        if ($remail == '' || $rname == '' || $rcontact == '' || $racontact == '' || $rmembers == '') {
            array_push($error_array, "All the rentee fields are required!");
        }
    }

    if (!empty($error_array)) {
        print_r("error_array#");
        echo implode(" ", $error_array);
        exit();
    }

    // if the admin is changing unique value constraints, we check if they already exist or not
    if (($block != $block_old) || ($fno != $fno_old)) {
        $check = "SELECT * from allotments where BlockNumber='$block' AND FlatNumber='$fno'";
        $check_res = mysqli_query($con, $check);
        if (mysqli_num_rows($check_res) != 0) {
            echo "Allotment_0"; //allotment record already exists
            exit();
        } else {
            //update karo db me
            $getflatid_query = "SELECT FlatID from flats where FlatNumber='" . $fno . "' and BlockNumber='" . $block . "'"; //get flat id
            $flat_res = mysqli_query($con, $getflatid_query);
            if (mysqli_num_rows($flat_res) != 0) { //check if the flat exists
                $row = mysqli_fetch_assoc($flat_res);
                $flatid = $row['FlatID'];
            } else {
                echo "Flat_0"; //flat doesnt exist
                exit();
            }

            $sql = "UPDATE allotments set FlatID='$flatid',FlatNumber='$fno',BlockNumber='$block',OwnerName='$oname',OwnerEmail='$oemail',OwnerContactNumber='$ocontact',OwnerAlternateContactNumber='$oacontact',OwnerMemberCount='$omembers',isRent='$isRent',RenteeName='$rname',RenteeEmail='$remail',RenteeContactNumber='$rcontact',RenteeAlternateContactNumber= '$racontact',RenteeMemberCount='$rmembers',updated_by='$updated_by',updated_at='$timestamp' WHERE AllotmentID='$recordid'";
            mysqli_query($con, $sql);
            exit();
        }
    } else {
        //update karo db me
        $getflatid_query = "SELECT FlatID from flats where FlatNumber='" . $fno . "' and BlockNumber='" . $block . "'"; //get flat id
        $flat_res = mysqli_query($con, $getflatid_query);
        if (mysqli_num_rows($flat_res) != 0) { //check if the flat exists
            $row = mysqli_fetch_assoc($flat_res);
            $flatid = $row['FlatID'];
        } else {
            echo "Flat_0"; //flat doesnt exist
            exit();
        }
        $sql = "UPDATE allotments set FlatID='$flatid',FlatNumber='$fno',BlockNumber='$block',OwnerName='$oname',OwnerEmail='$oemail',OwnerContactNumber='$ocontact',OwnerAlternateContactNumber='$oacontact',OwnerMemberCount='$omembers',isRent='$isRent',RenteeName='$rname',RenteeEmail='$remail',RenteeContactNumber='$rcontact',RenteeAlternateContactNumber= '$racontact',RenteeMemberCount='$rmembers',updated_by='$updated_by',updated_at='$timestamp' WHERE AllotmentID='$recordid'";
        // echo "<br>" . $sql;
        mysqli_query($con, $sql);
        exit();
    }

}