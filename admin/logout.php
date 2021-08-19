<?php 
session_start();
//for admin
if(isset($_SESSION['username'])){
    //unset session;
    session_unset();
    //destroy session
    session_destroy();
    //redirect to login page.
    header("Location: ../login.php");
}

?>