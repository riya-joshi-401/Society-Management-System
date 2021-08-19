<?php
session_start();
//echo md5("password"); 5f4dcc3b5aa765d61d8327deb882cf99
if(isset($_POST["uname"]) && isset($_POST["passw"]))
{
//echo $username;
//echo $password;

$db = mysqli_connect('localhost','root','','sms') or 
die('Error connecting to MySQL server.');
$username = mysqli_escape_string($db,$_POST["uname"]);
$password = mysqli_escape_string($db,$_POST["passw"]);

$query = "SELECT * FROM securitylogin WHERE Username= '{$username}'  and Password = '".md5($password)."' ";
//echo $query;
$result = mysqli_query($db, $query);


if($result)
{

$count=mysqli_num_rows($result);

	if($count==0) {
		echo"<script>alert('Invalid login credentials !');</script>";
        echo '<script>window.location.replace("../../../login.php")</script>';
                
	} else {
		$_SESSION["username"] =  $username;
		$_SESSION["login_role"] = "security";
		$q = mysqli_fetch_assoc($result);
		$id = $q['SecurityID'];
		$result1 = mysqli_query($db, "SELECT Name FROM security WHERE SecurityID='$id'");
		$query1 = mysqli_fetch_assoc($result1);
		$_SESSION["name"] =  $query1['Name'];
        if(!empty($_POST["rme"])) {
			setcookie ("sec_username",mysqli_escape_string($db,$_POST["uname"]),time()+ 3600,'/'); // stored for 1 day
			setcookie ("sec_password",mysqli_escape_string($db,$_POST["passw"]),time()+ 3600,'/'); // stored for 1 day
			//echo "Cookies are set";
		} 
        else {
			setcookie("sec_username","", time()-3600,'/');
			setcookie("sec_password","", time()-3600,'/');
			//echo "Cookies are not  Set";
		}
		// echo $_COOKIE['sec_username'];
        echo '<script>window.location.replace("../../index.php")</script>';
        
	}

}
mysqli_close($db);

}?>