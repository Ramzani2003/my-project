<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. DATABASE CONNECTION
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beauty_parlor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. EXPORT CSV LOGIC
if (isset($_GET['action']) && $_GET['action'] == 'export_csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=salon_invoices_' . date('Y-m-d') . '.csv');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, array('Invoice ID', 'Client Name', 'Service', 'Amount (LKR)', 'Status', 'Date'));
    
    $query = "SELECT appointment_id, fullname, service, amount, status, booking_date FROM tbl_appointment ORDER BY appointment_id DESC";
    $result = $conn->query($query);
    
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array(
            '#INV-' . str_pad($row['appointment_id'], 4, '0', STR_PAD_LEFT),
            $row['fullname'],
            $row['service'],
            $row['amount'] ? $row['amount'] : '0',
            $row['status'],
            $row['booking_date']
        ));
    }
    fclose($output);
    exit();
}

// 3. STATS CALCULATION
// Total Revenue கணக்கீடு
$rev_res = $conn->query("SELECT SUM(amount) AS total_rev FROM tbl_appointment WHERE LOWER(status) = 'completed' OR LOWER(status) = 'paid' OR LOWER(status) = 'approved'");
$rev_row = $rev_res->fetch_assoc();
$total_revenue = $rev_row['total_rev'] ? $rev_row['total_rev'] : 0;

// Pending Invoices எண்ணிக்கை
$pend_res = $conn->query("SELECT COUNT(*) AS total_pend FROM tbl_appointment WHERE LOWER(status) = 'pending'");
$pend_row = $pend_res->fetch_assoc();
$pending_invoices = $pend_row['total_pend'];

// Success Rate கணக்கீடு
$total_res = $conn->query("SELECT COUNT(*) AS total_count FROM tbl_appointment");
$total_row = $total_res->fetch_assoc();
$total_appointments = $total_row['total_count'];

$success_rate = 100; 
if ($total_appointments > 0) {
    $success_res = $conn->query("SELECT COUNT(*) AS success_count FROM tbl_appointment WHERE LOWER(status) = 'completed' OR LOWER(status) = 'paid' OR LOWER(status) = 'approved'");
    $success_row = $success_res->fetch_assoc();
    $success_rate = round(($success_row['success_count'] / $total_appointments) * 100, 1);
}

// 4. FILTER & SEARCH LOGIC FOR TABLE
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT appointment_id, fullname, service, amount, status, booking_date FROM tbl_appointment WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (fullname LIKE '%$search%' OR appointment_id LIKE '%$search%' OR service LIKE '%$search%')";
}

if ($filter == 'paid') {
    $sql .= " AND (LOWER(status) = 'completed' OR LOWER(status) = 'paid' OR LOWER(status) = 'approved')";
} elseif ($filter == 'pending') {
    $sql .= " AND LOWER(status) = 'pending'";
}

$sql .= " ORDER BY appointment_id DESC";
$table_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow & Grace - Payments & Invoices</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f3f4f6; color: #1f2937; }
        .container { display: flex; min-height: 100vh; }

        /* SIDEBAR STYLES */
        .sidebar { width: 260px; background-color: #111827; color: #ffffff; padding: 20px 0; }
        .logo h2 { color: #f43f5e; text-align: center; font-size: 22px; font-weight: 600; margin-bottom: 40px; }
        .menu { display: flex; flex-direction: column; }
        .menu a { color: #9ca3af; text-decoration: none; padding: 14px 25px; font-size: 14px; display: flex; align-items: center; gap: 12px; transition: 0.3s; }
        .menu a:hover, .menu a.active { color: #ffffff; background-color: #f43f5e; border-top-right-radius: 20px; border-bottom-right-radius: 20px; margin-right: 15px; }

        /* MAIN CONTENT STYLES */
        .main-content { flex: 1; padding: 30px; }
        .main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .title-area h1 { font-size: 26px; color: #111827; }
        .title-area p { color: #6b7280; font-size: 13px; margin-top: 5px; }
        .admin-profile { display: flex; align-items: center; gap: 20px; }
        .admin-info h4 { font-size: 14px; color: #111827; }
        .admin-info span { font-size: 12px; color: #9ca3af; }

        /* CARDS STYLES */
        .stats-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .card { background-color: #ffffff; padding: 20px; border-radius: 12px; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); text-decoration: none; color: inherit; transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); cursor: pointer; }
        .card-icon { width: 50px; height: 50px; border-radius: 10px; display: flex; justify-content: center; align-items: center; font-size: 20px; }
        .income { background-color: #ecfdf5; color: #10b981; }
        .pending { background-color: #fffbeb; color: #f59e0b; }
        .success-rate { background-color: #eff6ff; color: #3b82f6; }
        .card-data h3 { font-size: 20px; color: #111827; }
        .card-data p { font-size: 12px; color: #6b7280; }

        /* TABLE SECTION STYLES */
        .table-section { background-color: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        .table-controls { display: flex; justify-content: space-between; margin-bottom: 20px; align-items: center; }
        
        .search-box { position: relative; width: 350px; }
        .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
        .search-box input { width: 100%; padding: 10px 10px 10px 38px; border: 1px solid #e5e7eb; border-radius: 8px; outline: none; font-size: 13px; }
        
        .actions-btn { display: flex; gap: 10px; align-items: center; }
        .btn { padding: 8px 16px; border: 1px solid #e5e7eb; border-radius: 8px; background-color: #ffffff; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 8px; text-decoration: none; color: #1f2937; }
        .select-filter { padding: 8px 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 13px; outline: none; background: white; cursor: pointer; }
        .export-btn { background-color: #f43f5e; color: white; border: none; }
        .export-btn:hover { background-color: #e11d48; }

        /* INVOICE TABLE */
        .invoice-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        .invoice-table th { background-color: #f9fafb; padding: 12px 15px; color: #4b5563; font-weight: 500; border-bottom: 1px solid #e5e7eb; }
        .invoice-table td { padding: 15px; border-bottom: 1px solid #e5e7eb; }
        .invoice-table tr:hover { background-color: #f9fafb; }

        /* BADGES */
        .status { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; text-transform: capitalize; }
        .paid { background-color: #d1fae5; color: #065f46; }
        .approved { background-color: #d1fae5; color: #065f46; }
        .completed { background-color: #d1fae5; color: #065f46; }
        .pending-status { background-color: #fef3c7; color: #92400e; }
        
        .view-btn { background: none; border: none; color: #4b5563; cursor: pointer; font-size: 16px; }
        .view-btn:hover { color: #f43f5e; }
    </style>
</head>
<body>

    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <h2>Glow & Grace</h2>
            </div>
            <nav class="menu">
                <a href="admindashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                <a href="admin appointment.php"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
                <a href="service management.php"><i class="fa-solid fa-scissors"></i> Service Management</a>
                <a href="stylist management.php"><i class="fa-solid fa-users-gear"></i> Stylist Management</a>
                <a href="master calendar.php"><i class="fa-solid fa-calendar-days"></i> Master Calendar</a>
                <a href="customers.php"><i class="fa-solid fa-user-group"></i> Customers (CRM)</a>
                <a href="payment invoicing.php" class="active"><i class="fa-solid fa-file-invoice-dollar"></i> Payments & Invoices</a>
                <a href="setting.php"><i class="fa-solid fa-gear"></i> General Settings</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="title-area">
                    <h1>Payments & Invoices</h1>
                    <p>Track transactions, manage billing, and view sales history.</p>
                </div>
                <div class="admin-profile">
                    <div class="admin-info">
                        <h4>Admin Manager</h4>
                        <span>Super Admin</span>
                    </div>
                </div>
            </header>

            <section class="stats-container">
                <a href="payment invoicing.php?filter=paid" class="card">
                    <div class="card-icon income"><i class="fa-solid fa-wallet"></i></div>
                    <div class="card-data">
                        <h3>LKR <?php echo number_format($total_revenue); ?></h3>
                        <p>Total Revenue (Paid/Approved)</p>
                    </div>
                </a>
                <a href="payment invoicing.php?filter=pending" class="card">
                    <div class="card-icon pending"><i class="fa-solid fa-clock"></i></div>
                    <div class="card-data">
                        <h3><?php echo $pending_invoices; ?></h3>
                        <p>Pending Invoices</p>
                    </div>
                </a>
                <a href="payment invoicing.php?filter=all" class="card">
                    <div class="card-icon success-rate"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="card-data">
                        <h3><?php echo $success_rate; ?>%</h3>
                        <p>Payment Success Rate</p>
                    </div>
                </a>
            </section>

            <section class="table-section">
                <div class="table-controls">
                    <form method="GET" action="payment invoicing.php" class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" value="<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>" placeholder="Press Enter to search by client name, ID...">
                        <?php if(isset($_GET['filter'])): ?>
                            <input type="hidden" name="filter" value="<?php echo htmlspecialchars($_GET['filter']); ?>">
                        <?php endif; ?>
                    </form>
                    
                    <div class="actions-btn">
                        <select class="select-filter" onchange="location = this.value;">
                            <option value="payment invoicing.php?filter=all" <?php echo $filter == 'all' ? 'selected' : ''; ?>>All Invoices</option>
                            <option value="payment invoicing.php?filter=paid" <?php echo $filter == 'paid' ? 'selected' : ''; ?>>Paid / Approved</option>
                            <option value="payment invoicing.php?filter=pending" <?php echo $filter == 'pending' ? 'selected' : ''; ?>>Pending Only</option>
                        </select>
                        
                        <a href="payment invoicing.php?action=export_csv" class="btn export-btn"><i class="fa-solid fa-download"></i> Export CSV</a>
                    </div>
                </div>

                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Client Name</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($table_result && $table_result->num_rows > 0) {
                            while ($row = $table_result->fetch_assoc()) {
                                $invoice_id = "#INV-" . str_pad($row['appointment_id'], 4, "0", STR_PAD_LEFT);
                                $status_lower = strtolower($row['status']);
                                $status_class = ($status_lower == 'pending') ? 'pending-status' : 'paid';
                                $amount = $row['amount'] ? "LKR " . number_format($row['amount']) : "LKR 0";
                                ?>
                                <tr>
                                    <td><?php echo $invoice_id; ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['fullname']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['service']); ?></td>
                                    <td><?php echo $amount; ?></td>
                                    <td><span class="status <?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                                    <td><?php echo (!empty($row['booking_date'])) ? date('M d, Y', strtotime($row['booking_date'])) : 'N/A'; ?></td>
                                    <td>
                                        <button class="view-btn" onclick="alert('Viewing invoice: <?php echo $invoice_id; ?>\nClient: <?php echo htmlspecialchars($row['fullname']); ?>\nService: <?php echo htmlspecialchars($row['service']); ?>\nAmount: <?php echo $amount; ?>')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' style='text-align:center; color:#888;'>No invoices found matching the criteria.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

</body>
</html>
<?php $conn->close(); ?>