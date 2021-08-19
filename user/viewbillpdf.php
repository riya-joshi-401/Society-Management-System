<?php
include './includes/shared/header.php';
?>

<?php

if (isset($_GET['id'])) {

    $id = isset($_GET['id']) ? $_GET['id'] : "";

    $sql = "SELECT * from bill_queue where bill_id='$id'";
    $res = mysqli_query($con, $sql);

    $row = mysqli_fetch_assoc($res);

//try 1-doesnt work

// header('Content-Type:' . $row['filemime']);
    // header("Content-Disposition: inline; filename=filename.pdf");
    // @readfile($row['data']);

// echo $row['data'];

//try 2- doesnt work

// $file = "path_to_file";
    // $fp = fopen($file, "r");
    // header("Cache-Control: maxage=1");
    // header("Pragma: public");
    // header("Content-type: application/pdf");
    // header("Content-Disposition: inline; filename=" . $row['filename'] . "");
    // header("Content-Description: PHP Generated Data");
    // header("Content-Transfer-Encoding: binary");
    // // header('Content-Length:' . filesize($file));
    // ob_clean();
    // flush();

// $buff = fread("C:/xampp/htdocs/Society-Management-System/BillUploads/A-401-Mar 2021.pdf", 1024);
    // print $buff;

//try 3-works perfectly but downloads the pdf instead of opening in a new tab

    header('Pragma: public');
    header('Expires: 0');
    header('Content-Type: application/pdf');
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=' . $row['filename'] . '');
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Length' . filesize($row['data']));
    ob_clean();
    flush();
    readfile($row['data']);

    exit();
} else {
    echo "Bill id exist nahi karta!!!";
}

?>


<?php

include './includes/shared/scripts.php';

?>