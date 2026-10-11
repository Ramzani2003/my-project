<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beauty_parlor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$month = isset($_GET['month']) ? intval($_GET['month']) : intval(date('m'));
$year = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));


$prev_month = $month - 1;
$prev_year = $year;
if ($prev_month == 0) {
    $prev_month = 12;
    $prev_year--;
}

$next_month = $month + 1;
$next_year = $year;
if ($next_month == 13) {
    $next_month = 1;
    $next_year++;
}

$month_text = date('F', mktime(0, 0, 0, $month, 1, $year));

// காலெண்டர் கட்டங்களை உருவாக்குவதற்கான கணக்கீடுகள்
$num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$first_day_of_month = date('N', mktime(0, 0, 0, $month, 1, $year));

// ─── டேட்டாபேஸிலிருந்து நடப்பு மாதத்தின் அப்பாயிண்ட்மெண்ட்களை எடுத்தல் ───
$appointments = [];
$start_date = "$year-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-01";
$end_date = "$year-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad($num_days, 2, "0", STR_PAD_LEFT);

$sql = "SELECT appointment_id, fullname, service, stylist, booking_date, booking_time, status FROM tbl_appointment WHERE booking_date BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $row['booking_date'] = trim($row['booking_date']);
    $appointments[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Master Calendar | Glow & Grace</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f8f9fa; color: #333; min-height: 100vh; }
        .dashboard-container { display: flex; min-height: 100vh; width: 100%; }

        /* SIDEBAR STYLES */
        .sidebar { width: 280px; background-color: #1a1a2e; color: #fff; padding: 20px; display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar .logo { padding: 15px 10px; margin-bottom: 30px; border-bottom: 1px solid #2e2e4f; }
        .sidebar .logo h2 { font-size: 1.3rem; color: #ff758f; }
        .nav-links { display: flex; flex-direction: column; gap: 8px; }
        .nav-links a { color: #b0b0d0; text-decoration: none; padding: 12px 15px; border-radius: 8px; font-size: 0.95rem; display: flex; align-items: center; gap: 12px; }
        .nav-links a:hover, .nav-links a.active { background-color: #ff758f; color: #fff; }

        /* MAIN CONTENT */
        .main-content { flex: 1; padding: 40px; background-color: #fdfaf7; overflow-y: auto; }
        .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .header-title h1 { font-size: 28px; color: #2c231e; }
        .header-title p { color: #777; font-size: 14px; }

        /* GRID SYSTEM */
        .calendar-layout-grid { display: grid; grid-template-columns: 7fr 3fr; gap: 30px; align-items: start; }
        .calendar-card, .agenda-card { background: #ffffff; border-radius: 16px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.02); border: 1px solid #f1f1f1; }
        
        /* CALENDAR HEADER */
        .calendar-nav-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .nav-btn { background: #ffeef5; border: none; color: #d63384; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none; }
        .nav-btn:hover { background: #d63384; color: #ffffff; }

        /* CALENDAR MATRIX */
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 12px; text-align: center; }
        .day-name { font-weight: 600; color: #a09793; font-size: 14px; padding-bottom: 10px; }
        
        .day-cell { background: #fdfdfd; border: 1px solid #f3ece9; height: 75px; border-radius: 10px; padding: 8px; font-size: 14px; font-weight: 500; display: flex; flex-direction: column; justify-content: space-between; align-items: flex-end; cursor: pointer; transition: all 0.2s; }
        .day-cell:hover { border-color: #d63384; background: #fffbfd; }
        .empty-cell { background-color: #f9f9f9; border: 1px solid #eee; cursor: default; }
        .active-day { background-color: #ffeef5 !important; border-color: #d63384 !important; color: #d63384; font-weight: 700; }

        /* DOTS CONTAINER */
        .dots-container { width: 100%; display: flex; justify-content: flex-start; gap: 4px; overflow-x: auto; }
        .event-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
        .event-dot.approved { background-color: #4caf50; }
        .event-dot.pending { background-color: #ff9800; }
        .event-dot.completed { background-color: #2196f3; }

        /* AGENDA STYLES */
        .agenda-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f5ece9; padding-bottom: 15px; }
        .total-count { background: #ffeef5; color: #d63384; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .agenda-list { max-height: 450px; overflow-y: auto; }
        .agenda-item { padding: 15px; background: #fdfdfd; border-radius: 10px; border-left: 4px solid #ccc; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .agenda-item.status-approved { border-left-color: #4caf50; }
        .agenda-item.status-pending { border-left-color: #ff9800; }
        .agenda-item.status-completed { border-left-color: #2196f3; }
        .agenda-time { font-size: 12px; font-weight: 600; color: #d63384; margin-bottom: 5px; }
        .agenda-details h4 { font-size: 15px; color: #2c231e; margin-bottom: 5px; }
        .agenda-details p { font-size: 13px; color: #666; display: flex; align-items: center; gap: 8px; margin-bottom: 3px; }

        @media (max-width: 1024px) { .calendar-layout-grid { grid-template-columns: 1fr; } }
    </style>
</head>
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
                <a href="stylist management.php"><i class="fa-solid fa-users"></i> Stylist Management</a>
                <a href="master calendar.php" class="active"><i class="fa-solid fa-calendar-days"></i> Master Calendar</a>
                <a href="customers.php"><i class="fa-solid fa-address-book"></i> Customers (CRM)</a>
                <a href="payment invoicing.php"><i class="fa-solid fa-file-invoice-dollar"></i> Payments & Invoices</a>
                <a href="setting.php"><i class="fa-solid fa-sliders"></i> General Settings</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="content-header">
                <div class="header-title">
                    <h1>Master Booking Calendar</h1>
                    <p>Track, schedule, and manage salon appointments globally.</p>
                </div>
            </header>

            <div class="calendar-layout-grid">
                <div class="calendar-card">
                    <div class="calendar-nav-header">
                        <a href="?month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>" class="nav-btn"><i class="fas fa-chevron-left"></i></a>
                        <h2><?php echo "$month_text $year"; ?></h2>
                        <a href="?month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>" class="nav-btn"><i class="fas fa-chevron-right"></i></a>
                    </div>

                    <div class="calendar-grid">
                        <div class="day-name">Mon</div>
                        <div class="day-name">Tue</div>
                        <div class="day-name">Wed</div>
                        <div class="day-name">Thu</div>
                        <div class="day-name">Fri</div>
                        <div class="day-name">Sat</div>
                        <div class="day-name">Sun</div>

                        <?php
                        // மாதத்தின் முதல் நாள் தொடங்கும் கிழமைக்கு முந்தைய வெற்று கட்டங்களை நிரப்புதல்
                        for ($i = 1; $i < $first_day_of_month; $i++) {
                            echo '<div class="day-cell empty-cell"></div>';
                        }

                        // மாதத்தின் நாட்களை ஒவ்வொன்றாக உருவாக்குதல்
                        for ($day = 1; $day <= $num_days; $day++) {
                            $current_date_string = "$year-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT);
                            
                            // இந்த குறிப்பிட்ட தேதிக்கான அப்பாயிண்ட்மெண்ட்களை பிரித்தெடுத்தல்
                            $day_events = array_filter($appointments, function($app) use ($current_date_string) {
                                return $app['booking_date'] === $current_date_string;
                            });

                            $is_today = ($current_date_string == date('Y-m-d')) ? 'active-day' : '';
                            ?>
                            <div class="day-cell <?php echo $is_today; ?>" onclick="showAgenda('<?php echo $current_date_string; ?>', <?php echo htmlspecialchars(json_encode(array_values($day_events))); ?>)">
                                <span><?php echo $day; ?></span>
                                <div class="dots-container">
                                    <?php foreach ($day_events as $event): 
                                        $dot_status = strtolower($event['status']); ?>
                                        <span class="event-dot <?php echo $dot_status; ?>" title="<?php echo htmlspecialchars($event['fullname']); ?>"></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="agenda-card">
                    <div class="agenda-header">
                        <h3 id="agendaTitle">Schedule for Today</h3>
                        <span class="total-count" id="agendaCount">0 Bookings</span>
                    </div>

                    <div class="agenda-list" id="agendaContent">
                        <p style="text-align: center; color: #888; margin-top: 20px;">Click any date to view appointments.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // பக்கத்தை லோட் செய்யும் போது தற்போதைய மாதத்தின் இன்றைய தேதிக்கான விபரங்களை சரியாகக் காட்ட
        window.onload = function() {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            const todayStr = yyyy + '-' + mm + '-' + dd; // பிழை சரிசெய்யப்பட்டது (String Concatenation)

            const initialEvents = <?php echo json_encode($appointments); ?>;
            const todayEvents = initialEvents.filter(e => e.booking_date.trim() === todayStr);
            
            showAgenda(todayStr, todayEvents);
        };

        function showAgenda(dateString, events) {
            const options = { month: 'long', day: 'numeric', year: 'numeric' };
            const formattedDate = new Date(dateString).toLocaleDateString('en-US', options);
            
            document.getElementById('agendaTitle').innerText = "Schedule for " + formattedDate;
            document.getElementById('agendaCount').innerText = events.length + " Booking" + (events.length !== 1 ? "s" : "");

            const contentArea = document.getElementById('agendaContent');
            contentArea.innerHTML = "";

            if (events.length === 0) {
                // பிழை சரிசெய்யப்பட்டது (HTML-ஐ சுற்றி சிங்கிள் கோட்ஸ் சேர்க்கப்பட்டுள்ளது)
                contentArea.innerHTML = '<p style="text-align: center; color: #888; margin-top: 30px;"><i class="fa-regular fa-calendar-xmark" style="font-size: 24px; display:block; margin-bottom:10px;"></i> No appointments booked for this day.</p>';
                return;
            }

            events.forEach(event => {
                const statusClass = event.status.toLowerCase();
                contentArea.innerHTML += `
                    <div class="agenda-item status-${statusClass}">
                        <div class="agenda-time"><i class="fa-regular fa-clock"></i> ${event.booking_time}</div>
                        <div class="agenda-details">
                            <h4>${event.service}</h4>
                            <p><i class="fas fa-user"></i> Client: ${event.fullname}</p>
                            <p><i class="fas fa-user-sparkles"></i> Stylist: ${event.stylist}</p>
                            <p><i class="fa-solid fa-circle-info"></i> Status: <strong>${event.status}</strong></p>
                        </div>
                    </div>
                `;
            });
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>