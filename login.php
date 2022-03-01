<?php
session_start();
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

                <form action="#">
                    <div class="input-field">
                        <input type="email" placeholder="Enter your email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" class="password" placeholder="Enter your password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>

                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="logCheck">
                            <label for="logCheck" class="text">Remember Me!</label>
                        </div>

                        <a href="#" class="text">Forgot password?</a>
                    </div>

                    <div class="input-field button">
                        <button type="submit" name="login_now_btn" name="d">Register Now</button>
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