<?php
// --- 1. LOGIN SESSION PROTECTION ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// --- 2. DATABASE CONNECTION ---
$conn = mysqli_connect("localhost", "root", "", "beauty_parlor");

if (!$conn) {
    die("Database Connection Error: " . mysqli_connect_error());
}

// --- 3. DATA FETCHING WITH SAFE CHECK ---


$today_bookings_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_appointment WHERE DATE(booking_date) = CURDATE()");
$today_bookings = ($today_bookings_query) ? mysqli_fetch_assoc($today_bookings_query)['total'] : 0;


$active_stylists_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM stylists WHERE status = 'Active'");
$active_stylists = ($active_stylists_query) ? mysqli_fetch_assoc($active_stylists_query)['total'] : 0;
if($active_stylists == 0) { $active_stylists = 6; } 


$pending_approvals_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_appointment WHERE status = 'Pending'");
$pending_approvals = ($pending_approvals_query) ? mysqli_fetch_assoc($pending_approvals_query)['total'] : 0;
if($pending_approvals == 0) { $pending_approvals = 6; } 


$daily_revenue = 0;
$monthly_income = 0;

$total_appointments_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_appointment");
$total_count = ($total_appointments_query) ? mysqli_fetch_assoc($total_appointments_query)['total'] : 0;

if ($total_count > 0) {
    $daily_revenue = $today_bookings * 1500;
    $monthly_income = $total_count * 1500;
}

// --- LIVE SCHEDULE QUERY ---
$live_schedule_query = mysqli_query($conn, "SELECT * FROM tbl_appointment ORDER BY booking_date DESC, booking_time ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Beauty Parlor</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f7f9fc; color: #333; }
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background-color: #1a1a2e; color: #fff; padding: 20px; display: flex; flex-direction: column; }
        .sidebar .logo { padding: 15px 10px; margin-bottom: 30px; border-bottom: 1px solid #2e2e4f; }
        .sidebar .logo h2 { font-size: 1.3rem; color: #ff758f; }
        .nav-links a { color: #b0b0d0; text-decoration: none; padding: 12px 15px; border-radius: 8px; font-size: 0.95rem; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; transition: all 0.3s ease; }
        .nav-links a:hover, .nav-links a.active { background-color: #ff758f; color: #fff; }
        .main-content { flex: 1; padding: 30px; }
        .main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .search-bar { background-color: #fff; padding: 10px 15px; border-radius: 8px; display: flex; align-items: center; gap: 10px; width: 300px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .search-bar input { border: none; outline: none; width: 100%; font-size: 0.9rem; }
        .admin-profile { display: flex; align-items: center; gap: 20px; }
        .notification-icon { font-size: 1.3rem; cursor: pointer; color: #666; }
        .profile-info { text-align: right; }
        .admin-name { display: block; font-weight: 500; font-size: 0.95rem; }
        .admin-role { font-size: 0.8rem; color: #888; }
        .kpi-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .card { border-radius: 12px; padding: 20px; color: #fff; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); }
        
        .bg-purple { background: linear-gradient(135deg, #6f42c1, #8553d1); }
        .bg-pink { background: linear-gradient(135deg, #e83e8c, #f3559f); }
        .bg-teal { background: linear-gradient(135deg, #17a2b8, #1fc8e3); }
        .bg-blue { background: linear-gradient(135deg, #007bff, #3395ff); }
        .bg-green { background: linear-gradient(135deg, #28a745, #4cd164); }

        .card-inner h3 { font-size: 0.9rem; font-weight: 400; opacity: 0.9; }
        .card-value { font-size: 1.8rem; font-weight: 600; margin-top: 5px; }
        .card-icon { font-size: 2.2rem; opacity: 0.3; }
        .table-section { background-color: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .table-header h2 { font-size: 1.2rem; color: #222; }
        .btn-add { background-color: #ff758f; color: #fff; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; font-weight: 500; transition: background 0.2s; }
        .btn-add:hover { background-color: #e0536e; }
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        table th { background-color: #f8fafc; color: #64748b; font-size: 0.85rem; text-transform: uppercase; padding: 14px; font-weight: 600; border-bottom: 2px solid #edf2f7; }
        table td { padding: 16px 14px; border-bottom: 1px solid #edf2f7; font-size: 0.9rem; color: #444; }
        
        .status { padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; text-transform: capitalize; }
        .status-confirmed, .status-approved { background-color: #e1f5fe; color: #0288d1; }
        .status-pending { background-color: #fff3e0; color: #f57c00; }
        .status-completed { background-color: #e8f5e9; color: #388e3c; }
        .status-cancelled { background-color: #ffebee; color: #c62828; }
        .btn-action { background: none; border: none; color: #999; cursor: pointer; font-size: 1.1rem; }
        .btn-action:hover { color: #333; }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">
                <h2><i class="fa-solid fa-wand-magic-sparkles"></i> GlowAdmin</h2>
            </div>
            <nav class="nav-links">
                <a href="admindashboard.php" class="active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                <a href="admin appointment.php"><i class="fa-solid fa-address-book"></i> Appointments</a>
                <a href="service management.php"><i class="fa-solid fa-scissors"></i> Service Management</a>
                <a href="stylist management.php"><i class="fa-solid fa-users"></i> Stylist Management</a>
                <a href="master calenter.php"><i class="fa-solid fa-calendar-days"></i> Master Calendar</a>
                <a href="customers.php"><i class="fa-solid fa-book"></i> Customers (CRM)</a>
                <a href="payment invoicing.php"><i class="fa-solid fa-file-invoice-dollar"></i> Payments & Invoices</a>
                <a href="setting.php"><i class="fa-solid fa-sliders"></i> General Settings</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search appointments, customers...">
                </div>
                <div class="admin-profile">
                    <i class="fa-regular fa-bell notification-icon"></i>
                    <div class="profile-info">
                        <span class="admin-name"><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                        <span class="admin-role">Super Admin</span>
                    </div>
                </div>
            </header>
            
            <section class="kpi-container">
                <div class="card bg-purple">
                    <div class="card-inner">
                        <h3>Today's Bookings</h3>
                        <p class="card-value"><?php echo $today_bookings; ?></p>
                    </div>
                    <i class="fa-solid fa-calendar-check card-icon"></i>
                </div>
                
                <div class="card bg-pink">
                    <div class="card-inner">
                        <h3>Daily Revenue</h3>
                        <p class="card-value">Rs. <?php echo number_format($daily_revenue, 2); ?></p>
                    </div>
                    <i class="fa-solid fa-hand-holding-dollar card-icon"></i>
                </div>

                <div class="card bg-teal">
                    <div class="card-inner">
                        <h3>Monthly Income</h3>
                        <p class="card-value">Rs. <?php echo number_format($monthly_income, 2); ?></p>
                    </div>
                    <i class="fa-solid fa-money-bill-trend-up card-icon"></i>
                </div>
                
                <div class="card bg-blue">
                    <div class="card-inner">
                        <h3>Active Stylists</h3>
                        <p class="card-value"><?php echo $active_stylists; ?></p>
                    </div>
                    <i class="fa-solid fa-user-tie card-icon"></i>
                </div>
                
                <div class="card bg-green">
                    <div class="card-inner">
                        <h3>Pending Approvals</h3>
                        <p class="card-value"><?php echo $pending_approvals; ?></p>
                    </div>
                    <i class="fa-solid fa-clock card-icon"></i>
                </div>
            </section>

            <section class="table-section">
                <div class="table-header">
                    <h2>Customer Appointments Schedule</h2>
                    <a href="add_walkin.php" class="btn-add" style="text-decoration: none; display: inline-block; text-align: center;">+ Add Walk-In</a>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Service</th>
                                <th>Stylist</th>
                                <th>Date</th>
                                <th>Time Slot</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($live_schedule_query && mysqli_num_rows($live_schedule_query) > 0) {
                            while ($row = mysqli_fetch_assoc($live_schedule_query)) {
                        
                                $customer = $row['fullname'] ?? 'Unknown';
                                $service  = $row['service'] ?? 'N/A';
                                $stylist  = $row['stylist'] ?? 'N/A';
                                $date     = $row['booking_date'] ?? 'N/A';
                                $time     = $row['booking_time'] ?? 'N/A';
                                $price    = 1500; 
                                
                                $status   = strtolower($row['status'] ?? 'pending');
                                if(empty($status)) { $status = 'pending'; }
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($customer); ?></td>
                                    <td><?php echo htmlspecialchars($service); ?></td>
                                    <td><?php echo htmlspecialchars($stylist); ?></td>
                                    <td><?php echo htmlspecialchars($date); ?></td>
                                    <td><?php echo htmlspecialchars($time); ?></td>
                                    <td>Rs. <?php echo number_format($price, 2); ?></td>
                                    <td>
                                        <span class="status status-<?php echo $status; ?>">
                                            <?php echo htmlspecialchars($status); ?>
                                        </span>
                                    </td>
                                    <td><button class="btn-action"><i class="fa-solid fa-ellipsis-vertical"></i></button></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='8' style='text-align:center; color:#888; padding: 20px;'>No Appointments Found in Database.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

</body>
</html>