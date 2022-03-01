<?php
session_start();
include('dbcon.php');

// this token is gotten from the url bar using the $_GET[] method 
if (isset($_GET['token'])) { // if click here from email is clicked, perform
    // check if clicked token exists in the database
    $token = $_GET['token'];
    $verify_query = "SELECT verify_token, verify_status FROM users WHERE  verify_token = '$token' LIMIT 1"; // select both verify_token and verify_status
    $verify_query_run = mysqli_query($con, $verify_query);

    // if it exists, after being clicked, update verify_status in the database table from 0 to 1
    if (mysqli_num_rows($verify_query_run) > 0) {
        $row = mysqli_fetch_array($verify_query_run);
        // after token has been confirmed, update verify_status from 0 to 1
        if ($row['verify_status'] == "0") {
            $clicked_token = $row['verify_token']; // this row is being accessed from the $row = mysqli_fetch_array() above
            $update_query = "UPDATE users SET verify_status = '1' WHERE verify_token = '$clicked_token' LIMIT 1";
            $update_query_run = mysqli_query($con, $update_query);

            // if above query is a success 
            if ($update_query_run) {
                // show success
                $_SESSION['status'] = "Your Account has been Verified Successfully!";
                header("Location: login.php");
                exit(0);
            } else {
                // means it failed
                $_SESSION['status'] = "Verification Failed!";
                header("Location: login.php");
                exit(0);
            }
        } else {
            // means that email has already been verified, please login
            $_SESSION['status'] = "Email Already Verified! Please Login";
            header("Location: login.php");
            exit(0);
        }
    } else {
        // means token that was clicked does not exist and wasn't created by my code
        $_SESSION['status'] = "This Token does not Exist";
        header("Location: login.php");
    }
} else {
    // means your token isn't available
    $_SESSION['status'] = "Not Allowed";
    header("Location: login.php");
}
