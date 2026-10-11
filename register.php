<?php

$registration_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $servername = "localhost";
    $username = "root";       
    $password = "";           
    $dbname = "beauty_parlor";


    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

    // 3. Extract and sanitize input data safely
    $full_name = mysqli_real_escape_string($conn, $_POST['name']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender    = mysqli_real_escape_string($conn, $_POST['gender']);
    
    // Encrypt security password using BCRYPT encryption hashes
    $pass_input = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($pass_input, PASSWORD_BCRYPT);

    
    $check_email = "SELECT * FROM tbl_register WHERE email = '$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
    
        echo "<script>alert('This email is already registered! Please use another email.'); window.history.back();</script>";
    } else {
        // 4. Prepare SQL insert execution query statement
        $sql = "INSERT INTO tbl_register (full_name, email, phone, gender, password) 
                VALUES ('$full_name', '$email', '$phone', '$gender', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            // Flag set to true for triggering the JavaScript alert statement
            $registration_success = true;
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }

    // Terminate connection to save server processing memory
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Beauty Parlor & Appointment</title>
    <style>
        /* CSS Reset and Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Register Card Container */
        .register-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        /* Parlor Logo/Header Style */
        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-header h2 {
            color: #d63384; 
            font-size: 28px;
            font-weight: 600;
        }

        .brand-header p {
            color: #6c757d;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
            font-size: 14px;
            font-weight: 600;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #d63384;
            box-shadow: 0 0 0 3px rgba(214, 51, 132, 0.15);
        }

        /* Register Button */
        .btn-register {
            width: 100%;
            padding: 12px;
            background-color: #d63384;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .btn-register:hover {
            background-color: #b8266f;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }

        .login-link a {
            color: #d63384;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="brand-header">
            <h2>Glow & Grace</h2>
            <p>Join us today to enhance your beauty!</p>
        </div>

        <form id="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-register">Create Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="book now.php">Login here</a>
        </div>
    </div>

    <script>
        // Check if the server-side registration execution logic was flagged successful
        <?php if ($registration_success): ?>
            alert("Successfully created your account!");
            window.location.href = "book now.php";
        <?php endif; ?>
    </script>

</body>
</html>