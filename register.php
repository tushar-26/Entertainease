<?php
include_once "Database.php";
session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['number'];
    $city = $_POST['city'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $filename = $_FILES['image']['name'];
    $location = 'admin/image/' . $filename;

    // Validate inputs
    if (empty($username) || empty($email) || empty($mobile) || empty($city) || empty($password) || empty($cpassword)) {
        $_SESSION['error'] = 'All fields are required.';
        header('Location: register_form.php');
        exit();
    }

    if ($password !== $cpassword) {
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: register_form.php');
        exit();
    }

    // Handle image upload
    $file_extension = pathinfo($location, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);
    $image_ext = array('jpg', 'png', 'jpeg', 'gif');

    $response = 0;

    if (in_array($file_extension, $image_ext)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $location)) {
            $response = $location;
        }
    }

    // Insert user into the database
    $insert_record = mysqli_query($conn, "INSERT INTO user (`username`, `email`, `mobile`, `city`, `password`, `image`) VALUES ('$username', '$email', '$mobile', '$city', '$password', '$filename')");

    if (!$insert_record) {
        echo "Registration failed. Please try again.";
    } else {
        // Log the user in
        $_SESSION['uname'] = $username;
        $_SESSION['email'] = $email;

        // Redirect to index.php
        echo "<script>alert('You have successfully registered!'); window.location.href='index.php';</script>";
    }
}
?>