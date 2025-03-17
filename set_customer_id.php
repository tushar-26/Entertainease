<?php
session_start();
if (isset($_POST['custemer_id'])) {
    $_SESSION['custemer_id'] = $_POST['custemer_id'];
    echo "Customer ID set successfully.";
} else {
    echo "Customer ID not set.";
}
?>