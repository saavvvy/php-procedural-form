<?php
session_start();
$page_title = "Resend Email Verification";
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
                <span class="title">Resend Email Verification</span>

                <form action="resend-code.php" method="POST">
                    <div class="input-field">
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <i class="uil uil-envelope icon"></i>
                    </div>

                    <div class="input-field button">
                        <button type="submit" name="resend_email_verify_btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include("includes/footer.php");
?>