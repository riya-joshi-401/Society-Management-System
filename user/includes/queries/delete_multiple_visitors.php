<?php
// $allowed_roles = array("admin");
// if (isset($_SESSION['email']) && in_array($_SESSION['login_role'], $allowed_roles)) {
include_once '../../../config.php';
$data = json_decode(file_get_contents("php://input"), true);
if ($data['type'] == 'current') {

    $block = $_SESSION['blockno'];
    $flatno = $_SESSION['flatno'];
    
    // $flatno = 101; //remove it later
    // $block = 'A'; //remove it later
    
    $delete_data = $data['delete_data'];
    foreach ($delete_data as $key => $val) {
        
        // print_r($delete_data);
        $sql = "DELETE from visitors where BlockNumber='" . $block . "' AND FlatNumber=". $flatno ." AND VisitorName='" . $val['vname'] . "';";
        mysqli_query($con, $sql);
    }

}
// }