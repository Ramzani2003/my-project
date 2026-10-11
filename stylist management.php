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

// ALTER TABLE QUERY (முக்கியம்: உங்கள் டேபிளில் இந்த காலம் இல்லை என்றால், இதை ஒருமுறை இயக்கவும்)
// $conn->query("ALTER TABLE stylists ADD COLUMN working_days_json TEXT NULL AFTER categories");

// Handle Request: Delete Stylist
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if ($delete_id > 0) {
        $stmt = $conn->prepare("DELETE FROM stylists WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: stylist management.php");
    exit();
}

// Handle Request: Cancel Leave
if (isset($_GET['cancel_leave'])) {
    $cancel_id = intval($_GET['cancel_leave']);
    if ($cancel_id > 0) {
        $stmt = $conn->prepare("UPDATE stylists SET status = 'Active' WHERE id = ?");
        $stmt->bind_param("i", $cancel_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: stylist management.php");
    exit();
}

// 1. Handle Form Request: Add New Stylist
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_add_staff'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role_title = $_POST['role_title'];
    
    // Process Selected Working Days & Times
    $availability = [];
    if(isset($_POST['working_days'])) {
        foreach($_POST['working_days'] as $day) {
            $start_time = !empty($_POST['start_'.$day]) ? $_POST['start_'.$day] : '09:00';
            $end_time = !empty($_POST['end_'.$day]) ? $_POST['end_'.$day] : '18:00';
            $availability[$day] = [
                'start' => $start_time,
                'end' => $end_time
            ];
        }
    }
    $working_days_json = json_encode($availability);
    
    // Process selected category tags
    $categories_arr = isset($_POST['categories']) ? $_POST['categories'] : [];
    $categories_str = implode(', ', $categories_arr);
    
    // Assign a fallback avatar asset placeholder
    $image_url = 'default-avatar.jpg'; 
    
    // Default fallback values for legacy columns
    $shift_start = '09:00';
    $shift_end = '18:00';
    
    $stmt = $conn->prepare("INSERT INTO stylists (first_name, last_name, role_title, shift_start, shift_end, image_url, categories, working_days_json, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Active')");
    $stmt->bind_param("ssssssss", $first_name, $last_name, $role_title, $shift_start, $shift_end, $image_url, $categories_str, $working_days_json);
    $stmt->execute();
    $stmt->close();
    header("Location: stylist management.php");
    exit();
}

// 2. Handle Form Request: Record Staff Absence
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action_record_leave'])) {
    $staff_id = intval($_POST['staff_id']);
    if ($staff_id > 0) {
        $stmt = $conn->prepare("UPDATE stylists SET status = 'On Leave Today' WHERE id = ?");
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: stylist management.php");
    exit();
}

// Fetch all staff members to show in your dashboard layout grid
$query = "SELECT * FROM stylists ORDER BY id DESC";
$staff_result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management - Beauty Parlor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
body { background-color: #f7f9fc; color: #333; }
.dashboard-container { display: flex; min-height: 100vh; }
.sidebar { width: 260px; background-color: #1a1a2e; color: #fff; padding: 20px; display: flex; flex-direction: column; }
.sidebar .logo { padding: 15px 10px; margin-bottom: 30px; border-bottom: 1px solid #2e2e4f; }
.sidebar .logo h2 { font-size: 1.3rem; color: #ff758f; }
.nav-links a { color: #b0b0d0; text-decoration: none; padding: 12px 15px; border-radius: 8px; font-size: 0.95rem; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; }
.nav-links a:hover, .nav-links a.active { background-color: #ff758f; color: #fff; }
.main-content { flex: 1; padding: 40px; }
.main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
.main-header h1 { font-size: 1.8rem; color: #1a1a2e; }
.subtitle { font-size: 0.9rem; color: #777; }
.header-buttons { display: flex; gap: 12px; }
.btn-primary { background-color: #ff758f; color: white; border: none; padding: 11px 20px; border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; }
.btn-primary:hover { background-color: #e0536e; }
.btn-secondary-outline { background: transparent; border: 1px solid #ced4da; color: #495057; padding: 11px 20px; border-radius: 8px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; background-color: #fff; }
.btn-secondary-outline:hover { background-color: #f8fafc; }

.staff-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; }
.staff-card { background-color: #fff; border-radius: 12px; padding: 24px; position: relative; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02); border: 1px solid #edf2f7; display: flex; flex-direction: column; align-items: center; text-align: center; }

.status-indicator { position: absolute; top: 15px; right: 15px; font-size: 0.75rem; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
.active-status { background-color: #e8f5e9; color: #2e7d32; }
.leave-status { background-color: #ffebee; color: #c62828; }

.staff-profile-header { margin-bottom: 20px; }
.avatar { width: 85px; height: 85px; border-radius: 50%; object-fit: cover; margin-bottom: 12px; border: 3px solid #f0f2f5; }
.staff-profile-header h3 { font-size: 1.15rem; color: #1a1a2e; }
.role-title { font-size: 0.85rem; color: #ff758f; font-weight: 500; }

.staff-details { width: 100%; border-top: 1px solid #f0f2f5; padding-top: 15px; margin-bottom: 20px; text-align: left; }
.detail-item { margin-bottom: 12px; font-size: 0.85rem; }
.detail-item .label { color: #777; display: block; margin-bottom: 5px; font-weight: 600; }
.skills-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px; }
.skills-tags .tag { background-color: #f1f3f5; color: #495057; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; }

/* Dynamic Schedule Grid Styling */
.availability-schedule { display: flex; flex-direction: column; gap: 4px; background: #f8fafc; padding: 8px; border-radius: 6px; border: 1px solid #eef2f6; }
.schedule-row { display: flex; justify-content: space-between; font-size: 0.75rem; color: #4a5568; padding: 2px 0; border-bottom: 1px dashed #e2e8f0; }
.schedule-row:last-child { border-bottom: none; }
.schedule-day { font-weight: 600; color: #1a1a2e; }
.schedule-time { color: #495057; }

.card-footer { width: 100%; display: flex; gap: 6px; margin-top: auto; }
.card-footer button, .card-footer a { flex: 1; height: 36px; padding: 0 4px; font-size: 0.8rem; font-weight: 500; border-radius: 6px; cursor: pointer; border: none; text-decoration: none; text-align: center; display: inline-flex; align-items: center; justify-content: center; gap: 4px; white-space: nowrap; }
.btn-edit-staff { background-color: #f0f2f5; color: #495057; }
.btn-status-toggle { background-color: #fff5f5; color: #e03131; }
.clear-leave { background-color: #e8f5e9; color: #2e7d32; }
.btn-delete-staff { background-color: #ffebee; color: #c62828; }

.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4); display: none; justify-content: center; align-items: center; z-index: 1000; overflow-y: auto; padding: 20px 0; }
.modal-box { background-color: #fff; width: 580px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); animation: slideUp 0.3s ease; max-height: 90vh; overflow-y: auto; }
@keyframes slideUp { from { transform: translateY(15px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.modal-header { padding: 20px; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; }
.modal-header h2 { font-size: 1.2rem; color: #1a1a2e; }
.close-btn { background: none; border: none; font-size: 1.6rem; cursor: pointer; color: #aaa; }
.modal-form { padding: 20px; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 0.85rem; font-weight: 500; margin-bottom: 6px; color: #444; }
.form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #dddfeb; border-radius: 6px; outline: none; }
.form-row { display: flex; gap: 15px; }
.form-row .form-group { flex: 1; }
.checkbox-group { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; padding-top: 4px; }
.checkbox-group label { font-weight: 400; font-size: 0.85rem; display: flex; align-items: center; gap: 6px; cursor: pointer; }

/* Day-wise Time Settings Styling */
.day-time-selector { display: flex; flex-direction: column; gap: 10px; margin-top: 8px; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; }
.day-time-row { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 4px 0; }
.day-checkbox { display: flex; align-items: center; gap: 8px; width: 120px; font-size: 0.85rem; }
.time-inputs { display: flex; align-items: center; gap: 5px; }
.time-inputs input[type="time"] { padding: 5px 8px; font-size: 0.8rem; border: 1px solid #cbd5e1; border-radius: 4px; width: 105px; }

.form-buttons { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
.btn-cancel { background-color: #f0f2f5; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; color: #555; }
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
                <div>
                    <h1>Stylist & Staff Management</h1>
                    <p class="subtitle">Manage profiles, weekly work days availability, and configurations</p>
                </div>
                <div class="header-buttons">
                    <button class="btn-secondary-outline" onclick="toggleLeaveModal(true)">
                        <i class="fa-solid fa-calendar-minus"></i> Record Staff Leave
                    </button>
                    <button class="btn-primary" onclick="toggleStaffModal(true)">
                        <i class="fa-solid fa-user-plus"></i> Add New Stylist
                    </button>
                </div>
            </header>

            <section class="staff-grid">
                <?php 
                $dropdown_members = [];
                if ($staff_result && $staff_result->num_rows > 0): 
                    while($row = $staff_result->fetch_assoc()): 
                        $dropdown_members[] = $row;
                        $status_class = ($row['status'] == 'On Leave Today') ? 'leave-mode' : '';
                        $badge_class = ($row['status'] == 'On Leave Today') ? 'leave-status' : 'active-status';
                ?>
                <div class="staff-card <?php echo $status_class; ?>">
                    <div class="status-indicator <?php echo $badge_class; ?>"><?php echo htmlspecialchars($row['status']); ?></div>
                    <div class="staff-profile-header">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['first_name']); ?>" class="avatar">
                        <h3><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h3>
                        <p class="role-title"><?php echo htmlspecialchars($row['role_title']); ?></p>
                    </div>
                    <div class="staff-details">
                        <div class="detail-item">
                            <span class="label"><i class="fa-solid fa-clock"></i> Weekly Availability:</span>
                            <div class="availability-schedule">
                                <?php 
    $schedule = isset($row['working_days_json']) ? json_decode($row['working_days_json'], true) : null;
        if (!empty($schedule)) {
            foreach ($schedule as $day => $times) {
                $formatted_start = date("g:i A", strtotime($times['start']));
                $formatted_end = date("g:i A", strtotime($times['end']));
                echo '<div class="schedule-row">';
                echo '<span class="schedule-day">' . htmlspecialchars($day) . '</span>';
                echo '<span class="schedule-time">' . $formatted_start . ' - ' . $formatted_end . '</span>';
                echo '</div>';
            }
        } else {
            // Fallback for older items before database upgrade
            $old_start = date("g:i A", strtotime($row['shift_start'] ?? '09:00'));
            $old_end = date("g:i A", strtotime($row['shift_end'] ?? '18:00'));
            echo '<div class="schedule-row">';
            echo '<span class="schedule-day">Mon - Sat</span>';
            echo '<span class="schedule-time">' . $old_start . ' - ' . $old_end . '</span>';
            echo '</div>';
        }
        ?> 
                            </div>
                        </div>
                        <div class="detail-item">
                            <span class="label"><i class="fa-solid fa-tags"></i> Categories:</span>
                            <div class="skills-tags">
                                <?php 
                                $tags = explode(',', $row['categories']);
                                foreach($tags as $tag) {
                                    if(trim($tag) != '') {
                                        echo '<span class="tag">' . htmlspecialchars(trim($tag)) . '</span>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="edit_stylist.php?id=<?php echo $row['id']; ?>" class="btn-edit-staff"><i class="fa-solid fa-user-pen"></i> Edit</a>
                        
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn-delete-staff" onclick="return confirm('Are you sure you want to delete this stylist profile?');"><i class="fa-solid fa-trash-can"></i> Delete</a>
                        
                        <?php if($row['status'] == 'On Leave Today'): ?>
                            <button class="btn-status-toggle clear-leave" onclick="window.location.href='?cancel_leave=<?php echo $row['id']; ?>'">Cancel Leave</button>
                        <?php else: ?>
                            <button class="btn-status-toggle">Mark Inactive</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php 
                    endwhile; 
                else: 
                ?>
                    <p style="grid-column:1/-1; text-align:center; color:#999;">No staff profiles found.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <div class="modal-overlay" id="staffModal">
        <div class="modal-box">
            <div class="modal-header">
                <h2>Add New Staff Profile</h2>
                <button class="close-btn" onclick="toggleStaffModal(false)">&times;</button>
            </div>
            <form class="modal-form" method="POST" action="stylist management.php">
                <input type="hidden" name="action_add_staff" value="1">
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" placeholder="e.g., Priya" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" placeholder="e.g., Sharma" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Role/Title</label>
                    <input type="text" name="role_title" placeholder="e.g., Senior Makeup Artist" required>
                </div>

                <div class="form-group">
                    <label>Working Days & Custom Time Slots</label>
                    <div class="day-time-selector">
                        <?php 
                        $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        foreach($days_of_week as $day):
                        ?>
                        <div class="day-time-row">
                            <div class="day-checkbox">
                                <input type="checkbox" name="working_days[]" value="<?php echo $day; ?>" id="chk_<?php echo $day; ?>" checked>
                                <label style="margin-bottom:0;" for="chk_<?php echo $day; ?>"><?php echo $day; ?></label>
                            </div>
                            <div class="time-inputs">
                                <input type="time" name="start_<?php echo $day; ?>" value="09:00">
                                <span>to</span>
                                <input type="time" name="end_<?php echo $day; ?>" value="18:00">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label>Assigned Categories</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="categories[]" value="Hair Care"> Hair Care</label>
                        <label><input type="checkbox" name="categories[]" value="Makeup & Bridal"> Makeup & Bridal</label>
                        <label><input type="checkbox" name="categories[]" value="Skin/Facial"> Skin/Facial</label>
                        <label><input type="checkbox" name="categories[]" value="Nail Artistry"> Nail Artistry</label>
                    </div>
                </div>
                <div class="form-buttons">
                    <button type="button" class="btn-cancel" onclick="toggleStaffModal(false)">Cancel</button>
                    <button type="submit" class="btn-primary">Save Profile</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="leaveModal">
        <div class="modal-box">
            <div class="modal-header">
                <h2>Record Staff Absence / Leave</h2>
                <button class="close-btn" onclick="toggleLeaveModal(false)">&times;</button>
            </div>
            <form class="modal-form" method="POST" action="stylist management.php">
                <input type="hidden" name="action_record_leave" value="1">
                <div class="form-group">
                    <label>Select Staff Member</label>
                    <select name="staff_id" required>
                        <option value="">Choose Staff...</option>
                        <?php foreach($dropdown_members as $member): ?>
                            <option value="<?php echo $member['id']; ?>"><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Leave Date</label>
                    <input type="date" required>
                </div>
                <div class="form-group">
                    <label>Reason (Optional)</label>
                    <input type="text" placeholder="e.g., Sick leave, Vacation">
                </div>
                <div class="form-buttons">
                    <button type="button" class="btn-cancel" onclick="toggleLeaveModal(false)">Cancel</button>
                    <button type="submit" class="btn-primary">Block Schedule Slot</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleStaffModal(show) {
            document.getElementById('staffModal').style.display = show ? 'flex' : 'none';
        }
        function toggleLeaveModal(show) {
            document.getElementById('leaveModal').style.display = show ? 'flex' : 'none';
        }
    </script>
</body>
</html>