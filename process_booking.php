<?php

$servername = "localhost";
$username = "root";       
$password = "";           
$dbname = "beauty_parlor"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $fullname     = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone        = mysqli_real_escape_string($conn, $_POST['phone']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $service      = mysqli_real_escape_string($conn, $_POST['service']);
    $stylist      = mysqli_real_escape_string($conn, $_POST['stylist']);
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
    $booking_time = mysqli_real_escape_string($conn, $_POST['booking_time']);
    $notes        = mysqli_real_escape_string($conn, $_POST['notes']);

    
 
$sql = "INSERT INTO tbl_appointment (fullname, phone, email, service, stylist, booking_date, booking_time, notes) 
        VALUES ('$fullname', '$phone', '$email', '$service', '$stylist', '$booking_date', '$booking_time', '$notes')";
    if ($conn->query($sql) === TRUE) {
        
        echo "<script>
                alert('Your Appointment Booking has been successfully submitted!');
                window.location.href = 'homepage.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>