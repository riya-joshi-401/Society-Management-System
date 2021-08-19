<?php

include "config.php";
// for opening pdf in browser
$sql = "SELECT * from mimetry where id=13";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);
echo "<script>console.log({$row['file']})</script>";
// // print_r($row);
// header("Content-Type: application/pdf");
// header('Content-Disposition: inline; filename="Hello.pdf"');
// // header('Content-Transfer-Encoding: binary');
// header('Accept-Ranges: bytes');
// echo $row['file'];

// header('Content-type: application/pdf');
// header('Content-Disposition: inline; filename=name.pdf');
// header('Content-Transfer-Encoding: binary');
// header('Accept-Ranges: bytes');
// @readfile("data:application/pdf;base64,{$row['file']}");

header('Pragma: public');
header('Expires: 0');
header('Content-Type: application/pdf');
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename=hi.pdf');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Length' . filesize($row['file']));
ob_clean();
flush();
readfile($row['file']);
?>


<?php
//for downloading pdf
// header('Content-Description: File Transfer');
// header('Content-Type: application/octet-stream');
// header('Content-Disposition: attachment; filename= Hello.pdf');
// header('Expires: 0');
// header('Cache-Control: must-revalidate');
// header('Pragma: public');
// readfile('BillUploads/Hello.pdf');

?>