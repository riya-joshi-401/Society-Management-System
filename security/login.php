<script src="vendor/jquery/login.js"></script>

<form method="POST" class="securityForm p-3" id="securityForm" action="security/includes/handlers/login.php">
    <div class="form-group">
        <div class="input-group">
            <span><i class="fa fa-user"></i></span>
            <input type="text" class="form-control forrm" name="uname" placeholder="Username" id="uname" required value="<?php
if (isset($_COOKIE["sec_username"])) {
    echo $_COOKIE["sec_username"];
} else {
    echo '';
}
?>">
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span><i class="fa fa-lock"></i></span>
            <input type="password" class="form-control forrm" name="passw" id="passw" placeholder="Password" required
                value="<?php
if (isset($_COOKIE["sec_password"])) {
    echo $_COOKIE["sec_password"];
} else {
    echo '';
}
?>">
            <i class="fa fa-eye" id="togglePass"></i>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col">
                <label class="rmme"><input type="checkbox" class="forrm" name="rme" id="rme"
                        <?php if (isset($_COOKIE["sec_username"])) {?> checked <?php }?>> Remember me</label>
            </div>
            <div class="col text-right">
                <a class="rmme" href="#" data-toggle="modal" data-target="#forgotPassword">Forgot Password?</a>
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="submit" name="securitysubmit" value="Login" class="btn btn-block btn-black">
    </div>
</form>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" id="forgotpasswordForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Forgot Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter user name</label>
                        <input type="text" name="username" id="username" class="form-control"
                            placeholder="Enter the user name..." required>
                    </div>
                    <div class="form-group">
                        <label>Enter Contact number</label>
                        <input type="number" name="contactno" id="contactno" class="form-control"
                            placeholder="Enter your contact number..." required>
                    </div>
                    <div class="form-group">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="forgotPass" class="btn btn-black"><i class="fa fa-phone"
                            style="margin-right: 2px;"></i> Send
                        OTP</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include 'security/includes/handlers/otp.php';
?>

<script>
const togglePass = document.querySelector('#togglePass');
const passw = document.querySelector('#passw');
togglePass.addEventListener('click', function(e) {
    // toggle the type attribute
    const type = passw.getAttribute('type') === 'password' ? 'text' : 'password';
    passw.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
</script>