<?php
session_start();
include('dbcon.php');

if (isset($_POST['login_now_btn'])) {
    // check if input field is empt or not
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        $login_query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";
        $login_query_run = mysqli_query($con, $login_query);

        // check if the email is existing or not, if it has been verified or not before allowing
        // if it is greater than 0, means it exists
        if (mysqli_num_rows($login_query_run) > 0) {
            // will fetch lots of rows throught out this page
            $row = mysqli_fetch_array($login_query_run);

            // this means if "verify_status" == 1, it is verified, you can log in
            if ($row['verify_status'] == "1") {
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'username' => $row['name'],
                    'phone' => $row['phone'],
                    'email' => $row['email']
                ];
                $_SESSION['status'] = "You Are Logged In Successfully";
                header("Location: dashboard.php");
                exit(0);
            } else {
                // means you have to verify email
                $_SESSION['status'] = "Please Verify your Email Address to Login";
                header("Location: login.php");
                exit(0);
            }
        } else {
            // check email or password
            $_SESSION['status'] = "Invalid Email or Password";
            header("Location: login.php");
            exit(0);
        }
    } else {
        // means you must fill in all fields to proceed
        $_SESSION['status'] = "All fields are Mandatory";
        header("Location: login.php");
        exit(0);
    }
}
