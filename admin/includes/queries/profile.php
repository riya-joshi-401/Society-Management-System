<?php include "../../../config.php";?>

<?php

if (isset($_POST['profile_submit'])) {
    $name = $_POST['a_name'];
    $username_old = $_POST['au_name_old'];
    $username_new = $_POST['au_name_new'];
    $contact = $_POST['a_contact'];
    $email = $_POST['a_email'];
    // echo $username_new;
    // echo $username_old;
    // echo $name;
    // echo $contact;
    // echo $email;

    if ($name == '' || $username_new == '' || $contact == '' || $email == '') {
        $_SESSION['error_message'] = "Fields can not be empty!";
        header("Location: ../../admin_profile.php");
        exit();
    }

    //check if old username != new username and if it is true then check if new username is unique or not, if not unique then redirect to profile with error message

    if ($username_new != $username_old) {
        $sql = "SELECT * from admin where Username='$username_new'";
        // echo "SQL1=" . $sql;
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) != 0) {
            $_SESSION['error_message'] = "Username already exists";
            header("Location: ../../admin_profile.php");
            exit();
        }
        $sql = "UPDATE admin set Name='$name',Username='$username_new',ContactNumber='$contact',EmailID='$email' where Username='$username_old';";
        // echo "<br>SQL2=" . $sql;
        mysqli_query($con, $sql);

        $_SESSION['username'] = $username_new;

        $sql2 = "UPDATE allotments set updated_by='$username_new' where updated_by='$username_old'"; //allotment updated_by
        $sql3 = "UPDATE flatarea set Updatedby='$username_new' where Updatedby='$username_old'"; //flatarea Updatedby
        mysqli_query($con, $sql2);
        mysqli_query($con, $sql3);

        $_SESSION['success_message'] = 'Success! Details Updated Successfully';
        header("Location: ../../admin_profile.php");
        exit();
    } else {
        $sql = "UPDATE admin set Name='$name',Username='$username_new',ContactNumber='$contact',EmailID='$email' where Username='$username_old';";
        // echo "<br>SQL3=" . $sql;
        mysqli_query($con, $sql);

        $_SESSION['username'] = $username_new;

        $sql2 = "UPDATE allotments set updated_by='$username_new' where updated_by='$username_old'"; //allotment updated_by
        $sql3 = "UPDATE flatarea set Updatedby='$username_new' where Updatedby='$username_old'"; //flatarea Updatedby
        $sql4 = "UPDATE additional_charges set Updated_by='$username_new' where Updated_by='$username_old'"; 
        mysqli_query($con, $sql2);
        mysqli_query($con, $sql3);
        mysqli_query($con, $sql4);
        
        $_SESSION['success_message'] = 'Success! Details Updated Successfully';
        header("Location: ../../admin_profile.php");
        exit();
    }
}

?>