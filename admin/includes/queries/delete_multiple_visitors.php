<?php
include_once '../../../config.php';
// $allowed_roles = array("admin");
// if (isset($_SESSION['email']) && in_array($_SESSION['role'], $allowed_roles)) {

$data = json_decode(file_get_contents("php://input"), true);
if ($data['type'] == 'current') {

    $delete_data = $data['delete_data'];
    // print_r($delete_data);
    foreach ($delete_data as $key => $val) {

        $enddate = date('Y-m-d', strtotime($val['startdate']. ' + ' . $val['duration'] .'day'));
        $todaysDate = date("Y-m-d");
    
        if (strtotime($enddate) > strtotime($todaysDate)){
            $sql = "DELETE from visitors where BlockNumber='" . $val['block'] . "' AND FlatNumber=" . $val['flatno'] . " AND VisitorName='" . $val['vname'] . "';";
            // echo '<script>console.log('.$sql.')</script>';
            mysqli_query($con, $sql);
            
        }

    }

}
// }