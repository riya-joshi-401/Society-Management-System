<?php
// include_once('../../verify.php');
include_once '../../../config.php';

$fno = $_POST['fno'];
$floor = $_POST['floor'];
$block = $_POST['block'];

// $role = $_POST['role'];
$upload_constraint = mysqli_escape_string($con, $_POST['upload_constraint']);
// $login_role = $_SESSION['role'];
// $addedby = $_SESSION['username'];
$login_role = 'admin';
//$addedby = "Admin1";
$file_name = $_FILES['Uploadfile']['name'];

$ext = pathinfo($_FILES["Uploadfile"]["name"])['extension'];

// $target_location = $base_dir . $file_name;
$rel_dir_path = "flats";
$target_location_dir = $base_dir . $rel_dir_path;

if (!is_dir($base_dir)) {
    mkdir($base_dir, 0777, true);
}

if (!is_dir($target_location_dir)) {
    mkdir($target_location_dir, 0777, true);
}

$rel_file_path = $rel_dir_path . '/' . $file_name . "." . $ext;
$target_location = $base_dir . $rel_file_path;

move_uploaded_file($_FILES['Uploadfile']['tmp_name'], $target_location);
date_default_timezone_set('Asia/Kolkata');
$timestamp = date("Y-m-d H:i:s");

//echo $servername;
$cmd = 'python addflats.py "' . $timestamp . '" "' . $fno . '" "' . $floor . '" "' . $block . '" "' . $servername . '" "' . $target_location . '" "' . $username . '" "' . $password . '" "' . $dbname . '" "' . $upload_constraint . '" "' . $login_role . '" ';
//"' . $addedby . '" 
//echo $cmd;
$output = shell_exec($cmd);
echo $output;
//  if(strpos($output,"Duplicate entry")){
//     echo "Import Unsuccessful as adding caused duplicate entries";
// }else{
//     echo $output;
// }