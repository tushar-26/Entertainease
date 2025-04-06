<?php
session_start();
require 'Database.php';
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email' AND password='$password'");
    
    if(mysqli_num_rows($result) == 0) {
        echo "<li>Invalid email or password!</li>";
        exit;
    }

    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['admin_otp'] = $otp;
    $_SESSION['admin_otp_expiry'] = time() + 300; // 5 minutes
    $_SESSION['admin_email'] = $email;

    // Send OTP via email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'entertainease0@gmail.com';
        $mail->Password = 'ommqrgddlpihvwph';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('entertainease0@gmail.com');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Admin Login OTP Verification';
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
            <div style="text-align: center; background-color: #dc3545; padding: 20px; border-radius: 10px 10px 0 0;">
                <h2 style="color: white; margin: 0;">Entertainease Admin Verification</h2>
            </div>
            <div style="padding: 30px 20px;">
                <p style="font-size: 16px;">Your one-time verification code is:</p>
                <div style="font-size: 32px; letter-spacing: 5px; background-color: #f8d7da; padding: 15px; border-radius: 5px; text-align: center; margin: 20px 0;">
                    '.$otp.'
                </div>
                <p style="font-size: 14px; color: #666;">This code will expire in 5 minutes. Do not share this code with anyone.</p>
            </div>
            <div style="background-color: #f5f5f5; padding: 15px; text-align: center; border-radius: 0 0 10px 10px;">
                <p style="margin: 0; font-size: 12px; color: #666;">© '.date('Y').' Entertainease. All rights reserved.</p>
            </div>
        </div>';

        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo "<li>Failed to send OTP. Please try again.</li>";
    }
}
?>