<?php
session_start();
if (!isset($_SESSION['uname'])) {
  header("location:index.php");
}
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
    <title>Booking Summary</title>

    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
</head>
<body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-6" style="margin-top: 0px;">BOOKING SUMMARY</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <center>
                            <h3 style="background-color: red; display: inline-block; padding: 5px 10px; color: white;">Entertainease 🎥</h3>
                            <h6>Devi cinema, Naroda, Ahmedabad</h6>
                        </center>
                        <?php 
                        include "Database.php";
                        if (isset($_SESSION['custemer_id'])) {
                            $custemer_id = $_SESSION['custemer_id'];
                            $result = mysqli_query($conn, "SELECT c.movie, c.booking_date, c.show_time, c.seat, c.totalseat, c.price, c.payment_date, c.custemer_id, u.username, u.email, u.mobile, u.city, t.theater 
                                                            FROM customers c 
                                                            INNER JOIN user u ON c.uid = u.id 
                                                            INNER JOIN theater_show t ON c.show_time = t.show 
                                                            WHERE custemer_id = '$custemer_id'");
                            
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_array($result);
                        ?>
                        <table>
                            <tr>
                                <td>+91 6353747334</td>
                                <td style="padding: 12px 2px 12px 155px;">Custemer Id: <?php echo $row['custemer_id']; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="padding: 1px 2px 1px 155px;">Date: <?php echo $row['payment_date']; ?></td>
                            </tr>
                        </table>
                        <hr>
                        <center><h3>Movie Name: <?php echo $row['movie']; ?></h3></center>
                        <table>
                            <tr>
                                <th>Name</th>
                                <th style="padding: 1px 105px;">City</th>
                            </tr>
                            <tr>
                                <td><?php echo $row['username']; ?></td>
                                <td style="padding: 12px 105px;"><?php echo $row['city']; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <th style="padding: 1px 105px;">Phone</th>
                            </tr>
                            <tr>
                                <td><?php echo $row['email']; ?></td>
                                <td style="padding: 12px 105px;"><?php echo $row['mobile']; ?></td>
                            </tr>
                            <tr>
                                <th>Payment Date</th>
                                <th style="padding: 1px 105px;">Payment Amount</th>
                            </tr>
                            <tr>
                                <td><?php echo $row['payment_date']; ?></td>
                                <td style="padding: 12px 105px;">RS. <?php echo $row['price']; ?>/-</td>
                            </tr>
                        </table>
                        <hr>
                        <h4>BOOKING DETAILS:</h4>
                        <table>
                            <tr>
                                <th>Theater</th>
                                <th style="padding: 0px 2px 0px 60px">Date</th>
                                <th style="padding-left: 30px;">Time</th>
                            </tr>
                            <tr>
                                <td>No. <?php echo $row['theater']; ?></td>
                                <td style="padding: 12px 2px 12px 60px"><?php echo $row['booking_date']; ?></td>
                                <td style="padding-left: 30px;"><?php echo $row['show_time']; ?></td>
                            </tr>
                            <tr>
                                <th>Seats</th>
                                <th style="padding: 0px 2px 0px 60px;">Total Seats</th>
                            </tr>
                            <tr>
                                <td style="padding-right: 150px;"><?php echo $row['seat']; ?></td>
                                <td style="padding: 12px 2px 12px 60px"><?php echo $row['totalseat']; ?></td>
                            </tr>
                        </table>
                        <?php
                            } else {
                                echo "<center><h3>No booking found for the provided customer ID.</h3></center>";
                            }
                        } else {
                            echo "<center><h3>Invalid customer ID. Please check your booking details.</h3></center>";
                        }
                        ?>
                    <a href="generate_pdf.php" style="text-align: center;
                    background-color:darkcyan; color:beige; padding: 7px 10px;">Download as PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>