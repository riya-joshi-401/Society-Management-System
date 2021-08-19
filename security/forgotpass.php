<?php
//session_start();
//session_unset();
// print_r($_SESSION);
?>

<form method="POST" class="userForm p-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <div class="input-group">
            <input type="password" class="form-control" name="newpass" id="newpass" placeholder="Enter new password">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <input type="password" class="form-control" name="renewpass" id="renewpass"
                placeholder="Re-enter new password">
        </div>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Change password" class="btn btn-block btn-primary">
    </div>
</form>

<?php
include "includes/handlers/forgotpass.php";
//print_r($_SESSION['otp']);
?>