<?php

require 'vendor/autoload.php';
use Dompdf\Dompdf;

session_start();
if (!isset($_SESSION['uname'])) {
    header("location:index.php");
}

include "Database.php";
$result = mysqli_query($conn,"SELECT c.movie,c.booking_date,c.show_time,c.seat,c.totalseat,c.price,c.payment_date,c.custemer_id,u.username,u.email,u.mobile,u.city,t.theater FROM customers c INNER JOIN user u on c.uid=u.id INNER JOIN theater_show t on c.show_time=t.show WHERE custemer_id = '".$_SESSION['custemer_id']."'");
$row = mysqli_fetch_array($result);

$html = '
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Nunito Sans", sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .card-header h3 {
            background-color: #dc3545;
            display: inline-block;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .card-header h6 {
            margin-top: 10px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        hr {
            border-top: 1px solid #dee2e6;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-6" style="margin-top: 0px;">BOOKING SUMMARY</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Entertainease</h3>
                        <h4>Devi cinema, Naroda, Ahmedabad</h4>
                    </div>
                    <div class="card-body">
                        <table>
                            <tr>
                                <td>+91 6353747334</td>
                                <td style="text-align: right;">Customer Id: '.$row['custemer_id'].'</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: right;">Date: '.$row['payment_date'].'</td>
                            </tr>
                        </table>
                        <hr>
                        <center><h3>Movie Name: '.$row['movie'].'</h3></center>
                        <table>
                            <tr>
                                <th>Name</th>
                                <th style="text-align: right;">City</th>
                            </tr>
                            <tr>
                                <td>'.$row['username'].'</td>
                                <td style="text-align: right;">'.$row['city'].'</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <th style="text-align: right;">Phone</th>
                            </tr>
                            <tr>
                                <td>'.$row['email'].'</td>
                                <td style="text-align: right;">'.$row['mobile'].'</td>
                            </tr>
                            <tr>
                                <th>Payment Date</th>
                                <th style="text-align: right;">Payment Amount</th>
                            </tr>
                            <tr>
                                <td>'.$row['payment_date'].'</td>
                                <td style="text-align: right;">RS. '.$row['price'].'/-</td>
                            </tr>
                        </table>
                        <hr>
                        <h4>BOOKING DETAILS:</h4>
                        <table>
                            <tr>
                                <th>Theater</th>
                                <th style="text-align: right;">Date</th>
                                <th style="text-align: right;">Time</th>
                            </tr>
                            <tr>
                                <td>No. '.$row['theater'].'</td>
                                <td style="text-align: right;">'.$row['booking_date'].'</td>
                                <td style="text-align: right;">'.$row['show_time'].'</td>
                            </tr>
                            <tr>
                                <th>Seats</th>
                                <th style="text-align: right;">Total Seats</th>
                            </tr>
                            <tr>
                                <td>'.$row['seat'].'</td>
                                <td style="text-align: right;">'.$row['totalseat'].'</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("booking_summary.pdf", array("Attachment" => 1));
?>