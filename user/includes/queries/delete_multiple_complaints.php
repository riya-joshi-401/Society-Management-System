<?php
// $allowed_roles = array("admin");
// if (isset($_SESSION['email']) && in_array($_SESSION['login_role'], $allowed_roles)) {
include_once '../../../config.php';
$data = json_decode(file_get_contents("php://input"), true);
if ($data['type'] == 'current') {

    $delete_data = $data['delete_data'];
    $flatno = $_SESSION['flatno'];
    // $flatno = 802;
    $block = $_SESSION['blockno'];
    // $block = 'A';
    // echo var_dump($delete_data);
    $count = 0;
    foreach ($delete_data as $key => $val) {

        if ($val['status'] == 'Unresolved') {
            // echo var_dump($val);
            $sql = "DELETE from complaints where RequestID=" . $val['record_id'] . " AND BlockNumber='" . $block . "' AND FlatNumber=" . $flatno . ";";
            // echo $sql;
            mysqli_query($con, $sql);
            $count++;
        }

    }

    echo $count;

}
// }