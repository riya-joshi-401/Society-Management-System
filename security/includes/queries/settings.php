<?php include("../../../config.php");?>

<?php 

if(isset($_POST['settings_submit']))
{
    echo "Hi";
    $old_pass = $_POST['curr_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_new_pass = $_POST['confirm_new_pass'];
    
    if($old_pass == '' || $new_pass =='' || $confirm_new_pass == ''){
        $_SESSION['error_message'] = "Fields can not be empty!";
        header("Location: ../../admin_settings.php");
        exit();
    }
    
    //check if old pass(current pass) is correct
    $check_sql = "SELECT * from securitylogin where Username='{$_SESSION['username']}';";
    $check_res = mysqli_query($con,$check_sql);
    $check_row = mysqli_fetch_assoc($check_res);

    //check if current password is correct
    if(md5($old_pass) != $check_row['Password']){
        $_SESSION['error_message'] = "That's not your current password!";
        header("Location: ../../security_settings.php");
        exit();
        echo "hello";
    }

    //check if new_pass == confirmed new pass
    if($new_pass != $confirm_new_pass){
        $_SESSION['error_message'] = "Passwords do not match!";
        header("Location: ../../security_settings.php");
        exit();
    }else{
        //update db me 
        $md5_new_pass = md5($new_pass);
        $sql = "UPDATE securitylogin set Password='$md5_new_pass' where Username='{$_SESSION['username']}'";
        mysqli_query($con,$sql);
        $_SESSION['success_message']='Success! Password Updated Successfully';
        header("Location: ../../security_settings.php");
        exit();
    }
}

?>