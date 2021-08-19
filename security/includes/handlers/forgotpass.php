<?php
//session_start();
//echo"inside handlers forgotpass";
//print_r($_SESSION["isverified"]);


if (isset($_POST["newpass"]) && isset($_POST["renewpass"])) {
    $newpass = $_POST["newpass"];
    $renewpass = $_POST["renewpass"];
    $contactno = $_SESSION['contactno'];
    $timestamp = date("Y-m-d H:i:s");

    $db = mysqli_connect('localhost', 'root', '', 'sms') or
    die('Error connecting to MySQL server.');

    if($newpass!=$renewpass){
        echo "<script>alert('Re-entered new password does not match with the new password');</script>";
    }

    else{

        $sql = "UPDATE securitylogin inner join security on security.SecurityID=securitylogin.SecurityID SET securitylogin.Password='".md5($newpass)."' , securitylogin.updated_at='$timestamp' WHERE security.ContactNumber='$contactno';";
        //echo $sql;
        mysqli_query($db, $sql); 
        mysqli_close($db);  
        echo "<script>alert('Password changed sucessfully!');</script>";
        session_unset();
        echo'<script>window.location.replace("./index.html")</script>';
        

    }

}

?>