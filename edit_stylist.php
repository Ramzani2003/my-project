<?php 
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beauty_parlor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the Stylist ID from the URL
$stylist_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($stylist_id <= 0) {
    header("Location: stylist management.php");
    exit();
}

// Handle Form Submission: Update Stylist Details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_edit_staff'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role_title = $_POST['role_title'];
    $shift_start = $_POST['shift_start'];
    $shift_end = $_POST['shift_end'];
    $status = $_POST['status'];
    
    // Process selected category tags
    $categories_arr = isset($_POST['categories']) ? $_POST['categories'] : [];
    $categories_str = implode(', ', $categories_arr);
    
    $stmt = $conn->prepare("UPDATE stylists SET first_name = ?, last_name = ?, role_title = ?, shift_start = ?, shift_end = ?, categories = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $first_name, $last_name, $role_title, $shift_start, $shift_end, $categories_str, $status, $stylist_id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: stylist management.php");
    exit();
}

// Fetch the current information for this specific stylist
$stmt = $conn->prepare("SELECT * FROM stylists WHERE id = ?");
$stmt->bind_param("i", $stylist_id);
$stmt->execute();
$result = $stmt->get_result();
$stylist = $result->fetch_assoc();
$stmt->close();

// If stylist doesn't exist, redirect back
if (!$stylist) {
    header("Location: stylist management.php");
    exit();
}

// Parse current categories into an array to check them in inputs
$current_categories = array_map('trim', explode(',', $stylist['categories']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stylist Profile - Beauty Parlor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f7f9fc;
    color: #333;
}

.dashboard-container {
    display: flex;
    min-height: 100vh;
}

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
}

.nav-links a:hover, .nav-links a.active {
    background-color: #ff758f;
    color: #fff;
}

.main-content {
    flex: 1;
    padding: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.edit-card-container {
    background-color: #fff;
    width: 100%;
    max-width: 600px;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    border: 1px solid #edf2f7;
    margin-top: 20px;
}

.main-header {
    width: 100%;
    max-width: 600px;
    margin-bottom: 20px;
    text-align: left;
}

.main-header h1 {
    font-size: 1.8rem;
    color: #1a1a2e;
}

.subtitle {
    font-size: 0.9rem;
    color: #777;
}

.form-group { margin-bottom: 20px; }
.form-group label { display: block; font-size: 0.85rem; font-weight: 500; margin-bottom: 6px; color: #444; }

.form-group input, .form-group select {
    width: 100%; padding: 11px; border: 1px solid #dddfeb; border-radius: 6px; outline: none; font-size: 0.9rem;
}

.form-row { display: flex; gap: 15px; }
.form-row .form-group { flex: 1; }

.checkbox-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    padding-top: 4px;
}
.checkbox-group label {
    font-weight: 400;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
}

.form-buttons {
    display: flex; justify-content: flex-end; gap: 12px; margin-top: 30px;
}

.btn-primary {
    background-color: #ff758f;
    color: white;
    border: none;
    padding: 11px 24px;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
}
.btn-primary:hover { background-color: #e0536e; }

.btn-cancel { 
    background-color: #f0f2f5; 
    border: none; 
    padding: 11px 24px; 
    border-radius: 8px; 
    cursor: pointer; 
    color: #555;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}
</style>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">
                <h2><i class="fa-solid fa-wand-magic-sparkles"></i> GlowAdmin</h2>
            </div>
            <nav class="nav-links">
                <a href="admindashboard.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                <a href="admin appointment.php"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
                <a href="service management.php"><i class="fa-solid fa-scissors"></i> Service Management</a>
                <a href="stylist management.php" class="active"><i class="fa-solid fa-users"></i> Stylist Management</a>
                <a href="master calenter.php"><i class="fa-solid fa-calendar-days"></i> Master Calendar</a>
                <a href="customers.php"><i class="fa-solid fa-address-book"></i> Customers (CRM)</a>
                <a href="payment invoicing.php"><i class="fa-solid fa-file-invoice-dollar"></i> Payments & Invoices</a>
                <a href="setting.php"><i class="fa-solid fa-sliders"></i> General Settings</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h1>Edit Stylist Profile</h1>
                <p class="subtitle">Modify roster settings, shift times, and service capability tags</p>
            </header>

            <div class="edit-card-container">
                <form method="POST" action="edit_stylist.php?id=<?php echo $stylist_id; ?>">
                    <input type="hidden" name="action_edit_staff" value="1">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" value="<?php echo htmlspecialchars($stylist['first_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" value="<?php echo htmlspecialchars($stylist['last_name']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Role / Title</label>
                        <input type="text" name="role_title" value="<?php echo htmlspecialchars($stylist['role_title']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Profile Status</label>
                        <select name="status" required>
                            <option value="Active" <?php echo ($stylist['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="On Leave Today" <?php echo ($stylist['status'] == 'On Leave Today') ? 'selected' : ''; ?>>On Leave Today</option>
                            <option value="Inactive" <?php echo ($stylist['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Shift Starts</label>
                            <input type="time" name="shift_start" value="<?php echo htmlspecialchars($stylist['shift_start']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Shift Ends</label>
                            <input type="time" name="shift_end" value="<?php echo htmlspecialchars($stylist['shift_end']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Assigned Categories</label>
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" name="categories[]" value="Hair Care" <?php echo in_array("Hair Care", $current_categories) ? 'checked' : ''; ?>> Hair Care
                            </label>
                            <label>
                                <input type="checkbox" name="categories[]" value="Makeup & Bridal" <?php echo in_array("Makeup & Bridal", $current_categories) ? 'checked' : ''; ?>> Makeup & Bridal
                            </label>
                            <label>
                                <input type="checkbox" name="categories[]" value="Skin/Facial" <?php echo in_array("Skin/Facial", $current_categories) ? 'checked' : ''; ?>> Skin/Facial
                            </label>
                            <label>
                                <input type="checkbox" name="categories[]" value="Nail Artistry" <?php echo in_array("Nail Artistry", $current_categories) ? 'checked' : ''; ?>> Nail Artistry
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-buttons">
                        <a href="stylist management.php" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>