<?php
include "user/includes/handlers/login.php";
?>

<form method="POST" class="userForm p-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <div class="input-group">
            <span><i class="fa fa-building"></i></span>
            <input type="text" class="form-control forrm" name="blockno" id="blockno"
                placeholder="Enter your Block Number" required>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span><i class="fa fa-building"></i></span>
            <input type="number" class="form-control forrm" name="flatno" id="flatno"
                placeholder="Enter your Flat Number" required>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span><i class="fa fa-phone"></i></span>
            <input type="number" class="form-control forrm" name="contactno" id="contactno"
                placeholder="Enter your Phone Number " required>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" name="usersubmit" value="Send OTP" class="btn btn-block btn-black">Send OTP</button>
    </div>
</form>