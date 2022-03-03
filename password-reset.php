<?php
session_start();
$page_title = "Password Reset";
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
                <span class="title">Password Reset</span>

                <form action="password-reset-code.php" method="POST">
                    <div class="input-field">
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>

                    <div class="input-field button">
                        <button type="submit" name="password_reset_link">Send Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include("includes/footer.php");
?>