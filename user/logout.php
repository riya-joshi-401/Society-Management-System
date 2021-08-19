<?php 
session_start();
//for user
if(isset($_SESSION['flatno'])){
    //unset session;
    session_unset();
    //destroy session
    session_destroy();
    //redirect to login page.
    header("Location: ../login.php");
}

?>