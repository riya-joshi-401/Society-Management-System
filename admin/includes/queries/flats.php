<?php
include '../../../config.php';
if (isset($_POST["flat"])) {

    $fno = mysqli_real_escape_string($con, $_POST["fno"]);
    $floor = mysqli_real_escape_string($con, $_POST["floorno"]);
    $block = mysqli_real_escape_string($con, $_POST["block"]);
    //$flattype = mysqli_real_escape_string($con, $_POST["flattype"]);

    $queryy = "SELECT * from flats";
    $records = mysqli_query($con, $queryy);
    foreach ($records as $rec) {
        if ($rec["FlatNumber"] == $fno && $rec["BlockNumber"] == $block) {
            $_SESSION['error_message'] = "<strong>Failure!</strong> Record for this flat number already exists!";
            header("Location: ../../add_flat.php");
            //echo "flat number";
            $error = 1;
            break;
        } else {
            $error = 0;
        }
    }
    if (is_numeric($fno) && is_numeric($floor) && !is_numeric($block)) {
        if ($error == 0) {
            //extracting the flat series
            $flatseries = $fno - 100 * $floor;
            //checking if series present in flatarea table
            // $q = mysqli_query($con, "SELECT FlatSeries,BlockNumber from flatarea");
            // $recordd = mysqli_fetch_all($q);
            // $flag = 0;
            // foreach ($recordd as $r) {
            //     if ($r['FlatSeries'] == $flatseries && $r['BlockNumber'] == $block) {
            //         $flag = 1;
            //     }
            // }
            //if ($flag == 1) {
            $queryforeign = "SELECT * FROM `flatarea` WHERE (FlatSeries = $flatseries and BlockNumber = '$block')";
            $record = mysqli_query($con, $queryforeign);
            if ($record) {
                foreach ($record as $r) {
                    $flatareaid = $r["FlatAreaID"];
                    //$flatarea = $r["FlatArea"];
                    //$rate = $r["Ratepsq"];
                }

                //$maintenance = $flatarea * $rate;
                $query = "INSERT INTO flats(`FlatID`, `FlatNumber`, `BlockNumber`, `Floor`, `FlatAreaID`) VALUES ('' , '$fno','$block', '$floor', '$flatareaid')";
                mysqli_query($con, $query);
                $_SESSION['success_message'] = "<strong>Success!</strong> Flat record added successfully!";
                header("Location: ../../add_flat.php");
            } else {
                echo "no record";
            }
            // } else {
            //     $_SESSION['error_message'] = "<strong>Failure!</strong> Flat series not available!";
            //     header("Location: ../../add_flat.php");
            // }

            /**/
        }
    } else {
        $_SESSION['error_message'] = "<strong>Failure!</strong> Fields not correct";
        header("Location: ../../add_flat.php");
    }
}
if (isset($_POST['delete_flats'])) {
    $recordID = mysqli_escape_string($con, $_POST['record_id']);
    $sql1 = "DELETE FROM allotments WHERE FlatID='$recordID'";
    mysqli_query($con, $sql1);
    $sql2 = "DELETE FROM shoutbox WHERE FlatID='$recordID'";
    mysqli_query($con, $sql2);
    $sql3 = "DELETE FROM visitors WHERE FlatID='$recordID'";
    mysqli_query($con, $sql3);
    $sql4 = "DELETE FROM complaints WHERE FlatID='$recordID'";
    mysqli_query($con, $sql4);
    $sql = "DELETE FROM flats WHERE FlatID='$recordID'";
    mysqli_query($con, $sql);
    /*
    $sql = "DELETE FROM bills WHERE FlatID='$recordID'";
    mysqli_query($con, $sql);
    $sql = "DELETE FROM meetings WHERE FlatID='$recordID'";
    mysqli_query($con, $sql);
     */
    // header("Location: ../bla.php");
    exit();
}

if (isset($_POST['update_flats'])) {

    $block_new = mysqli_escape_string($con, $_POST['blockno_new']);
    $blockno_old = mysqli_escape_string($con, $_POST['blockno_old']);

    $flatnumber_new = mysqli_escape_string($con, $_POST['number_new']);
    $number_old = mysqli_escape_string($con, $_POST['number_old']);

    $floor_new = mysqli_escape_string($con, $_POST['floor_new']);
    $floor_old = mysqli_escape_string($con, $_POST['floor_old']);

    $recordID = mysqli_escape_string($con, $_POST['recordID']);
    //$flattype_new = mysqli_escape_string($con, $_POST['flattype_new']);
    //$flatareaid = mysqli_escape_string($con, $_POST['flatareaID']);
    $flatareaid_query = "SELECT FlatAreaID FROM `flatarea` WHERE (FlatSeries = ($flatnumber_new-100*$floor_new) and BlockNumber = '$block_new')";
    $flatareaid_sql = mysqli_query($con, $flatareaid_query);
    
    if(mysqli_num_rows($flatareaid_sql)==0){
        echo "Block_no_exist";
        exit();
    }
    $flatareaid_row = mysqli_fetch_assoc($flatareaid_sql);
    // echo $flatareaid_query;
    $flatareaid = $flatareaid_row['FlatAreaID'];
    // $added_by = $_SESSION['username'];
    $updated_at = date("Y-m-d H:i:s");

    if (($block_new == $blockno_old) && ($floor_new == $floor_old) && ($flatnumber_new == $number_old)) {
        //echo "Record exists. Change the value to update";
        echo "Exists_record";
        exit();
    } else {
        //if (is_numeric($fno) && is_numeric($floor) && !is_numeric($block)) {
        //}
        $check_query = "SELECT * from flats where BlockNumber='$block_new' AND FlatNumber='$flatnumber_new' AND Floor='$floor_new';";
        // echo $check_query;
        $check_result = mysqli_query($con, $check_query);
        // echo $block_new . "-" . $blockno_old;
        // echo mysqli_num_rows($check_result);
        if (mysqli_num_rows($check_result) != 0) {
            //echo $block_new . "-" . $blockno_old;
            echo "Exists_record";
            exit();
        } else {
            $sql = "UPDATE flats SET FlatNumber='$flatnumber_new',BlockNumber='$block_new',Floor='$floor_new',FlatAreaID='$flatareaid',updated_at='$updated_at' WHERE flatID='$recordID';";
            // echo $sql;
            mysqli_query($con, $sql);
            exit();
        }
    }
}
?>
<!-- -->