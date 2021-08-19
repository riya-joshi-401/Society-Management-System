<?php

include '../../../config.php';
// $file = $_POST['file'];
$flatid = $_POST['flatid'];
$recordid = $_POST['recordid'];
$timestamp = $_POST['timestamp'];
$bill_month = $_POST['bmonth'];
$file_name = $_POST['receiptname'];
// $file_name = $_FILES['Uploadfile']['name'];

$ext = pathinfo($_FILES["Uploadfile"]["name"])['extension'];
// echo $file_name;
// echo "<br>";
// echo $ext;

$base_dir = 'C:/xampp/htdocs/Society-Management-System/ReceiptUploads/';

if (!is_dir($base_dir)) {
    mkdir($base_dir, 0777, true);
}

$rel_file_path = $file_name . "." . $ext;
$target_location = $base_dir . $rel_file_path;
// echo "<br>";
// echo $rel_file_path; //name of the pdf
// echo $_FILES['Uploadfile']['tmp_name'];
// echo "<br>";
// echo $target_location;
move_uploaded_file($_FILES['Uploadfile']['tmp_name'], $target_location);

$sql = "UPDATE bills_paid set Receipt='$target_location', ReceiptName='$rel_file_path' where BillID='$recordid' and FlatID='$flatid'";
mysqli_query($con, $sql);

echo "Successful";