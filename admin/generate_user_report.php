<?php
include_once 'Database.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header row
$headers = ['ID', 'Name', 'Email', 'Mobile', 'City', 'Avatar'];
$sheet->fromArray($headers, NULL, 'A1');

// Fetch data from the database
$query = "SELECT id, username, email, mobile, city, image FROM user";
$result = mysqli_query($conn, $query);

$rowIndex = 2; // Start from the second row
$totalUsers = 0; // Initialize total user count
while ($row = mysqli_fetch_assoc($result)) {
    $avatarPath = !empty($row['image']) ? 'image/' . $row['image'] : 'image/img_avatar.png';
    $data = [
        $row['id'],
        $row['username'],
        $row['email'],
        $row['mobile'],
        $row['city'],
        $avatarPath
    ];
    $sheet->fromArray($data, NULL, 'A' . $rowIndex);
    $rowIndex++;
    $totalUsers++;
}

// Add total users summary row
$sheet->setCellValue('A' . $rowIndex, 'Total Users:');
$sheet->setCellValue('B' . $rowIndex, $totalUsers);

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="User_Report.xlsx"');
header('Cache-Control: max-age=0');

// Write and output the Excel file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
