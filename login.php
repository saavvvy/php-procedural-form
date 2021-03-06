<?php
session_start();

// if you are already logged in do not show the login page
if (isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "You are already Logged in!";
    header("Location: dashboard.php");
    exit(0);
}

$page_title = "Login Form";
include("includes/header.php");
include("includes/navbar.php");
?>

<div class="form-body">
    <div class="containers">
        <?php
        if (isset($_SESSION['status'])) {
        ?>
            <div class="alert alert-success">
                <h5><?= $_SESSION['status']; ?></h5>
            </div>
        <?php
            unset($_SESSION['status']);
        }
        ?>
        <div class="forms">
            <div class="form login">
                <span class="title">Login</span>

                <form action="logincode.php" method="POST">
                    <div class="input-field">
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password" class="password" placeholder="Enter your password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>

                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <!-- <input type="checkbox" id="logCheck">
                            <label for="logCheck" class="text">Remember Me!</label> -->
                            <a href="resend-email-verification.php" class="text">Resend verification</a>
                        </div>

                        <a href="password-reset.php" class="text">Forgot password?</a>
                    </div>

                    <div class="input-field button">
                        <button type="submit" name="login_now_btn">Register Now</button>
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">
                        Not a member?
                        <a href="register.php" class="text signup-link">Register</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include("includes/footer.php");
?>