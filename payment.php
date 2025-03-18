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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
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
            overflow: hidden;
        }

        .card-header {
            background: #2a2a72;
            background: linear-gradient(45deg, #2a2a72, #009ffd);
            color: white;
            padding: 1.5rem;
            border-radius: 15px 15px 0 0 !important;
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            margin: 1rem 0;
        }

        .nav-link {
            color: #6c757d;
            font-weight: 500;
            border: none !important;
            padding: 1rem 2rem;
        }

        .nav-link.active {
            color: #2a2a72;
            border-bottom: 3px solid #2a2a72 !important;
            background: transparent;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2a2a72;
            box-shadow: none;
        }

        .payment-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1rem 0;
        }

        .payment-summary div {
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .btn-primary {
            background: #2a2a72;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #009ffd;
            transform: translateY(-2px);
        }

        .qr-code-img {
            max-width: 300px;
            margin: 1rem auto;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 10px;
        }

        .amount-payable {
            background: #e9f5ff;
            padding: 1rem;
            border-radius: 8px;
            font-weight: 600;
            color: #2a2a72;
            margin: 1rem 0;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            .payment-container {
                padding: 10px;
                margin: 1rem auto;
            }
            
            .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="text-center mb-4">
            <h2 class="font-weight-bold" style="color: #2a2a72;">Payment Options</h2>
            <p class="text-muted">Complete your booking by making payment</p>
        </div>

        <div class="payment-card" >
            <div class="card-header">
                <h4 class="mb-0">Booking Summary</h4>
            </div>
            
            <div class="card-body">
                <div class="payment-summary">
                    <div class="row">
                        <?php
                        include_once 'Database.php'; 
                        $username = $_SESSION['uname'];
                        if(isset($_POST['submit'])){
                            $show = $_POST['show'];
                            $result = mysqli_query($conn, "SELECT u.username, u.email, u.mobile, u.city, t.theater FROM user u INNER JOIN theater_show t ON u.username = '".$username."' WHERE t.show = '".$show."'");
                            $seats1 = implode(",", $_POST["seat"]);
                            $seats = explode(",", $seats1);
                            $price = 0;
                            for($i = 1; $i <= 12; $i++){
                                $I = "I".$i;
                                $H = "H".$i;
                                $G = "G".$i;
                                $F = "F".$i;
                                $E = "E".$i;
                                $D = "D".$i;
                                $C = "C".$i;
                                $B = "B".$i;
                                $A = "A".$i;
                                
                                if(in_array($I, $seats)){
                                    $price += 100;
                                }
                                if (in_array($H, $seats)){
                                    $price += 100;   
                                }
                                if (in_array($G, $seats)){
                                    $price += 100;   
                                }
                                if (in_array($F, $seats)){
                                    $price += 150;   
                                }
                                if (in_array($E, $seats)){
                                    $price += 150;   
                                }
                                if (in_array($D, $seats)){
                                    $price += 150;   
                                }
                                if (in_array($C, $seats)){
                                    $price += 150;   
                                }
                                if (in_array($B, $seats)){
                                    $price += 150;   
                                }
                                if (in_array($A, $seats)){
                                    $price += 300;   
                                }
                            }                              
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_array($result)) {
                                    echo'<div class="col-lg-6">
                                        Your Username: '.$row['username'].'<br>
                                        Phone no.: '.$row['mobile'].'<br>
                                        Movie Name: '.$_POST['movie'].'<br>
                                        Seats: '.implode(",", $_POST["seat"]).' <br>
                                        Payment Date: '.date("D-m-y ", strtotime('today')).'
                                        </div>
                                        <div class="col-lg-6">
                                        Email: '.$row['email'].'<br>
                                        City: '.$row['city'].'<br>
                                        Theater: '.$row['theater'].'<br>  
                                        Total Seats: '.$_POST['totalseat'].' <br>
                                        Time: '.$_POST['show'].'<br>
                                        Booking Date: '.date("D-m-y ", strtotime('tomorrow')).'
                                        </div>' ;
                                }
                            }
                        }  
                        ?>  
                        <input type="hidden" id="movie" value="<?php echo $_POST['movie'];?>">
                        <input type="hidden" id="time" value="<?php echo $_POST['show'];?>">
                        <input type="hidden" id="seat" value="<?php echo implode(",", $_POST["seat"]);?>">
                        <input type="hidden" id="totalseat" value="<?php echo $_POST['totalseat'];?>">
                        <input type="hidden" id="price" value="<?php echo $price;?>">
                    </div>
                </div>

                <!-- Payment method tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="credit-card-tab" data-toggle="tab" href="#credit-card" role="tab">Credit Card</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="qr-code-tab" data-toggle="tab" href="#qr-code" role="tab">QR Code</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="upi-tab" data-toggle="tab" href="#upi" role="tab">UPI</a>
                    </li>
                </ul>

                <div class="tab-content mt-4">
                    <!-- Credit card info-->
                    <div id="credit-card" class="tab-pane fade show active">
                        <form>
                            <div class="form-group">
                                <label>Card Owner Name</label>
                                <input type="text" id="card_name" class="form-control" placeholder="John Doe">
                                <div id="validatecardname" class="error-message"></div>
                            </div>

                            <div class="form-group">
                                <label>Card Number</label>
                                <input type="text" id="card_number" class="form-control" placeholder="1234 5678 9012 3456">
                                <div id="validatecardnumber" class="error-message"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Expiration Date</label>
                                        <input type="date" id="ex_date" class="form-control">
                                        <div id="validateexdate" class="error-message"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>CVV</label>
                                        <input type="number" id="cvv" class="form-control" placeholder="123">
                                        <div id="validatecvv" class="error-message"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="amount-payable">
                                Amount Payable: ₹<?php echo $price;?>/-
                            </div>

                            <div class="text-center">
                                <button type="submit" id="payment" class="btn btn-primary btn-lg btn-block">Confirm Payment</button>
                            </div>
                        </form>
                    </div>

                    <!-- QR code info-->
                    <div id="qr-code" class="tab-pane fade">
                        <div class="text-center">
                            <img src="img/qr.jpg" class="qr-code-img" alt="QR Code">
                            <div class="amount-payable">
                                Amount Payable: ₹<?php echo $price;?>/-
                            </div>
                            <button type="button" id="qr_payment" class="btn btn-primary btn-lg btn-block">Confirm Payment</button>
                        </div>
                    </div>

                    <!-- UPI info-->
                    <div id="upi" class="tab-pane fade">
                        <form>
                            <div class="form-group">
                                <label>UPI ID</label>
                                <input type="text" id="upi_id" class="form-control" placeholder="example@upi">
                                <div id="validateupiid" class="error-message"></div>
                            </div>

                            <div class="amount-payable">
                                Amount Payable: ₹<?php echo $price;?>/-
                            </div>

                            <div class="text-center">
                                <button type="button" id="upi_payment" class="btn btn-primary btn-lg btn-block">Confirm Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#payment").click(function(){
                var movie = $("#movie").val().trim();
                var time = $("#time").val().trim();
                var seat = $("#seat").val().trim();
                var totalseat = $("#totalseat").val().trim();
                var price = $("#price").val().trim();
                var card_name = $("#card_name").val().trim();
                var card_number = $("#card_number").val().trim();
                var ex_date = $("#ex_date").val().trim();
                var cvv = $("#cvv").val().trim();
                
                if(card_name == '') {
                    error = " <font color='red'>!Invalid card name.</font> ";
                    document.getElementById("validatecardname").innerHTML = error;
                    return false;
                }
                if(card_number == '') {
                    error = " <font color='red'>!Invalid card number.</font> ";
                    document.getElementById("validatecardnumber").innerHTML = error;
                    return false;
                }
                if(ex_date == '') {
                    error = " <font color='red'>!Invalid expiration date.</font> ";
                    document.getElementById("validateexdate").innerHTML = error;
                    return false;
                }
                if(cvv == '') {
                    error = " <font color='red'>!Invalid CVV.</font> ";
                    document.getElementById("validatecvv").innerHTML = error;
                    return false;
                }
                $.ajax({
                    url: 'payment_form.php',
                    type: 'post',
                    data: {
                        movie: movie,
                        time: time,
                        seat: seat,
                        totalseat: totalseat,
                        price: price,
                        card_name: card_name,
                        card_number: card_number,
                        ex_date: ex_date,
                        cvv: cvv,
                    },
                    success: function(response){
                        if(response == 1){
                            window.location = "tickes.php";
                        } else {
                            error = " <font color='red'>!Invalid UserId.</font> ";
                            document.getElementById("msg").innerHTML = error;
                            return false;
                        }
                        $("#message").html(response);
                    }
                });
            });

            $("#qr_payment").click(function(){
                var movie = $("#movie").val().trim();
                var time = $("#time").val().trim();
                var seat = $("#seat").val().trim();
                var totalseat = $("#totalseat").val().trim();
                var price = $("#price").val().trim();
                
                $.ajax({
                    url: 'payment_form_qr_upi.php',
                    type: 'post',
                    data: {
                        movie: movie,
                        time: time,
                        seat: seat,
                        totalseat: totalseat,
                        price: price,
                    },
                    success: function(response){
                        if(response == 1){
                            window.location = "tickes.php";
                        } else {
                            error = " <font color='red'>!Invalid UserId.</font> ";
                            document.getElementById("msg").innerHTML = error;
                            return false;
                        }
                        $("#message").html(response);
                    }
                });
            });

            $("#upi_payment").click(function(){
                var movie = $("#movie").val().trim();
                var time = $("#time").val().trim();
                var seat = $("#seat").val().trim();
                var totalseat = $("#totalseat").val().trim();
                var price = $("#price").val().trim();
                var upi_id = $("#upi_id").val().trim();
                
                if(upi_id == '') {
                    error = " <font color='red'>!Invalid UPI ID.</font> ";
                    document.getElementById("validateupiid").innerHTML = error;
                    return false;
                }
                
                $.ajax({
                    url: 'payment_form_qr_upi.php',
                    type: 'post',
                    data: {
                        movie: movie,
                        time: time,
                        seat: seat,
                        totalseat: totalseat,
                        price: price,
                        upi_id: upi_id,
                    },
                    success: function(response){
                        if(response == 1){
                            window.location = "tickes.php";
                        } else {
                            error = " <font color='red'>!Invalid UserId.</font> ";
                            document.getElementById("msg").innerHTML = error;
                            return false;
                        }
                        $("#message").html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>