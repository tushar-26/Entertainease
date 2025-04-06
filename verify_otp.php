<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Check if registration data exists
if (!isset($_SESSION['registration_data'])) {
    header('Location: register_form.php');
    exit();
}

// Handle OTP verification
if (isset($_POST['verify'])) {
    $user_otp = $_POST['otp'];
    $registration_data = $_SESSION['registration_data'];
    
    // Check if OTP is expired
    if (strtotime($registration_data['otp_expiry']) < time()) {
        $error = "OTP has expired. Please request a new one.";
    } 
    // Check if OTP matches
    elseif ($user_otp == $registration_data['otp']) {
        // OTP verified - complete registration
        include_once "Database.php";
        
        $username = $registration_data['username'];
        $email = $registration_data['email'];
        $mobile = $registration_data['mobile'];
        $city = $registration_data['city'];
        $password = $registration_data['password'];
        $filename = $registration_data['image'];
        
        // Insert user into the database
        $insert_record = mysqli_query($conn, "INSERT INTO user (`username`, `email`, `mobile`, `city`, `password`, `image`, `verified`) VALUES ('$username', '$email', '$mobile', '$city', '$password', '$filename', 1)");
        
        if ($insert_record) {
            // Log the user in
            $_SESSION['uname'] = $username;
            $_SESSION['email'] = $email;
            
            // Clear registration data
            unset($_SESSION['registration_data']);
            
            // Redirect to index.php
            echo "<script>alert('Registration successful! Welcome to Entertainease.'); window.location.href='index.php';</script>";
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
    } else {
        // Increment attempt counter
        $_SESSION['registration_data']['attempts']++;
        
        if ($_SESSION['registration_data']['attempts'] >= 3) {
            $error = "Too many incorrect attempts. Please register again.";
            unset($_SESSION['registration_data']);
        } else {
            $error = "Invalid OTP. Please try again.";
        }
    }
}

// Handle OTP resend request
if (isset($_POST['resend'])) {
    require 'vendor/autoload.php';
    
    $registration_data = $_SESSION['registration_data'];
    
    // Generate new OTP
    $new_otp = rand(100000, 999999);
    $otp_expiry = date("Y-m-d H:i:s", time() + 300); // OTP expires in 5 minutes
    
    // Update session data
    $_SESSION['registration_data']['otp'] = $new_otp;
    $_SESSION['registration_data']['otp_expiry'] = $otp_expiry;
    $_SESSION['registration_data']['attempts'] = 0;
    
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
        $mail->addAddress($registration_data['email']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Entertainease - New OTP for Verification';
        $mail->Body    = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
                .header { background-color: #d32f2f; color: white; padding: 20px; text-align: center; }
                .content { padding: 30px; color: #333333; }
                .otp-box { background-color: #f8f8f8; border: 1px dashed #d32f2f; padding: 15px; text-align: center; margin: 20px 0; font-size: 24px; font-weight: bold; color: #d32f2f; border-radius: 4px; }
                .footer { background-color: #f5f5f5; padding: 15px; text-align: center; font-size: 12px; color: #777777; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Your New OTP</h1>
                </div>
                <div class="content">
                    <p>Hello ' . htmlspecialchars($registration_data['username']) . ',</p>
                    <p>Here is your new OTP for Entertainease registration:</p>
                    <div class="otp-box">' . $new_otp . '</div>
                    <p>This OTP will expire in 5 minutes.</p>
                    <p>If you didn\'t request this, please ignore this email.</p>
                </div>
                <div class="footer">
                    © ' . date('Y') . ' Entertainease. All rights reserved.
                </div>
            </div>
        </body>
        </html>
        ';
        $mail->AltBody = "Hello {$registration_data['username']},\n\nYour new OTP is: $new_otp\n\nThis OTP will expire in 5 minutes.";

        $mail->send();
        $success = "A new OTP has been sent to your email.";
    } catch (Exception $e) {
        $error = "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - Entertainease</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url('img/bg.png');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Arial', sans-serif;
        }
        .otp-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .otp-header {
            text-align: center;
            margin-bottom: 30px;
            color: #d32f2f;
        }
        .otp-header h2 {
            font-weight: bold;
        }
        .otp-form {
            margin-bottom: 20px;
        }
        .otp-input {
            text-align: center;
            font-size: 24px;
            letter-spacing: 5px;
        }
        .btn-verify {
            background-color: #d32f2f;
            color: white;
            width: 100%;
            padding: 10px;
            font-size: 18px;
            margin-top: 20px;
        }
        .btn-verify:hover {
            background-color: #b71c1c;
            color: white;
        }
        .resend-link {
            text-align: center;
            margin-top: 20px;
        }
        .error-message {
            color: #d32f2f;
            text-align: center;
            margin-bottom: 15px;
        }
        .success-message {
            color: #388e3c;
            text-align: center;
            margin-bottom: 15px;
        }
        .timer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="otp-container">
            <div class="otp-header">
                <h2><i class="fas fa-ticket-alt"></i> Entertainease Email Verification</h2>
                <p>Please enter the 6-digit OTP sent to your email</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form class="otp-form" method="POST" action="verify_otp.php">
                <div class="form-group">
                    <input type="text" class="form-control otp-input" name="otp" placeholder="Enter OTP" maxlength="6" required autofocus>
                </div>
                <button type="submit" name="verify" class="btn btn-verify">
                    <i class="fas fa-check"></i> Verify OTP
                </button>
            </form>
            
            <div class="timer" id="timer">
                OTP expires in: <span id="countdown">5:00</span>
            </div>
            
            <form method="POST" action="verify_otp.php">
                <div class="resend-link">
                    Didn't receive OTP? 
                    <button type="submit" name="resend" class="btn btn-link" style="color: #d32f2f;">
                        <i class="fas fa-sync-alt"></i> Resend OTP
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Countdown timer for OTP expiration
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            var interval = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(interval);
                    display.textContent = "Expired";
                    display.style.color = "#d32f2f";
                }
            }, 1000);
        }

        window.onload = function () {
            var fiveMinutes = 60 * 5; // 5 minutes in seconds
            var display = document.querySelector('#countdown');
            startTimer(fiveMinutes, display);
        };
    </script>
</body>
</html>