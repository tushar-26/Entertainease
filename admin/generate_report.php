<?php
include_once 'Database.php';
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header row
$headers = [
    'Booking ID', 'Customer', 'Movie', 'Theater', 'Show Time', 'Seats', 'Total', 
    'Booking Date', 'Payment Date', 'Gross Ticket Value (GTV)', 
    'Commission / Booking Fee Revenue', 'Ads Revenue', 'Total Revenue', 
    'Theater Payouts', 'Net Revenue', 'Total Expenses', 'Profit', 
    'Take Rate', 'ARPU', 'CAC', 'CLV', 'Conversion Rate'
];
$sheet->fromArray($headers, NULL, 'A1');

// Fetch data from the database
$query = "SELECT c.id, u.username AS customer_name, m.movie_name, t.theater, 
          c.show_time, c.seat, c.totalseat, c.price, c.booking_date, c.payment_date 
          FROM customers c
          INNER JOIN user u ON c.uid = u.id
          INNER JOIN add_movie m ON c.movie = m.movie_name
          INNER JOIN theater_show t ON c.show_time = t.show";
$result = mysqli_query($conn, $query);

$rowIndex = 2; // Start from the second row
while ($row = mysqli_fetch_assoc($result)) {
    $gtv = $row['totalseat'] * $row['price'];
    $commission = $row['totalseat'] * 20; // Example: ₹20 commission per ticket
    $adsRevenue = 500; // Example static value
    $totalRevenue = $commission + $adsRevenue;
    $theaterPayouts = $gtv - $commission;
    $netRevenue = $totalRevenue - $theaterPayouts;
    $totalExpenses = 1000; // Example static value
    $profit = $totalRevenue - $totalExpenses;
    $takeRate = ($netRevenue / $gtv) * 100;
    $arpu = $totalRevenue / 100; // Example: 100 users
    $cac = 50; // Example static value
    $clv = 500; // Example static value
    $conversionRate = 10; // Example static value

    $data = [
        $row['id'], $row['customer_name'], $row['movie_name'], $row['theater'], 
        $row['show_time'], $row['seat'], $row['price'], $row['booking_date'], 
        $row['payment_date'], $gtv, $commission, $adsRevenue, $totalRevenue, 
        $theaterPayouts, $netRevenue, $totalExpenses, $profit, $takeRate, 
        $arpu, $cac, $clv, $conversionRate
    ];
    $sheet->fromArray($data, NULL, 'A' . $rowIndex);
    $rowIndex++;
}

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Customer_Report.xlsx"');
header('Cache-Control: max-age=0');

// Write and output the Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
