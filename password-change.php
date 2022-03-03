<?php
session_start();
$page_title = "Password Change";
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
                <span class="title">Password Change</span>

                <form action="password-reset-code.php" method="POST">
                    <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {
                                                                            echo $_GET['token'];
                                                                        } ?>">
                    <div class="input-field">
                        <!-- if email is set to get, echo get_email -->
                        <!-- this get_email is coming from the link created in the function from password-reset-code.php -->
                        <input type="email" name="email" value="<?php if (isset($_GET['email'])) {
                                                                    echo $_GET['email'];
                                                                } ?>" placeholder="Enter your email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" name="new_password" class="password" placeholder="Enter new password" required>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>

                    <div class="input-field">
                        <input type="password" name="confirm_password" class="password" placeholder="Confirm your password" required>
                        <i class="uil uil-lock icon"></i>
                    </div>

                    <div class="input-field button">
                        <button type="submit" name="password_update">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include("includes/footer.php");
?>