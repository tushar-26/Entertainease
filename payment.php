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
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
    <title>Payment Page</title>

<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">

<style>
body {
    font-family: 'Nunito Sans', sans-serif;
    background-color: #f8f9fa;
}

.container {
    margin-top: 50px;
}

.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #343a40;
    color: #fff;
    border-radius: 10px 10px 0 0;
    text-align: center;
    padding: 20px;
}

.card-header h1 {
    margin: 0;
    font-size: 24px;
}

.nav-tabs .nav-link {
    border: none;
    border-bottom: 2px solid transparent;
    color: #343a40;
    font-weight: bold;
}

.nav-tabs .nav-link.active {
    border-bottom: 2px solid #007bff;
}

.tab-content {
    padding: 20px;
}

.form-group label {
    font-weight: bold;
}

.form-control {
    border-radius: 5px;
}

.card-footer {
    background-color: #f8f9fa;
    border-top: none;
    text-align: center;
    padding: 20px;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.front {
    margin: 5px 4px 45px 0;
    background-color: #EDF979;
    color: #000000;
    padding: 9px 0;
    border-radius: 3px;
    text-align: center;
    font-weight: bold;
}
</style>
</head>
<body>

    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-6">Payment Options</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h1>Booking Summary</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            include_once 'Database.php'; 
                            $username= $_SESSION['uname'];
                            if(isset($_POST['submit'])){
                                $show = $_POST['show'];
                                $result = mysqli_query($conn,"SELECT u.username,u.email,u.mobile,u.city,t.theater FROM user u INNER JOIN theater_show t on u.username = '".$username."' WHERE t.show = '".$show."'");
                                $seats1 = implode(",", $_POST["seat"]);
                                $seats = explode(",", $seats1);
                                $price= 0;
                                for($i=1;$i<=12;$i++){
                                    $I = "I".$i;
                                    $H = "H".$i;
                                    $G = "G".$i;
                                    $F = "F".$i;
                                    $E = "E".$i;
                                    $D = "D".$i;
                                    $C = "C".$i;
                                    $B = "B".$i;
                                    $A = "A".$i;
                                    
                                    if(in_array($I,$seats)){
                                        $price=$price+100;
                                    }
                                    if (in_array($H, $seats)){
                                        $price=$price+100;   
                                    }
                                    if (in_array($G, $seats)){
                                        $price=$price+100;   
                                    }
                                    if (in_array($F, $seats)){
                                        $price=$price+150;   
                                    }
                                    if (in_array($E, $seats)){
                                        $price=$price+150;   
                                    }
                                    if (in_array($D, $seats)){
                                        $price=$price+150;   
                                    }
                                    if (in_array($C, $seats)){
                                        $price=$price+150;   
                                    }
                                    if (in_array($B, $seats)){
                                        $price=$price+150;   
                                    }
                                    if (in_array($A, $seats)){
                                        $price=$price+300;   
                                    }
                                }                              
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        echo'<div class="col-lg-6">
                                            Your Username: '.$row['username'].'<br>
                                            Phone no.: '.$row['mobile'].'<br>
                                            Movie Name: '.$_POST['movie'].'<br>
                                            Seats: '.implode(",", $_POST["seat"]).' <br>
                                            Payment Date: '.date("D-m-y ",strtotime('today')).'
                                            </div>
                                            <div class="col-lg-6">
                                            Email: '.$row['email'].'<br>
                                            City: '.$row['city'].'<br>
                                            Theater: '.$row['theater'].'<br>  
                                            Total Seats: '.$_POST['totalseat'].' <br>
                                            Time: '.$_POST['show'].'<br>
                                            Booking Date: '.date("D-m-y ",strtotime('tomorrow')).'
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
                        <!-- Payment method tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="credit-card-tab" data-toggle="tab" href="#credit-card" role="tab" aria-controls="credit-card" aria-selected="true">Credit Card</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="qr-code-tab" data-toggle="tab" href="#qr-code" role="tab" aria-controls="qr-code" aria-selected="false">QR Code</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="upi-tab" data-toggle="tab" href="#upi" role="tab" aria-controls="upi" aria-selected="false">UPI</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <!-- Credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <div class="form-group"> <label for="username">
                                        <h6>Card Owner</h6>
                                    </label> <input type="text" id="card_name" name="card_name" placeholder="Card Owner Name" class="form-control"> 
                                    <div id="validatecardname"></div>
                                </div>
                                <div class="form-group"> <label for="cardNumber">
                                        <h6>Card number</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" id="card_number" name="card_number" placeholder="Valid card number" class="form-control"> 
                                     </div>
                                     <div id="validatecardnumber"></div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group"> <label><span class="hidden-xs">
                                                    <h6>Expiration Date</h6>
                                                </span></label>
                                            <div class="input-group"> <input type="date" id="ex_date" placeholder="MM" name="ex_date" class="form-control">
                                            </div>
                                            <div id="validateexdate"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group mb-4"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                                <h6>CVV </h6>
                                            </label> <input type="number" id="cvv" class="form-control"> </div>
                                            <div id="validatecvv"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                <div class="seatCharts-container">
           
                                             <div class="front">
                                                <font text-align="left">&nbsp;&nbsp;&nbsp;Amount Payble: </font>
                                                <font text-align="right">Rs.<?php echo $price;?>/-</font>
                                            </div>
                                </div>
                            </div>
                                <div id="msg"></div>
                                <div class="card-footer"> <button type="submit" id="payment" class="subscribe btn btn-primary btn-block shadow-sm"> Confirm Payment </button>

                                </div>
                            </div>
                            <!-- QR code info-->
                            <div id="qr-code" class="tab-pane fade pt-3">
                                <div class="form-group">
                                    <label for="qr_code">
                                        <h6>Scan QR Code</h6>
                                    </label>
                                    <div class="text-center">
                                        <img src="img/qr.jpg" alt="QR Code" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                <div class="seatCharts-container">
           
                                             <div class="front">
                                                <font text-align="left">&nbsp;&nbsp;&nbsp;Amount Payble: </font>
                                                <font text-align="right">Rs.<?php echo $price;?>/-</font>
                                            </div>
                                </div>
                            </div>
                                <div id="msg"></div>
                                <div class="card-footer"> <button type="button" id="qr_payment" class="subscribe btn btn-primary btn-block shadow-sm"> Confirm Payment </button>

                                </div>
                            </div>
                            <!-- UPI info-->
                            <div id="upi" class="tab-pane fade pt-3">
                                <div class="form-group">
                                    <label for="upi_id">
                                        <h6>Enter UPI ID</h6>
                                    </label>
                                    <input type="text" id="upi_id" name="upi_id" placeholder="Enter UPI ID" class="form-control">
                                    <div id="validateupiid"></div>
                                </div>
                                <div class="col-lg-6">
                                <div class="seatCharts-container">
           
                                             <div class="front">
                                                <font text-align="left">&nbsp;&nbsp;&nbsp;Amount Payble: </font>
                                                <font text-align="right">Rs.<?php echo $price;?>/-</font>
                                            </div>
                                </div>
                            </div>
                                <div id="msg"></div>
                                <div class="card-footer"> <button type="button" id="upi_payment" class="subscribe btn btn-primary btn-block shadow-sm"> Confirm Payment </button>

                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Js Plugins -->
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
    
    if(card_name == '')
    {
        error = " <font color='red'>!Invalid card name.</font> ";
        document.getElementById( "validatecardname" ).innerHTML = error;
        return false;
    }
    if(card_number == '')
    {
        error = " <font color='red'>!Invalid card number.</font> ";
        document.getElementById( "validatecardnumber" ).innerHTML = error;
        return false;
    }
    if(ex_date == '')
    {
        error = " <font color='red'>!Invalid expiration date.</font> ";
        document.getElementById( "validateexdate" ).innerHTML = error;
        return false;
    }
    if(cvv == '')
    {
        error = " <font color='red'>!Invalid CVV.</font> ";
        document.getElementById( "validatecvv" ).innerHTML = error;
        return false;
    }
    $.ajax({
      url:'payment_form.php',
      type:'post',
      data:{
            movie:movie,
            time:time,
            seat:seat,
            totalseat:totalseat,
            price:price,
            card_name:card_name,
            card_number:card_number,
            ex_date:ex_date,
            cvv:cvv,
            },
      success:function(response){
          if(response == 1){
                                    window.location = "tickes.php";
                                }else{
                                     error = " <font color='red'>!Invalid UserId.</font> ";
                                     document.getElementById( "msg" ).innerHTML = error;
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
    
    // Simulate QR code payment
    alert("QR code payment simulated. Redirecting to tickets page...");
    window.location = "tickes.php";
  });

  $("#upi_payment").click(function(){
    var movie = $("#movie").val().trim();
    var time = $("#time").val().trim();
    var seat = $("#seat").val().trim();
    var totalseat = $("#totalseat").val().trim();
    var price = $("#price").val().trim();
    var upi_id = $("#upi_id").val().trim();
    
    if(upi_id == '')
    {
        error = " <font color='red'>!Invalid UPI ID.</font> ";
        document.getElementById( "validateupiid" ).innerHTML = error;
        return false;
    }
    
    // Simulate UPI payment
    alert("UPI payment simulated. Redirecting to tickets page...");
    window.location = "tickes.php";
  });
});
</script>
   </body>
</html>