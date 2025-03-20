<?php
include "Database.php";

$email = mysqli_real_escape_string($conn, $_POST['email']);
$newpassword = mysqli_real_escape_string($conn, $_POST['newpassword']);

// Check if email exists
$sql_query = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn, $sql_query);
$row = mysqli_fetch_array($result);
$id = $row['id'];

if ($row) {
    // Update password
    $insert_record = mysqli_query($conn, "UPDATE `user` SET `password` = '$newpassword' WHERE `id` = '$id'");
    if ($insert_record) {
        echo 1;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo 0;
}
?>