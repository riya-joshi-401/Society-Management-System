<?php
include("../../../config.php");

if(isset($_POST['name']) && isset($_POST['shout']) && isset($_POST['date'])){
    
    $admin = mysqli_escape_string($con, $_POST['name']);
    $msg = mysqli_escape_string($con, $_POST['shout']);
    $date = mysqli_escape_string($con, $_POST['date']);

    $sql_query = "INSERT INTO shoutbox(Admin,FlatID,Chat,created_at) VALUES('$admin','','$msg','$date');";
    $res=mysqli_query($con,$sql_query);
}

?>