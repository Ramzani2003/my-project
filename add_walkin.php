<?php
// Database Connection
$conn = mysqli_connect("localhost", "root", "", "beauty_parlor");

if (!$conn) {
    die("Database Connection Error: " . mysqli_connect_error());
}

$message = "";

// படிவம் சப்மிட் செய்யப்படும் போது (On Form Submit)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname     = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone        = mysqli_real_escape_string($conn, $_POST['phone']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $service      = mysqli_real_escape_string($conn, $_POST['service']);
    $stylist      = mysqli_real_escape_string($conn, $_POST['stylist']);
    $booking_date = date('Y-m-d'); // Walk-In என்பதால் இன்றைய தேதியே தானாக எடுத்துக்கொள்ளும்
    $booking_time = mysqli_real_escape_string($conn, $_POST['booking_time']);
    $notes        = mysqli_real_escape_string($conn, $_POST['notes']);
    $status       = "Approved"; // நேரில் வந்ததால் நேரடியாக 'Approved' அல்லது 'Completed' என வைக்கலாம்

    // Database-ல் சேமிக்கும் Query
    $query = "INSERT INTO tbl_appointment (fullname, phone, email, service, stylist, booking_date, booking_time, notes, status) 
              VALUES ('$fullname', '$phone', '$email', '$service', '$stylist', '$booking_date', '$booking_time', '$notes', '$status')";

    if (mysqli_query($conn, $query)) {
        $message = "<div class='alert success'>Walk-In Appointment Added Successfully! <a href='admindashboard.php'>Go to Dashboard</a></div>";
    } else {
        $message = "<div class='alert error'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Walk-In Appointment - GlowAdmin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background-color: #fff;
            width: 100%;
            max-width: 700px;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #edf2f7;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 15px;
        }

        .form-header h2 {
            font-size: 1.4rem;
            color: #1a1a2e;
        }

        .form-header h2 i {
            color: #ff758f;
            margin-right: 8px;
        }

        .btn-back {
            background-color: #64748b;
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: background 0.2s;
        }

        .btn-back:hover {
            background-color: #475569;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width {
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #475569;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            color: #94a3b8;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px 15px 12px 42px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

        .form-group textarea {
            padding: 12px 15px;
            resize: vertical;
        }

        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #ff758f;
            box-shadow: 0 0 0 3px rgba(255, 117, 143, 0.1);
        }

        .btn-submit {
            background-color: #ff758f;
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: background 0.2s;
            box-shadow: 0 4px 12px rgba(255, 117, 143, 0.2);
        }

        .btn-submit:hover {
            background-color: #e0536e;
        }

        /* Alert Box Styles */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 0.95rem;
        }
        .success { background-color: #d1fae5; color: #065f46; border: 1px solid #10b981; }
        .error { background-color: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }
        .success a { color: #047857; font-weight: 600; }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="form-header">
            <h2><i class="fa-solid fa-user-plus"></i> Add Walk-In Customer</h2>
            <a href="admindashboard.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </div>

        <?php echo $message; ?>

        <form action="add_walkin.php" method="POST">
            <div class="form-grid">
                
                <div class="form-group">
                    <label for="fullname">Customer Name</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" id="phone" name="phone" placeholder="07XXXXXXXX" required>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="email">Email Address (Optional)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="customer@email.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="service">Select Service</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-scissors"></i>
                        <select id="service" name="service" required>
                            <option value="" disabled selected>Choose service</option>
                            <option value="Hair Styling & Cut">Hair Styling & Cut</option>
                            <option value="Bridal Makeover">Bridal Makeover</option>
                            <option value="Facials & Skincare">Facials & Skincare</option>
                            <option value="Mani & Pedi">Mani & Pedi</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="stylist">Assign Stylist</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user-sparkles"></i>
                        <select id="stylist" name="stylist" required>
                            <option value="Any Available Expert">Any Available Expert</option>
                            <option value="Sarah (Hair Expert)">Sarah (Hair Expert)</option>
                            <option value="Elena (Makeup Specialist)">Elena (Makeup Specialist)</option>
                            <option value="Priya (Skincare Therapist)">Priya (Skincare Therapist)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="booking_time">Time Slot</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-clock"></i>
                        <select id="booking_time" name="booking_time" required>
                            <option value="" disabled selected>Select current time slot</option>
                            <option value="09:00 AM">09:00 AM</option>
                            <option value="11:00 AM">11:00 AM</option>
                            <option value="01:00 PM">01:00 PM</option>
                            <option value="03:00 PM">03:00 PM</option>
                            <option value="05:00 PM">05:00 PM</option>
                        </select>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="notes">Special Notes / Requirements</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Any requests or product allergies..."></textarea>
                </div>

            </div>

            <button type="submit" class="btn-submit">Add & Confirm Appointment</button>
        </form>
    </div>

</body>
</html>