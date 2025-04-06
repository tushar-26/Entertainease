<?php
include_once "Database.php";
require 'vendor/autoload.php'; // Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['number'];
    $city = $_POST['city'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $filename = $_FILES['image']['name'];
    $location = 'admin/image/' . $filename;

    // Validate inputs
    if (empty($username) || empty($email) || empty($mobile) || empty($city) || empty($password) || empty($cpassword)) {
        $_SESSION['error'] = 'All fields are required.';
        header('Location: register_form.php');
        exit();
    }

    if ($password !== $cpassword) {
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: register_form.php');
        exit();
    }

    // Check if email already exists
    $check_email = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $_SESSION['error'] = 'Email already exists. Please use a different email.';
        header('Location: register_form.php');
        exit();
    }

    // Handle image upload
    if (!empty($filename)) {
        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
        $image_ext = array('jpg', 'png', 'jpeg', 'gif');

        if (in_array($file_extension, $image_ext)) {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $location)) {
                $_SESSION['error'] = 'Failed to upload image.';
                header('Location: register_form.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Invalid image format. Only JPG, PNG, JPEG, GIF are allowed.';
            header('Location: register_form.php');
            exit();
        }
    }

    // Generate OTP
    $otp = rand(100000, 999999);
    $otp_expiry = date("Y-m-d H:i:s", time() + 300); // OTP expires in 5 minutes

    // Store user data in session for verification
    $_SESSION['registration_data'] = [
        'username' => $username,
        'email' => $email,
        'mobile' => $mobile,
        'city' => $city,
        'password' => $password,
        'image' => $filename,
        'otp' => $otp,
        'otp_expiry' => $otp_expiry,
        'attempts' => 0
    ];

    // Send OTP via email
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'entertainease0@gmail.com';
        $mail->Password   = 'ommqrgddlpihvwph';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('entertainease0@gmail.com');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Entertainease Registration - OTP Verification';
        
        // Beautiful HTML email template
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f5f5f5;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                }
                .header {
                    background-color: #d32f2f;
                    color: white;
                    padding: 20px;
                    text-align: center;
                }
                .header h1 {
                    margin: 0;
                    font-size: 24px;
                }
                .content {
                    padding: 30px;
                    color: #333333;
                }
                .otp-box {
                    background-color: #f8f8f8;
                    border: 1px dashed #d32f2f;
                    padding: 15px;
                    text-align: center;
                    margin: 20px 0;
                    font-size: 24px;
                    font-weight: bold;
                    color: #d32f2f;
                    border-radius: 4px;
                }
                .footer {
                    background-color: #f5f5f5;
                    padding: 15px;
                    text-align: center;
                    font-size: 12px;
                    color: #777777;
                }
                .button {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #d32f2f;
                    color: white;
                    text-decoration: none;
                    border-radius: 4px;
                    margin-top: 15px;
                }
                .logo {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .logo img {
                    max-width: 150px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Welcome to Entertainease!</h1>
                </div>
                <div class="content">
                    <div class="logo">
                        <img src="logo.jpg" alt="Entertainease Logo">
                    </div>
                    <h2>Hello ' . htmlspecialchars($username) . ',</h2>
                    <p>Thank you for registering with Entertainease - your ultimate movie ticket booking platform!</p>
                    <p>To complete your registration, please enter the following OTP (One-Time Password) in the verification page:</p>
                    
                    <div class="otp-box">
                        ' . $otp . '
                    </div>
                    
                    <p>This OTP will expire in 5 minutes. If you didn\'t request this, please ignore this email.</p>
                    <p>We\'re excited to have you on board and look forward to helping you book your next movie experience!</p>
                    
                    <p>Best regards,<br>The Entertainease Team</p>
                </div>
                <div class="footer">
                    © ' . date('Y') . ' Entertainease. All rights reserved.
                </div>
            </div>
        </body>
        </html>
        ';

        $mail->AltBody = "Hello $username,\n\nThank you for registering with Entertainease!\n\nYour OTP is: $otp\n\nThis OTP will expire in 5 minutes.";

        $mail->send();
        
        // Redirect to OTP verification page
        header('Location: verify_otp.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header('Location: register_form.php');
        exit();
    }
}
?>