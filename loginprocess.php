<?php
session_start();


$admin_user = "admin";
$admin_pass = "admin123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == $admin_user && $password == $admin_pass) {
        $_SESSION['admin_logged_in'] = true; 
        header("Location: admindashboard.php"); 
        exit();
    } else {
        echo "<script>alert(' Username   or Password!'); window.location.href='index.php';</script>";
    }
}
?>