<?php
session_start();
if(isset($_SESSION['admin'])) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="../img/logo.jpg" rel="icon">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery-3.5.1.min.js"></script>
    <style>
        :root {
            --primary-red: #dc3545;
            --secondary-red: #ff6b6b;
        }
        body {
            background: url(../img/bg.png) no-repeat center/cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .otp-section {
            display: none;
        }
        .countdown {
            color: var(--primary-red);
            font-weight: bold;
            text-align: center;
            margin: 1rem 0;
        }
        .success-popup {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="success-popup" id="successPopup">Admin Verified Successfully!</div>
    
    <div class="login-container" style="width: 700px;">
        <h1 class="text-center mb-4" style="color: var(--primary-red);">Admin Login</h1>
        
        <!-- Credentials Section -->
        <div class="credentials-section">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="adminEmail" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" id="adminPass" required>
            </div>
            <p id="message" class="text-danger"></p>
            <button class="btn btn-danger w-100" id="sendOtpBtn">Send OTP</button>
        </div>

        <!-- OTP Section -->
        <div class="otp-section mt-4">
            <div class="mb-3">
                <label class="form-label">Enter OTP</label>
                <input type="number" class="form-control" id="adminOtp" placeholder="6-digit code">
            </div>
            <div class="countdown" id="countdown">OTP expires in: 05:00</div>
            <div class="d-flex gap-2">
                <button class="btn btn-danger w-75" id="verifyOtpBtn">Verify OTP</button>
                <button class="btn btn-outline-danger w-25" id="resendOtpBtn">⟳</button>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        let timerInterval;
        
        const startTimer = (duration) => {
            let timer = duration, minutes, seconds;
            const display = $('#countdown');
            
            timerInterval = setInterval(() => {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.text(`OTP expires in: ${minutes}:${seconds}`);

                if (--timer < 0) {
                    clearInterval(timerInterval);
                    display.text("OTP expired!").css('color', 'red');
                    $('#resendOtpBtn').prop('disabled', false);
                }
            }, 1000);
        };

        $('#sendOtpBtn').click(function() {
            const email = $('#adminEmail').val();
            const password = $('#adminPass').val();

            $.ajax({
                url: 'send_otp.php',
                type: 'POST',
                data: { email: email, password: password },
                success: function(response) {
                    if(response === 'success') {
                        $('.credentials-section').hide();
                        $('.otp-section').show();
                        startTimer(300);
                        $('#message').text('').removeClass('text-danger');
                    } else {
                        $('#message').html(response).addClass('text-danger');
                    }
                }
            });
        });

        $('#verifyOtpBtn').click(function() {
            const otp = $('#adminOtp').val();
            
            $.ajax({
                url: 'verify_otp.php',
                type: 'POST',
                data: { otp: otp },
                success: function(response) {
                    if(response === 'success') {
                        $('#successPopup').fadeIn();
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 4000);
                    } else {
                        $('#message').html(response).addClass('text-danger');
                    }
                }
            });
        });

        $('#resendOtpBtn').click(function() {
            $.ajax({
                url: 'resend_otp.php',
                type: 'POST',
                success: function(response) {
                    if(response === 'success') {
                        startTimer(300);
                        $('#message').text('New OTP sent!').removeClass('text-danger');
                        setTimeout(() => $('#message').text(''), 3000);
                    }
                }
            });
        });
    });
    </script>
</body>
</html>