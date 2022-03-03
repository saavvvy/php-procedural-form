<?php
session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function resend_email_verify($name, $email, $verify_token)
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

    $mail->setFrom('svy1412@gmail.com', $name);
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Resend - Email Verification From Saviour";

    $email_template = "
        <h2>You have registered with Saviour</h2>
        <h5>Verify your Email Address to Login with the given Link below</h5>
        <br/><br/>
        <a href='http://localhost/procedural/verify-email.php?token=$verify_token'>Click Me</a>
    ";

    $mail->Body = $email_template;
    $mail->send();
    // echo 'Message has been sent';
}

if (isset($_POST['resend_email_verify_btn'])) {

    if (!empty(trim($_POST['email']))) {
        // get the email from the database
        $email = mysqli_real_escape_string($con, $_POST['email']);

        $checkemail_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $checkemail_query_run = mysqli_query($con, $checkemail_query);

        // if email exist or not, perform
        if (mysqli_num_rows($checkemail_query_run) > 0) {
            // after checking, get the particular email you want
            $row = mysqli_fetch_array($checkemail_query_run);

            // if email is not verified, perform
            if ($row['verify_status'] == "0") {
                // getting information from the database, reason might we since it is already created
                $name = $row['name'];
                $email = $row['email'];
                $verify_token = $row['verify_token'];

                resend_email_verify($name, $email, $verify_token);

                $_SESSION['status'] = "Verification Email link has been sent to your email.";
                header("Location: login.php");
                exit(0);
            } else {
                // means email is already verified
                $_SESSION['status'] = "Email already verified, Please Login.";
                header("Location: resend-email-verification.php");
                exit(0);
            }
        } else {
            // means email is not yet registered
            $_SESSION['status'] = "Email is not registered. Please Register now.";
            header("Location: register.php");
            exit(0);
        }
    } else {
        // means enter your email to proceed
        $_SESSION['status'] = "Please Enter The Email Field";
        header("Location: resend-email-verification.php");
        exit(0);
    }
}
