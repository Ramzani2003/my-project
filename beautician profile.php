<?php
$stylist_name = "Jabeer Ramzani";
$role = "Senior Hair & Bridal Makeup Specialist";
$experience = "5+ Years";
$rating = "4.9 (140+ Reviews)";
$about = "Ramzani is a highly skilled cosmetologist certified in international hair styling and advanced bridal makeovers. She specializes in creating modern, elegant looks that match each client's unique style.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $stylist_name; ?> - Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background: #fffafa; 
            min-height: 100vh;
            display: flex;
            flex-direction: column; /* Stacks header on top, content below */
        }

        /* ─── NAVBAR STRAIGHT LINE FIX ─── */
        header {
            background-color: #ffffff;
            display: flex;
            justify-content: space-between; /* Logo and menu push away from each other */
            align-items: center;            /* Vertically centers both side items perfectly */
            padding: 15px 10%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #d44179; /* Parlor Pink Theme */
            text-decoration: none;
            display: inline-block;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            list-style: none;
            display: flex;                  /* Menu lists arrayed in a horizontal row */
            align-items: center;            /* Centers items vertically inside row */
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin-left: 15px;             /* Spacing between button components */
        }

        /* Links Designed as Buttons */
        nav ul li a {
            text-decoration: none;
            color: #555;
            font-weight: 600;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 20px;            /* Smooth rounded button look */
            border: 2px solid transparent;
            transition: all 0.3s ease;
            display: inline-block;
            white-space: nowrap;            /* Forces names to remain on a single row */
        }

        /* Button Hover and Active Status */
        nav ul li a:hover, nav ul li a.active {
            color: #ffffff;
            background-color: #d44179;
            border-color: #d44179;
            box-shadow: 0 4px 10px rgba(212, 65, 121, 0.2);
        }



        /* Main Content Wrapper to center the Profile Box properly */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        /* Profile Card Container */
        .profile-container {
            background: #ffffff;
            max-width: 950px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(230, 180, 185, 0.3);
            display: flex;
            overflow: hidden;
            flex-wrap: wrap; 
        }

        .profile-sidebar {
            background: #fff0f2; 
            flex: 1 1 320px;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            border-right: 1px solid #f9e2e5;
        }

        .img-box {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            border: 6px solid #ffffff;
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-sidebar h2 {
            font-size: 24px;
            color: #2d3436;
            margin-bottom: 6px;
        }

        .role-title {
            font-size: 14px;
            color: #d63031; 
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 15px;
        }

        .rating-badge {
            background: #ffffff;
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: bold;
            color: #2d3436;
            box-shadow: 0 3px 8px rgba(0,0,0,0.04);
        }

        .rating-badge i {
            color: #f1c40f; 
            margin-right: 5px;
        }

        .profile-details {
            flex: 2 1 500px;
            padding: 40px;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .info-section:last-child {
            margin-bottom: 0;
        }

        .info-section h3 {
            font-size: 18px;
            color: #2d3436;
            border-bottom: 2px solid #ff7979;
            padding-bottom: 6px;
            margin-bottom: 15px;
        }

        .info-section h3 i {
            color: #e84393;
            margin-right: 8px;
        }

        .info-section p {
            color: #636e72;
            line-height: 1.6;
            font-size: 15px;
        }

        .skills-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tag {
            background: #f1f2f6;
            color: #2d3436;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 8px 0;
            font-size: 15px;
            color: #636e72;
        }

        .summary-table td strong {
            color: #2d3436;
        }

        .schedule-list {
            list-style: none;
        }

        .schedule-list li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 15px;
            border-bottom: 1px dashed #f1f2f6;
            color: #636e72;
        }

        .schedule-list li .holiday {
            color: #d63031;
            font-weight: bold;
        }

        /* Responsive Settings */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            nav ul li {
                margin: 0 10px;
            }
            .profile-container {
                flex-direction: column;
            }
            .profile-sidebar {
                border-right: none;
                border-bottom: 1px solid #f9e2e5;
            }
            .profile-details {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">Glow & Grace</div>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="gallary.php">Gallery</a></li>
                <li><a href="teampage.php">Team</a></li>
                <li><a href="beautician profile.php" class="active">Beautician Profile</a></li>
                 <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-content">
        <div class="profile-container">
            
            <div class="profile-sidebar">
                <div class="img-box">
                    <img src="beauty.jpg" alt="<?php echo $stylist_name; ?>">
                </div>
                <h2><?php echo $stylist_name; ?></h2>
                <p class="role-title"><?php echo $role; ?></p>
                
                <div class="rating-badge">
                    <i class="fas fa-star"></i> <span><?php echo $rating; ?></span>
                </div>
            </div>

            <div class="profile-details">
                <div class="info-section">
                    <h3><i class="fas fa-user"></i> About Me</h3>
                    <p><?php echo $about; ?></p>
                </div>

                <div class="info-section">
                    <h3><i class="fas fa-magic"></i> Expert Skills</h3>
                    <div class="skills-tags">
                        <span class="tag">Bridal Makeup</span>
                        <span class="tag">Hair Coloring</span>
                        <span class="tag">Balayage</span>
                        <span class="tag">Facial Therapies</span>
                        <span class="tag">Nail Art</span>
                    </div>
                </div>

                <div class="info-section">
                    <h3><i class="fas fa-id-card"></i> Quick Summary</h3>
                    <table class="summary-table">
                        <tr>
                            <td><strong>Experience:</strong></td>
                            <td><?php echo $experience; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Languages:</strong></td>
                            <td>Tamil, English, Sinhala</td>
                        </tr>
                    </table>
                </div>

                <div class="info-section">
                    <h3><i class="fas fa-clock"></i> Weekly Schedule</h3>
                    <ul class="schedule-list">
                        <li><span>Monday - Friday</span> <span>09:00 AM - 06:00 PM</span></li>
                        <li><span>Saturday</span> <span>10:00 AM - 07:00 PM</span></li>
                        <li><span>Sunday</span> <span class="holiday">Holiday / Closed</span></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</body>
</html>