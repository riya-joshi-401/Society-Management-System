<?php

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

//echo $username;
    //echo $password;

    $db = mysqli_connect('localhost', 'root', '', 'sms') or
    die('Error connecting to MySQL server.');

    $query = "SELECT * FROM admin WHERE username= '{$username}'  and password = '" . md5($password) . "' ";
//echo $query;
    $result = mysqli_query($db, $query);

    if ($result) {

        $count = mysqli_num_rows($result);

        if ($count == 0) {
            echo "<script>alert('Invalid login credentials !');</script>";
            echo '<script>window.location.replace("../../../login.php")</script>';

        } else {
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["role"] = "admin";
            //print_r($_SESSION);

            // remember me

            if (!empty($_POST["rememberme"])) {
                setcookie("username", $_POST["username"], time() + 3600,'/'); // stored for 1 day
                setcookie("password", $_POST["password"], time() + 3600,'/'); // stored for 1 day
                //echo "Cookies are set";
            } else {
                setcookie("username", "", time()-3600,'/');
                setcookie("password", "", time()-3600,'/');
                //echo "Cookies are not  Set";
            }
            echo '<script>window.location.replace("../../index.php")</script>';

        }

    }

    mysqli_close($db);

}