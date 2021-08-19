<?php
//session_start();
//session_unset();
// print_r($_SESSION);
?>

<form method="POST" class="userForm p-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <div class="input-group">
            <span><i class="fa fa-key"></i></span>
            <input type="number" class="form-control forrm" name="otp" id="otp" placeholder="Enter your OTP">
        </div>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Verify" class="btn btn-block btn-black">
    </div>
</form>

<?php
include "includes/handlers/verify.php";
?>