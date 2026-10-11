<?php

$servername = "localhost";
$username = "root";       
$password = "";           
$dbname = "beauty_parlor"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$column_check = $conn->query("SHOW COLUMNS FROM tbl_appointment");
$id_column = "id"; 

if ($column_check) {
    $columns = [];
    while ($col_row = $column_check->fetch_assoc()) {
        $columns[] = strtolower($col_row['Field']);
    }
    
    
    if (in_array('id', $columns)) { $id_column = 'id'; }
    elseif (in_array('appointment_id', $columns)) { $id_column = 'appointment_id'; }
    elseif (in_array('apt_id', $columns)) { $id_column = 'apt_id'; }
    elseif (in_array('booking_id', $columns)) { $id_column = 'booking_id'; }
    else {
    
        $id_column = $columns[0]; 
    }
}




if (isset($_POST['update_status'])) {
    $id = intval($_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    
    $update_sql = "UPDATE tbl_appointment SET status='$status' WHERE $id_column=$id";
    if ($conn->query($update_sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    exit; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Manage Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            display: flex;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: #2c231e;
            min-height: 100vh;
            color: #fff;
            padding: 30px 20px;
        }

        .sidebar h2 {
            color: #d63384;
            margin-bottom: 40px;
            font-size: 24px;
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

        /* Main Content Container */
        .main-content {
            flex: 1;
            padding: 40px;
        }

        .header-title {
            font-size: 26px;
            margin-bottom: 30px;
            color: #2c231e;
        }

        /* Table Styling */
        .table-container {
            background-color: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        table th {
            background-color: #f8f9fa;
            padding: 15px;
            color: #555;
            font-weight: 600;
            border-bottom: 2px solid #eee;
        }

        table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            vertical-align: top;
        }

        .contact-info i, .date-info i {
            color: #d63384;
            margin-right: 5px;
            font-size: 12px;
        }

        /* Status Dropdown Styling */
        .status-select {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-weight: 600;
            outline: none;
            cursor: pointer;
        }

        .status-select[data-current="Approved"] { background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; }
        .status-select[data-current="Pending"] { background-color: #fff3cd; color: #664d03; border-color: #ffecb5; }
        .status-select[data-current="Cancelled"] { background-color: #f8d7da; color: #842029; border-color: #f5c2c7; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Glow & Grace</h2>
        <nav class="nav-links">
                <a href="admindashboard.php" class="active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                <a href="admin appointment.php"><i class="fa-solid fa-address-book"></i> Appointments</a>
                <a href="service management.php"><i class="fa-solid fa-scissors"></i> Service Management</a>
                <a href="stylist management.php"><i class="fa-solid fa-users"></i> Stylist Management</a>
                <a href="master calenter.php"><i class="fa-solid fa-calendar-days"></i> Master Calendar</a>
                <a href="customers.php"><i class="fa-solid Book"></i> Customers (CRM)</a>
                <a href="payment invoicing.php"><i class="fa-solid fa-file-invoice-dollar"></i> Payments & Invoices</a>
                <a href="setting.php"><i class="fa-solid fa-sliders"></i> General Settings</a>
            </nav>
    </div>

    <div class="main-content">
        <h2 class="header-title">Glow & Glamour | Appointment Management</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Contact Info</th>
                        <th>Service</th>
                        <th>Stylist</th>
                        <th>Date & Time</th>
                        <th>Notes</th>
                        <th>Status Selection (Action)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $sql = "SELECT * FROM tbl_appointment ORDER BY $id_column DESC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $current_status = (!empty($row['status'])) ? $row['status'] : 'Pending';
                            $display_id = $row[$id_column] ?? 0;
                            
                    
                            $customer_name = $row['fullname'] ?? $row['customer_name'] ?? $row['name'] ?? 'Unknown';
                            $phone = $row['phone'] ?? $row['mobile'] ?? '';
                            $email = $row['email'] ?? '';
                            $service = $row['service'] ?? $row['service_id'] ?? 'N/A';
                            $stylist = $row['stylist'] ?? $row['stylist_id'] ?? 'N/A';
                            $b_date = $row['booking_date'] ?? 'N/A';
                            $b_time = $row['booking_time'] ?? 'N/A';
                            $notes = $row['notes'] ?? '';

                            echo "<tr>";
                            echo "<td>#{$display_id}</td>";
                            echo "<td><strong>{$customer_name}</strong></td>";
                            echo "<td class='contact-info'>
                                    <i class='fas fa-phone'></i> {$phone}<br>
                                    <i class='fas fa-envelope'></i> {$email}
                                  </td>";
                            echo "<td>{$service}</td>";
                            echo "<td>{$stylist}</td>";
                            echo "<td class='date-info'>
                                    <i class='fas fa-calendar-alt'></i> {$b_date}<br>
                                    <i class='fas fa-clock'></i> {$b_time}
                                  </td>";
                            echo "<td>{$notes}</td>";
                            echo "<td>";
                            
                            
                            echo "<select class='status-select' data-id='{$display_id}' 
                                          data-current='{$current_status}' 
                                          data-phone='{$phone}' 
                                          data-name='{$customer_name}' 
                                          data-service='{$service}' 
                                          data-date='{$b_date}' 
                                          data-time='{$b_time}'>";
                            
                            $options = ['Pending', 'Approved', 'Cancelled'];
                            foreach ($options as $opt) {
                                $selected = ($current_status == $opt) ? 'selected' : '';
                                echo "<option value='{$opt}' {$selected}>{$opt}</option>";
                            }
                            
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center;'>No appointments found!</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    document.querySelectorAll('.status-select').forEach(select => {
        
        select.addEventListener('change', function() {
            const status = this.value; 
            const appointmentId = this.getAttribute('data-id');
            const customerName = this.getAttribute('data-name');
            let customerPhone = this.getAttribute('data-phone');
            const service = this.getAttribute('data-service');
            const date = this.getAttribute('data-date');
            const time = this.getAttribute('data-time');

            // 1. ஃபார்ம் டேட்டாவை தயார் செய்து டேட்டாபேஸை அப்டேட் செய்ய பின்னணிக்கு (AJAX) அனுப்புதல்
            const formData = new FormData();
            formData.append('update_status', true);
            formData.append('id', appointmentId);
            formData.append('status', status);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if(data.trim() === 'success') {
                    this.setAttribute('data-current', status);
                    
                    // 2. வாட்ஸ்அப் மெசேஜ் அனுப்பும் பகுதி
                    if (customerPhone && customerPhone.trim() !== '') {
                        if (customerPhone.startsWith('0')) {
                            customerPhone = '94' + customerPhone.substring(1); // இலங்கை நாட்டின் குறியீடு
                        }

                        let message = '';
                        if (status === 'Approved') {
                            message = `Hello *${customerName}*,%0A%0A🎉 Your appointment booking for *${service}* on *${date}* at *${time}* has been *APPROVED* successfully!%0A%0AWe are excited to serve you. See you soon at Glow & Glamour Parlor! ✨`;
                        } else if (status === 'Cancelled') {
                            message = `Hello *${customerName}*,%0A%0A⚠️ We regret to inform you that your appointment booking for *${service}* on *${date}* has been *CANCELLED*.%0A%0APlease contact us if you wish to reschedule or have any questions.`;
                        } else {
                            return; 
                        }

                        const whatsappUrl = `https://api.whatsapp.com/send?phone=${customerPhone}&text=${message}`;
                        window.open(whatsappUrl, '_blank');
                    }
                } else {
                    alert('Failed to update status in database!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong!');
            });
        });
    });
    </script>
</body>
</html>