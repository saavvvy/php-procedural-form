<?php
include('authentication.php');
$page_title = "Dashboard";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5 bg-primary min-vh-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="display-3">User Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <h4 class="display-5">Accees when you are LOGGED IN</h4>
                        <hr>
                        <h5>Username: <?= $_SESSION['auth_user']['username']; ?></h5>
                        <h5>Email: <?= $_SESSION['auth_user']['email']; ?></h5>
                        <h5>Phone No: <?= $_SESSION['auth_user']['phone']; ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>