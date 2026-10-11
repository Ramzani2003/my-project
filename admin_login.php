<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admindashboard.php"); 
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DATABASE CONNECTION
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "beauty_parlor";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user = $conn->real_escape_string($_POST['username']);
    $pass = $conn->real_escape_string($_POST['password']);
    
    
    $hashed_pass = md5($pass);

    $sql = "SELECT * FROM tbl_admin WHERE username='$user' AND password='$hashed_pass'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $admin_data = $result->fetch_assoc();
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin_data['username'];
        
        
        header("Location: admindashboard.php"); 
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow & Grace - Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: linear-gradient(135deg, #111827 0%, #1f2937 100%); height: 100vh; display: flex; justify-content: center; align-items: center; }
        .login-container { background-color: #ffffff; padding: 40px; border-radius: 16px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        .logo-area { text-align: center; margin-bottom: 30px; }
        .logo-area h2 { color: #f43f5e; font-size: 28px; font-weight: 600; }
        .logo-area p { color: #6b7280; font-size: 14px; margin-top: 5px; }
        .input-group { position: relative; margin-bottom: 20px; }
        .input-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
        .input-group input { width: 100%; padding: 12px 15px 12px 45px; border: 1px solid #e5e7eb; border-radius: 8px; outline: none; font-size: 14px; transition: 0.3s; }
        .input-group input:focus { border-color: #f43f5e; }
        .btn-login { width: 100%; padding: 12px; background-color: #f43f5e; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 500; cursor: pointer; transition: 0.3s; }
        .btn-login:hover { background-color: #e11d48; }
        .error-msg { background-color: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; font-size: 13px; text-align: center; margin-bottom: 20px; border: 1px solid #fca5a5; }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="logo-area">
            <h2>Glow & Grace</h2>
            <p>Admin Control Panel Login</p>
        </div>

        <?php if(!empty($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="admin_login.php">
            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="username" placeholder="Username" required autocomplete="off">
            </div>
            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-login">Sign In</button>
        </form>
    </div>

</body>
</html>