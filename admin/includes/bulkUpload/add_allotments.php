<?php
// include_once('../../verify.php');
include_once '../../../config.php';

$block = mysqli_escape_string($con, $_POST['block']);
$fno = mysqli_escape_string($con, $_POST['flat']);
$oname = mysqli_escape_string($con, $_POST['oname']);
$ocontact = mysqli_escape_string($con, $_POST['ocno']);
$oacontact = mysqli_escape_string($con, $_POST['oacno']);
$oemail = mysqli_escape_string($con, $_POST['oemail']);
$omembers = mysqli_escape_string($con, $_POST['omem']);
$isRent = 0;
$isRent = mysqli_escape_string($con, $_POST['isRent']);
$rname = mysqli_escape_string($con, $_POST['rname']);
$rcontact = mysqli_escape_string($con, $_POST['rcno']);
$racontact = mysqli_escape_string($con, $_POST['racno']);
$remail = mysqli_escape_string($con, $_POST['remail']);
$rmembers = mysqli_escape_string($con, $_POST['rmem']);
// $role = $_POST['role'];
$upload_constraint = mysqli_escape_string($con, $_POST['upload_constraint']);
$login_role = $_SESSION['role'];
$addedby = $_SESSION['username'];
// $login_role = 'admin';
// $addedby = "Admin1";
$file_name = $_FILES['Uploadfile']['name'];

$ext = pathinfo($_FILES["Uploadfile"]["name"])['extension'];

// $target_location = $base_dir . $file_name;
$rel_dir_path = "allotments";
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
$cmd = ' python addallotments.py "' . $addedby . '" " ' . $timestamp . '" "' . $fno . '" "' . $block . '" "' . $oname . '" "' . $oemail . '" "' . $ocontact . '" "' . $oacontact . '" "' . $omembers . '" "' . $isRent . '" "' . $rname . '" "' . $remail . '" "' . $rcontact . '" "' . $racontact . '" "' . $rmembers . '" "' . $servername . '" "' . $target_location . '" "' . $username . '" "' . $dbname . '" "' . $password . '" "' . $upload_constraint . '" "' . $login_role . '" ';
//echo $cmd;
$output = shell_exec($cmd);
echo $output;
//  if(strpos($output,"Duplicate entry")){
//     echo "Import Unsuccessful as adding caused duplicate entries";
// }else{
//     echo $output;
// }