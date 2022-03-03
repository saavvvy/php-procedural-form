<?php

session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token)
{
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'svy1412@gmail.com';
    $mail->Password   = 'dytnusllsjyyhbtw';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('svy1412@gmail.com', $get_name);
    $mail->addAddress($get_email);

    $mail->isHTML(true);
    $mail->Subject = "Email Verification From Saviour";

    $email_template = "
        <h2>You have registered with Saviour</h2>
        <h5>You are receving this email becasue we received a password reset request for your account.</h5>
        <br/><br/>
        <a href='http://localhost/procedural/password-change.php?token=$token&email=$get_email'>Click Me</a>
    ";

    $mail->Body = $email_template;
    $mail->send();
    // echo 'Message has been sent';
}

// GENERATE AND SEND NEW TOKEN FOR PASSWORD RESET
// if password_reset_link is clicked, perform
if (isset($_POST['password_reset_link'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = md5(rand()); // in order to generate a new token

    // retreive email from database
    $check_email = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
    $check_email_run = mysqli_query($con, $check_email);

    // check if email exists in the database or not
    if (mysqli_num_rows($check_email_run) > 0) {
        // gets the complete row of a user's information
        $row = mysqli_fetch_array($check_email_run);
        // these are the ones we need
        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_token = "UPDATE users SET verify_token = '$token' WHERE email = '$get_email' LIMIT 1";
        $update_token_run = mysqli_query($con, $update_token);

        if ($update_token_run) {
            send_password_reset($get_name, $get_email, $token);
            // fresh link was sent to your mail
            $_SESSION['status'] = "We emailed you a password reset link.";
            header("Location: password-reset.php");
            exit(0);
        } else {
            // there's an issue
            $_SESSION['status'] = "Something went wrong. #1.";
            header("Location: password-reset.php");
            exit(0);
        }
    } else {
        // no email was found or registered in the database
        $_SESSION['status'] = "No Email Found.";
        header("Location: password-reset.php");
        exit(0);
    }
}


// UPDATE THE PASSWORD IN THE DATABASE
if (isset($_POST['password_update'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($con, $_POST['password_token']);

    // if token sent to your email and shown in hidden in your updae form is available and not empty, perform
    if (!empty($token)) {
        // if the input boxes are empty(no data filled into them)
        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
            // check if token is valid or not
            $check_token = "SELECT verify_token FROM users WHERE verify_token = '$token' LIMIT 1";
            $check_token_run = mysqli_query($con, $check_token);

            // if new token exists in the database or not
            if (mysqli_num_rows($check_token_run) > 0) {
                // check if both passwords match
                if ($new_password == $confirm_password) {
                    // update new password into database
                    $update_password = "UPDATE users SET password = '$new_password' WHERE verify_token = '$token' LIMIT 1";
                    $update_password_run = mysqli_query($con, $update_password);

                    if ($update_password_run) {
                        // this is so that after using a token once, you cannot use it again, it has expired unless you generate another one

                        // the below code implies that immediately you use a token to change and update your password, the token changes automatically in the database, you cannot use it again unless you request for another one
                        $new_token = md5(rand()) . "saviour"; // concatenate with new_token if you want
                        $update_to_new_token = "UPDATE users SET verify_token = '$new_token' WHERE verify_token = '$token' LIMIT 1";
                        $update_to_new_token_run = mysqli_query($con, $update_to_new_token);

                        // update was successful
                        $_SESSION['status'] = "New Password Successfully Updated!";
                        header("Location: login.php");
                        exit(0);
                    } else {
                        // there was an issue while updating
                        $_SESSION['status'] = "Did not update Password! Something went wrong";
                        header("Location: password-change.php?token=$token&email=$email");
                        exit(0);
                    }
                } else {
                    // means that both passwords do not match
                    $_SESSION['status'] = "Password and Confirm Password Does not match";
                    header("Location: password-change.php?token=$token&email=$email");
                    exit(0);
                }
            } else {
                // means token does not exist
                $_SESSION['status'] = "Invalid Token";
                header("Location: password-change.php?token=$token&email=$email"); // reason for this is so that you dont lose your email and token when the page automatically refreshes at this point after not filling the boxes, cuz email and token are already filled 
                exit(0);
            }
        } else {
            // all boxes must be filled
            $_SESSION['status'] = "All fields are mandatory";
            header("Location: password-change.php?token=$token&email=$email"); // reason for this is so that you dont lose your email and token when the page automatically refreshes at this point after not filling the boxes, cuz email and token are already filled 
            exit(0);
        }
    } else {
        // means token is empty, remember the input hidden, means the link sent did not work properly
        $_SESSION['status'] = "No Token Available";
        header("Location: password-change.php");
        exit(0);
    }
}
