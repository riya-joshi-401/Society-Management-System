<?php
include_once '../../../config.php';
// $allowed_roles = array("admin");
// if (isset($_SESSION['email']) && in_array($_SESSION['role'], $allowed_roles)) {

$data = json_decode(file_get_contents("php://input"), true);
if ($data['type'] == 'current') {
    echo "<script>console.log('blah multiple')</script>";
    $delete_data = $data['delete_data'];
    echo '<script>console.log(' . $delete_data . ')</script>';
    foreach ($delete_data as $key => $val) {

        print_r($delete_data);

        // $sql = "DELETE from security where Name='" . $val['Name'] . "'
        // AND ContactNumber= " $val['ContactNumber']  " AND Shift='" . $val['Shift'] . "';";
        $sql = "DELETE from security where Name='" . $val['Name'] . "' AND SecurityID=" . $val['SecurityID'] . ";";
        echo '<script>console.log(' . $sql . ')</script>';
        mysqli_query($con, $sql);
    }

}
// }