<?php
session_start();
include_once 'Database.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        
        // Send confirmation email
        $mail = new PHPMailer(true);
        try {
            $user_result = mysqli_query($conn, "SELECT * FROM user WHERE id = '$uid'");
            $user_data = mysqli_fetch_assoc($user_result);
            $theater = isset($_SESSION['theater']) ? $_SESSION['theater'] : 'Cineplex Theater';

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'entertainease0@gmail.com';
            $mail->Password   = 'ommqrgddlpihvwph';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('entertainease0@gmail.com');
            $mail->addAddress($user_data['email']);

            $mail->isHTML(true);
            $mail->Subject = 'Your Movie Ticket Confirmation - Entertainease';
            
            $emailBody = '
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 20px; }
                    .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                    .header { background: #d32f2f; color: white; padding: 30px; text-align: center; }
                    .content { padding: 30px; color: #333; }
                    .ticket-info { margin: 20px 0; padding: 20px; background: #fff8f8; border-radius: 8px; }
                    .details-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                    .details-table td { padding: 10px; border-bottom: 1px solid #eee; }
                    .footer { background: #f5f5f5; padding: 20px; text-align: center; font-size: 12px; color: #666; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>🎟️ Ticket Confirmed!</h1>
                        <p>Your movie experience awaits!</p>
                    </div>
                    <div class="content">
                        <h2>Hello '.$user_data['username'].',</h2>
                        <p>Your booking for <strong>'.$movie.'</strong> has been confirmed!</p>
                        
                        <div class="ticket-info">
                            <h3>Booking Details</h3>
                            <table class="details-table">
                                <tr>
                                    <td>Booking ID:</td>
                                    <td>'.$custemer_id.'</td>
                                </tr>
                                <tr>
                                    <td>Movie:</td>
                                    <td>'.$movie.'</td>
                                </tr>
                                <tr>
                                    <td>Show Time:</td>
                                    <td>'.$time.'</td>
                                </tr>
                                <tr>
                                    <td>Seats:</td>
                                    <td>'.$seat.'</td>
                                </tr>
                                <tr>
                                    <td>Total Price:</td>
                                    <td>₹'.$price.'</td>
                                </tr>
                                <tr>
                                    <td>Theater:</td>
                                    <td>'.$theater.'</td>
                                </tr>
                            </table>
                        </div>

                        <p>📌 Present this email at the theater for entry<br>
                        ⏰ Please arrive at least 30 minutes before showtime</p>
                    </div>
                    <div class="footer">
                        <p>Need help? Contact us at entertainease0@gmail.com</p>
                        <p>© '.date('Y').' Entertainease. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>';

            $mail->Body = $emailBody;
            $mail->AltBody = "Ticket Confirmation\n\nMovie: $movie\nTime: $time\nSeats: $seat\nPrice: ₹$price\nBooking ID: $custemer_id";
            
            $mail->send();
        } catch (Exception $e) {
            // Silent fail for email error
        }
        echo 1;
    } else {
        echo 0;
    }
}
?>