<?php
session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token)
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
    $mail->Subject = "Email Verification From Saviour";

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

if (isset($_POST['register_btn'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify_token = md5(rand()); // will generate integers and alphabets to be merged up

    // sendemail_verify("$name", "$email", "$verify_token");
    // echo "sent or not ?";

    // Check if email already exists in the database or not
    $check_email_query = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    // if the above condition is not successful, cannot add to database. redirect to register.php, if else add to database
    if (mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['status'] = "Email ID already exists";
        header("Location: register.php");
    } else {
        // insert new users into the database
        // $encpassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (name,phone,email,password,verify_token) VALUES ('$name', '$phone', '$email', '$password', '$verify_token')";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            // if query is successful, send the below message
            sendemail_verify("$name", "$email", "$verify_token");
            $_SESSION['status'] = "Registration successful. Please verify your email address!";
            header("Location: register.php");
        } else {
            // if it is not go back to register.php
            $_SESSION['status'] = "Registration Failed!";
            header("Location: register.php");
        }
    }
}
