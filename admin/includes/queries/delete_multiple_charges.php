<?php
include_once '../../../config.php';
// $allowed_roles = array("admin");
// if (isset($_SESSION['email']) && in_array($_SESSION['role'], $allowed_roles)) {

$data = json_decode(file_get_contents("php://input"), true);
if ($data['type'] == 'current') {
    echo "hi";
    $delete_data = $data['delete_data'];
    // echo var_dump($delete_data);
    foreach ($delete_data as $key => $val) {
        // echo var_dump($val);
        $getflatid = mysqli_query($con, "SELECT FlatID from flats where FlatNumber='" . $val['flat'] . "' and BlockNumber='" . $val['block'] . "'");
        $getflatid_row = mysqli_fetch_assoc($getflatid);
        $flatid = $getflatid_row['FlatID'];

        $sql = "DELETE from additional_charges where FlatID='" . $flatid . "' AND Amount='" . $val['amount'] . "' AND Reason='" . $val['reason'] . "' AND Bill_month='" . $val['bmonth'] . "' AND Updated_at='" . $val['updatedat'] . "' AND Updated_by='" . $val['updatedby'] . "';";
        echo $sql;
        mysqli_query($con, $sql);
    }

}
// }