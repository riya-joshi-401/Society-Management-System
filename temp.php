<?php

include "config.php";

require 'PdfUtils/vendor/autoload.php';
use Dompdf\Dompdf;

$pdf = new Dompdf();
$file_name = 'BillUploads/Hello.pdf';
$html_code = '<link rel="stylesheet" href="bootstrap.min.css">';
$html_code .= '<div class="text-danger">Hello </div>';
$pdf->load_html($html_code);
$pdf->render();
$file = $pdf->output();
file_put_contents($file_name, $file);

$sql = "INSERT into mimetry (`id`, `file`) VALUES ('','$file_name')";
mysqli_query($con, $sql);
echo "Inserted Successfully";