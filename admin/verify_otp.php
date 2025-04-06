<?php
session_start();
if(!isset($_SESSION['admin_otp']) || !isset($_SESSION['admin_otp_expiry'])) {
    die("<li>OTP verification failed</li>");
}

$user_otp = $_POST['otp'];
$current_time = time();

if($current_time > $_SESSION['admin_otp_expiry']) {
    echo "<li>OTP has expired. Please request a new one.</li>";
} elseif($user_otp == $_SESSION['admin_otp']) {
    $_SESSION['admin'] = $_SESSION['admin_email'];
    unset($_SESSION['admin_otp']);
    unset($_SESSION['admin_otp_expiry']);
    echo "success";
} else {
    echo "<li>Invalid OTP entered. Please try again.</li>";
}
?>