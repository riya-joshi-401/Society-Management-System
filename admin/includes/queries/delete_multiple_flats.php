<?php
include_once '../../../config.php';
// $allowed_roles = array("admin");
// if (isset($_SESSION['email']) && in_array($_SESSION['role'], $allowed_roles)) {

$data = json_decode(file_get_contents("php://input"), true);
if ($data['type'] == 'current') {
    $delete_data = $data['delete_data'];
    // echo var_dump($delete_data);
    foreach ($delete_data as $key => $val) {
        $s = "SELECT FlatID from flats where FlatNumber=" . $val['flatnumber'] . ";";
        $r = mysqli_query($con, $s);
        $row = mysqli_fetch_assoc($r);
        $recordID = $row['FlatID'];
        //echo var_dump($val);
        $sql1 = "DELETE FROM allotments WHERE FlatID='$recordID'";
        mysqli_query($con, $sql1);
        $sql2 = "DELETE FROM shoutbox WHERE FlatID='$recordID'";
        mysqli_query($con, $sql2);
        $sql3 = "DELETE FROM visitors WHERE FlatID='$recordID'";
        mysqli_query($con, $sql3);
        $sql4 = "DELETE FROM complaints WHERE FlatID='$recordID'";
        mysqli_query($con, $sql4);
        /*
        $sql = "DELETE FROM bills WHERE FlatID='$recordID'";
        mysqli_query($con, $sql);

        $sql = "DELETE FROM meetings WHERE FlatID='$recordID'";
        mysqli_query($con, $sql);
         */
        $sql = "DELETE from flats where BlockNumber='" . $val['block'] . "' AND FlatNumber=" . $val['flatnumber'] . ";";
        echo $sql;
        mysqli_query($con, $sql);
    }
}
// }