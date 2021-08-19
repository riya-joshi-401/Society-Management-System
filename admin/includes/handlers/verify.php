<?php

if(isset($_POST["otp"]))
{

if($_SESSION["otp"]==$_POST["otp"]){
                //print_r($_SESSION);
		//echo"<script>alert('Sucessfull login :) ');</script>";
		$_SESSION["otp"]=0;
		$_SESSION['role'] = "user";
        $_SESSION['isverified'] = "yes";
        echo'<script>window.location.replace("./forgotpass.php")</script>';
                
	}
	else{
            //print_r($_SESSION);
            echo"<script>alert('Entered OTP number is wrong :( ');</script>";
            $_SESSION['isverified'] = "";
            session_unset();
            echo'<script>window.location.replace("./././login.php")</script>';
	}

}

?>