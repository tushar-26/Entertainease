<?php
session_start();
include_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie = $_POST['movie'];
    $time = $_POST['time'];
    $seat = $_POST['seat'];
    $totalseat = $_POST['totalseat'];
    $price = $_POST['price'];
    $upi_id = isset($_POST['upi_id']) ? $_POST['upi_id'] : '';

    $username = $_SESSION['uname'];
    $result = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
    $row = mysqli_fetch_assoc($result);
    $uid = $row['id'];

    $custemer_id = rand(100000000, 999999999);
    $payment_date = date("D-m-y");
    $booking_date = date("D-m-y", strtotime('tomorrow'));

    $sql = "INSERT INTO customers (uid, movie, show_time, seat, totalseat, price, payment_date, booking_date, custemer_id) 
            VALUES ('$uid', '$movie', '$time', '$seat', '$totalseat', '$price', '$payment_date', '$booking_date', '$custemer_id')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['custemer_id'] = $custemer_id;
        echo 1;
    } else {
        echo 0;
    }
}
?>