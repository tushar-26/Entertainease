<?php 
session_start();  
if (!isset($_SESSION['uname'])) {
  header("location:index.php");
}
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
    <title>Payment Page</title>

    <!-- Bootstrap CSS -->
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-red: #dc3545;
            --secondary-red: #ff6b6b;
        }

        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .payment-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 20px;
        }

        .payment-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .card-header {
            background: linear-gradient(45deg, var(--primary-red), var(--secondary-red));
            color: white;
            padding: 1.5rem;
            border-radius: 15px 15px 0 0;
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .nav-link {
            color: #6c757d !important;
            font-weight: 500;
            border: none !important;
            padding: 1rem 2rem;
        }

        .nav-link.active {
            color: var(--primary-red) !important;
            border-bottom: 3px solid var(--primary-red) !important;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-red);
            box-shadow: none;
        }

        .btn-payment {
            background: var(--primary-red);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-payment:hover {
            background: var(--secondary-red);
            transform: translateY(-2px);
        }

        .qr-display {
            width: 300px;
            margin: 2rem auto;
            padding: 15px;
            border: 2px solid #eee;
            border-radius: 10px;
            background: white;
        }

        /* CAPTCHA Popup (used for payment verification) */
        .captcha-popup {
            display: none; /* hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .captcha-box {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        .captcha-display {
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 5px;
            background: #ffe3e3;
            color: var(--primary-red);
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
        }

        .captcha-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            margin: 1rem 0;
        }

        .regenerate-captcha {
            color: var(--secondary-red);
            cursor: pointer;
            transition: all 0.3s;
        }

        .regenerate-captcha:hover {
            color: var(--primary-red);
            transform: rotate(90deg);
        }

        .summary-item {
            background: #fff5f5;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .summary-item strong {
            color: var(--primary-red);
            min-width: 120px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="text-center mb-4">
            <h2 class="font-weight-bold" style="color: var(--primary-red);">Complete your Payment</h2>
            <p class="text-muted">Secure payment processing</p>
        </div>

        <div class="payment-card">
            <div class="card-header">
                <h4 class="mb-0">Booking Summary</h4>
            </div>
            
            <div class="card-body">
                <div class="summary-item">
                    <div class="row">
                        <?php
                        include_once 'Database.php';
                        $username = $_SESSION['uname'];
                        if(isset($_POST['submit'])){
                            $show = $_POST['show'];
                            $result = mysqli_query($conn, "SELECT u.username, u.email, u.mobile, u.city, t.theater 
                                                          FROM user u 
                                                          INNER JOIN theater_show t 
                                                          ON u.username = '$username' 
                                                          WHERE t.show = '$show'");
                            
                            $seats = $_POST["seat"];
                            $price = 0;
                            
                            foreach($_POST["seat"] as $seat) {
                                $prefix = substr($seat, 0, 1);
                                $price += match($prefix) {
                                    'A' => 300,
                                    'B','C','D','E','F' => 150,
                                    default => 100
                                };
                            }

                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_array($result)) {
                                    $_SESSION['theater'] = $row['theater'];
                                    echo '<div class="col-md-6">';
                                    echo '<div><strong>Name:</strong> '.$row['username'].'</div>';
                                    echo '<div><strong>Phone:</strong> '.$row['mobile'].'</div>';
                                    echo '<div><strong>Movie:</strong> '.$_POST['movie'].'</div>';
                                    echo '<div><strong>Seats:</strong> '.implode(", ", $_POST["seat"]).'</div>';
                                    echo '</div>';
                                    echo '<div class="col-md-6">';
                                    echo '<div><strong>Email:</strong> '.$row['email'].'</div>';
                                    echo '<div><strong>City:</strong> '.$row['city'].'</div>';
                                    echo '<div><strong>Theater:</strong> '.$row['theater'].'</div>';
                                    echo '<div><strong>Time:</strong> '.$_POST['show'].'</div>';
                                    echo '</div>';
                                    echo '<div class="col-md-12 mt-3 text-center">';
                                    echo '<h3>Payable Amount: ₹'.$price.'</h3>';
                                    echo '</div>';
                                }
                            }
                        }  
                        ?>  
                        <input type="hidden" id="movie" value="<?= $_POST['movie'] ?? '' ?>">
                        <input type="hidden" id="time" value="<?= $_POST['show'] ?? '' ?>">
                        <input type="hidden" id="seat" value="<?= implode(",", $_POST["seat"] ?? []) ?>">
                        <input type="hidden" id="totalseat" value="<?= $_POST['totalseat'] ?? '' ?>">
                        <input type="hidden" id="price" value="<?= $price ?? 0 ?>">
                    </div>
                </div>

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#credit-card">Credit Card</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#qr-code">QR Code</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#upi">UPI</a>
                    </li>
                </ul>

                <div class="tab-content mt-4">
                    <!-- Credit Card --> 
                    <div class="tab-pane fade show active" id="credit-card">
                        <div class="form-group">
                            <label>Cardholder Name</label>
                            <input type="text" id="card_name" class="form-control">
                            <div id="validatecardname" class="text-danger small"></div>
                        </div>
                        
                        <div class="form-group">
                            <label>Card Number</label>
                            <input type="text" id="card_number" class="form-control">
                            <div id="validatecardnumber" class="text-danger small"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input type="month" id="ex_date" class="form-control">
                                    <div id="validateexdate" class="text-danger small"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="number" id="cvv" class="form-control">
                                    <div id="validatecvv" class="text-danger small"></div>
                                </div>
                            </div>
                        </div>
                        
                        <button class="btn btn-payment btn-block" id="creditPayment">Pay Now</button>
                    </div>

                    <!-- QR Code -->
                    <div class="tab-pane fade" id="qr-code">
                        <div class="text-center">
                            <img src="img/qr.jpg" class="qr-display">
                            <button class="btn btn-payment btn-block mt-3" id="qrPayment">Confirm Payment</button>
                        </div>
                    </div>

                    <!-- UPI -->
                    <div class="tab-pane fade" id="upi">
                        <div class="form-group">
                            <label>UPI ID</label>
                            <input type="text" id="upi_id" class="form-control" placeholder="example@upi">
                            <div id="validateupiid" class="text-danger small"></div>
                        </div>
                        <button class="btn btn-payment btn-block" id="upiPayment">Pay Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CAPTCHA Popup (used for payment verification) -->
    <div class="captcha-popup">
        <div class="captcha-box">
            <h4>Verify Payment</h4>
            <div class="captcha-display" id="captchaDisplay"></div>
            <input type="text" id="captchaInput" class="captcha-input" placeholder="Enter CAPTCHA">
            <div class="d-flex justify-content-center align-items-center">
                <span class="regenerate-captcha" id="refreshCaptcha">⟳</span>
            </div>
            <div id="captchaError" class="text-danger small mt-2"></div>
            <button class="btn btn-payment btn-block mt-3" id="confirmPayment">Confirm</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        let currentCaptcha = '';
        let paymentData = {};
        let paymentType = '';

        // Generate CAPTCHA
        function generateCaptcha() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            return Array.from({length: 5}, () => chars[Math.floor(Math.random() * chars.length)]).join('');
        }

        // Show CAPTCHA popup (set display to flex for centering)
        function showCaptcha() {
            currentCaptcha = generateCaptcha();
            $('#captchaDisplay').text(currentCaptcha);
            $('.captcha-popup').css('display', 'flex').hide().fadeIn();
            $('#captchaInput').val('');
            $('#captchaError').hide();
        }

        // Validate credit card details
        function validateCreditCard() {
            let valid = true;
            const fields = {
                card_name: $('#card_name').val().trim(),
                card_number: $('#card_number').val().trim().replace(/\s/g, ''),
                ex_date: $('#ex_date').val().trim(),
                cvv: $('#cvv').val().trim()
            };

            // Clear previous errors
            $('.text-danger').html('');

            if(!fields.card_name) {
                $('#validatecardname').html('Cardholder name required');
                valid = false;
            }
            if(!/^\d{16}$/.test(fields.card_number)) {
                $('#validatecardnumber').html('Invalid card number');
                valid = false;
            }
            if(!fields.ex_date) {
                $('#validateexdate').html('Expiry date required');
                valid = false;
            }
            if(!/^\d{3,4}$/.test(fields.cvv)) {
                $('#validatecvv').html('Invalid CVV');
                valid = false;
            }

            return valid;
        }

        // Payment handlers
        $('#creditPayment').click(function(e) {
            e.preventDefault();
            if(validateCreditCard()) {
                paymentType = 'credit';
                paymentData = {
                    movie: $('#movie').val(),
                    time: $('#time').val(),
                    seat: $('#seat').val(),
                    totalseat: $('#totalseat').val(),
                    price: $('#price').val(),
                    card_name: $('#card_name').val().trim(),
                    card_number: $('#card_number').val().trim(),
                    ex_date: $('#ex_date').val().trim(),
                    cvv: $('#cvv').val().trim()
                };
                showCaptcha();
            }
        });

        $('#qrPayment').click(function(e) {
            e.preventDefault();
            paymentType = 'qr';
            paymentData = {
                movie: $('#movie').val(),
                time: $('#time').val(),
                seat: $('#seat').val(),
                totalseat: $('#totalseat').val(),
                price: $('#price').val()
            };
            showCaptcha();
        });

        $('#upiPayment').click(function(e) {
            e.preventDefault();
            const upiId = $('#upi_id').val().trim();
            if(!/^\w+@\w+$/.test(upiId)) {
                $('#validateupiid').html('Invalid UPI ID');
                return;
            }
            paymentType = 'upi';
            paymentData = {
                movie: $('#movie').val(),
                time: $('#time').val(),
                seat: $('#seat').val(),
                totalseat: $('#totalseat').val(),
                price: $('#price').val(),
                upi_id: upiId
            };
            showCaptcha();
        });

        // CAPTCHA validation and submission
        $('#confirmPayment').click(function() {
            const userInput = $('#captchaInput').val().trim();
            if(userInput !== currentCaptcha) {
                $('#captchaError').html('Invalid CAPTCHA').show();
                return;
            }

            const endpoint = paymentType === 'credit' ? 'payment_form.php' : 'payment_form_qr_upi.php';
            
            $.ajax({
                url: endpoint,
                type: 'POST',
                data: paymentData,
                success: function(response) {
                    if(response == 1) {
                        $('#captchaError').hide();
                        window.location.href = 'tickes.php';
                    } else {
                        $('#captchaError').html('Payment failed. Please try again.').show();
                    }
                },
                error: function() {
                    $('#captchaError').html('Connection error').show();
                }
            });
        });

        // Regenerate CAPTCHA
        $('#refreshCaptcha').click(function() {
            currentCaptcha = generateCaptcha();
            $('#captchaDisplay').text(currentCaptcha);
        });
    });
    </script>
</body>
</html>
