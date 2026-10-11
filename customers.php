<?php
$host = "localhost";
$username = "root"; 
$password = "";     
$dbname = "glow_and_grace"; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM - Manage Customers | Glow & Grace</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="crm-style.css">
</head>
<style>
    /* Google Fonts Import */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f8f9fa;
    color: #333;
}
/* SIDEBAR LAYOUT */
.sidebar {
    width: 260px;
    background-color: #1a1a2e;
    color: #fff;
    padding: 20px;
    display: flex;
    flex-direction: column;
}

.sidebar .logo {
    padding: 15px 10px;
    margin-bottom: 30px;
    border-bottom: 1px solid #2e2e4f;
}

.sidebar .logo h2 {
    font-size: 1.3rem;
    color: #ff758f;
}

.nav-links a {
    color: #b0b0d0;
    text-decoration: none;
    padding: 12px 15px;
    border-radius: 8px;
    font-size: 0.95rem;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
}

.nav-links a:hover, .nav-links a.active {
    background-color: #ff758f;
    color: #fff;
}
/* Master Admin Framework Layout Dashboard */
.dashboard-container {
    display: flex;
    min-height: 100vh;
}

/* Administrative Sidebar Layout CSS */
.sidebar {
    width: 260px;
    background-color: #2c231e;
    color: #ffffff;
    padding: 30px 20px;
    display: flex;
    flex-direction: column;
}

.sidebar-brand h2 {
    color: #d63384;
    font-size: 22px;
    font-weight: 700;
}

.admin-badge {
    font-size: 11px;
    background: rgba(214, 51, 132, 0.2);
    color: #d63384;
    padding: 3px 8px;
    border-radius: 4px;
    font-weight: 600;
    display: inline-block;
    margin-top: 4px;
}

.sidebar-menu {
    list-style: none;
    margin-top: 50px;
}

.sidebar-menu li {
    margin-bottom: 15px;
}

.sidebar-menu li a {
    color: #bbb;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 15px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
}

.sidebar-menu li a:hover, 
.sidebar-menu li a.active {
    background-color: #d63384;
    color: #ffffff;
}

.sidebar-menu li.logout {
    margin-top: auto;
}

/* Dashboard Content Area Outer Boundaries */
.main-content {
    flex: 1;
    padding: 40px;
    background-color: #fdfaf7;
    overflow-x: hidden;
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 35px;
}

.header-title h1 {
    font-size: 26px;
    color: #2c231e;
    margin-bottom: 5px;
}

.header-title p {
    color: #777;
    font-size: 14px;
}

.admin-profile {
    display: flex;
    align-items: center;
    gap: 20px;
}

.notification-icon {
    font-size: 20px;
    color: #666;
    cursor: pointer;
}

.profile-info h4 {
    font-size: 14px;
    color: #2c231e;
}

.profile-info p {
    font-size: 12px;
    color: #888;
}

/* CRM Metric Top Overview Cards layout block */
.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 25px;
    margin-bottom: 35px;
}

.metric-card {
    background: #ffffff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.01);
    border: 1px solid #f1f1f1;
    display: flex;
    align-items: center;
    gap: 20px;
}

.metric-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.bg-pink { background: #ffeef5; color: #d63384; }
.bg-green { background: #e8fbe8; color: #2ecc71; }
.bg-blue { background: #e8f4fd; color: #3498db; }

.metric-info h3 {
    font-size: 24px;
    color: #2c231e;
}

.metric-info p {
    font-size: 13px;
    color: #777;
}

/* CRM Layout Table Content Card Base container */
.crm-table-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.02);
    border: 1px solid #f1f1f1;
}

/* Toolbar Controls Section Wrapper rules layout */
.table-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 25px;
}

.search-box {
    position: relative;
    max-width: 400px;
    width: 100%;
}

.search-box i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
}

.search-box input {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 1px solid #e5dad5;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: 0.3s;
}

.search-box input:focus {
    border-color: #d63384;
    box-shadow: 0 0 0 3px rgba(214, 51, 132, 0.1);
}

.toolbar-actions {
    display: flex;
    gap: 12px;
}

.btn {
    padding: 11px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: 0.3s;
}

.btn-primary { background: #d63384; color: #fff; }
.btn-primary:hover { background: #b8236c; }
.btn-secondary { background: #f1f2f6; color: #4b5563; }
.btn-secondary:hover { background: #e4e5ea; }

/* Structural Grid Architecture Data Table Design rules styles */
.table-responsive {
    overflow-x: auto;
}

.crm-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.crm-table th {
    background-color: #faf6f5;
    color: #7a716c;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    padding: 15px 20px;
    border-bottom: 2px solid #eee7e4;
}

.crm-table td {
    padding: 18px 20px;
    border-bottom: 1px solid #f5eee8;
    font-size: 14px;
    color: #444;
}

.crm-table tbody tr:hover {
    background-color: #fffbfc;
}

/* User Identity Card Box components element inside cells */
.client-profile-cell {
    display: flex;
    align-items: center;
    gap: 15px;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #ffeef5;
    color: #d63384;
    font-weight: 600;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-dark-avatar {
    background-color: #e8f4fd;
    color: #3498db;
}

.client-meta h4 {
    font-size: 15px;
    color: #2c231e;
    font-weight: 600;
}

.client-meta p {
    font-size: 12px;
    color: #777;
}

.gender-txt {
    color: #666;
}

/* System Status Badges markers elements specs rules */
.status-badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.status-badge.active { background: #e8fbe8; color: #2ecc71; }
.status-badge.inactive { background: #f3f4f6; color: #9ca3af; }

.action-btn {
    background: transparent;
    border: none;
    color: #aaa;
    cursor: pointer;
    font-size: 16px;
    padding: 5px 10px;
    transition: 0.3s;
}

.action-btn:hover { color: #d63384; }
.text-center { text-center: center; }

/* Footnotes Pagination Area Control bar section layouts rules */
.table-pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 25px;
    padding-top: 15px;
    border-top: 1px solid #f5eee8;
    color: #777;
    font-size: 13px;
}

.pagination-buttons {
    display: flex;
    gap: 6px;
}

.page-btn {
    width: 35px;
    height: 35px;
    border-radius: 6px;
    border: 1px solid #e5dad5;
    background: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    transition: 0.3s;
}

.page-btn:hover:not(.disabled) {
    border-color: #d63384;
    color: #d63384;
}

.active-page {
    background: #d63384 !important;
    border-color: #d63384 !important;
    color: #fff !important;
}

.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsiveness break thresholds configurations rule blocks */
@media (max-width: 992px) {
    .dashboard-container { flex-direction: column; }
    .sidebar { width: 100%; }
}
</style>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <h2>Glow & Grace</h2>
                <span class="admin-badge">Admin Panel</span>
            </div>
             <nav class="nav-links">
                <a href="admindashboard.php" class="active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                <a href="admin appointment.php"><i class="fa-solid fa-appointment"></i> Appointments</a>
                <a href="service management.php"><i class="fa-solid fa-scissors"></i> Service Management</a>
                <a href="stylish management.php"><i class="fa-solid fa-users"></i> Stylist Management</a>
                <a href="master calenter.php"><i class="fa-solid fa-calendar-days"></i> Master Calendar</a>
                <a href="customers.php"><i class="fa-solid fa-address-book"></i> Customers (CRM)</a>
                <a href="payment invoicing.php"><i class="fa-solid fa-file-invoice-dollar"></i> Payments & Invoices</a>
                <a href="setting.php"><i class="fa-solid fa-sliders"></i> General Settings</a>
            </nav>
        </aside>


        <main class="main-content">
            <header class="content-header">
                <div class="header-title">
                    <h1>Customer Relationship Management (CRM)</h1>
                    <p>View client profiles, transaction history, and communication channels.</p>
                </div>
                <div class="admin-profile">
                    <i class="fas fa-bell notification-icon"></i>
                    <div class="profile-info">
                        <h4>Admin Manager</h4>
                        <p>Super Admin</p>
                    </div>
                </div>
            </header>

            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon bg-pink"><i class="fas fa-users"></i></div>
                    <div class="metric-info">
                        <h3></h3>
                        <p>Total Registered Clients</p>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon bg-green"><i class="fas fa-user-plus"></i></div>
                    <div class="metric-info">
                        <h3></h3>
                        <p>New This Month</p>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon bg-blue"><i class="fas fa-smile"></i></div>
                    <div class="metric-info">
                        <h3></h3>
                        <p>Retention Rate</p>
                    </div>
                </div>
            </div>

            <div class="crm-table-card">
                <div class="table-toolbar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search customers by name, email, or phone...">
                    </div>
                    <div class="toolbar-actions">
                        <button class="btn btn-secondary"><i class="fas fa-filter"></i> Filter</button>
                        <button class="btn btn-primary"><i class="fas fa-download"></i> Export CSV</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="crm-table">
                        <thead>
                            <tr>
                                <th>Client Profile</th>
                                <th>Phone Number</th>
                                <th>Gender</th>
                                <th>Total Bookings</th>
                                <th>Status</th>
                                <th>Registered Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="client-profile-cell">
                                        <div class="avatar">FR</div>
                                        <div class="client-meta">
                                            <h4>Fatima Risfa</h4>
                                            <p>fatima@gmail.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td>0771234567</td>
                                <td><span class="gender-txt">Female</span></td>
                                <td><strong>12 Appointments</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>June 02, 2026</td>
                                <td class="text-center">
                                    <div class="action-dropdown">
                                        <button class="action-btn"><i class="fas fa-ellipsis-v"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="client-profile-cell">
                                        <div class="avatar">NA</div>
                                        <div class="client-meta">
                                            <h4>Nimra Anver</h4>
                                            <p>nimra99@gmail.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td>0769876543</td>
                                <td><span class="gender-txt">Female</span></td>
                                <td><strong>5 Appointments</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>May 18, 2026</td>
                                <td class="text-center">
                                    <div class="action-dropdown">
                                        <button class="action-btn"><i class="fas fa-ellipsis-v"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="client-profile-cell">
                                        <div class="avatar bg-dark-avatar">MS</div>
                                        <div class="client-meta">
                                            <h4>Haadiya Maryam</h4>
                                            <p>haadiya@gmail.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td>0714567890</td>
                                <td><span class="gender-txt">Male</span></td>
                                <td><strong>2 Appointments</strong></td>
                                <td><span class="status-badge inactive">Inactive</span></td>
                                <td>April 11, 2026</td>
                                <td class="text-center">
                                    <div class="action-dropdown">
                                        <button class="action-btn"><i class="fas fa-ellipsis-v"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-pagination">
                    <p>Showing 1 to 3 of 1,248 entries</p>
                    <div class="pagination-buttons">
                        <button class="page-btn disabled"><i class="fas fa-chevron-left"></i></button>
                        <button class="page-btn active-page">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>