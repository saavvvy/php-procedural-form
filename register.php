<?php
$page_title = "Registration Form";
include("includes/header.php");
include("includes/navbar.php");
?>

<div class="form-body">
    <div class="containers" style="margin-top: 5rem; margin-bottom: 5rem;">
        <div class="forms">
            <div class="form login">
                <span class="title">Registration</span>

                <form action="code.php" method="POST">
                    <div class="input-field">
                        <input type="text" name="name" placeholder="Enter your name" required>
                        <i class="uil uil-user icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="tel" name="phone" placeholder="Enter your number" required>
                        <i class="uil uil-phone icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password" class="password" placeholder="Create your password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>

                    <!-- <div class="input-field">
                        <input type="password" name="confirm_password" class="password" placeholder="Confirm your password" required>
                        <i class="uil uil-lock icon"></i>
                    </div> -->

                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" id="signCheck">
                            <label for="signCheck" class="text">Remember Me!</label>
                        </div>

                        <a href="#" class="text">Forgot password?</a>
                    </div>

                    <div class="input-field button">
                        <!-- <input type="button" name="" value="Register Now"> -->
                        <button type="submit" name="register_btn">Register Now</button>
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">
                        Already a member?
                        <a href="login.php" class="text signup-link">Login</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>