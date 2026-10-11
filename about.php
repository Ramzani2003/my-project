<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Glow & Glamour Parlor</title>
    <!-- Font Awesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Global Reset & Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #fdfaf7;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
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

        /* Button Hover and Active Status (Pink Button Fix) */
        nav ul li a:hover, nav ul li a.active {
            color: #ffffff;
            background-color: #d44179;
            border-color: #d44179;
            box-shadow: 0 4px 10px rgba(212, 65, 121, 0.2);
        }

        /* About Section Layout */
        .about-section {
            padding: 80px 0;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        /* Image Styling */
        .about-image img {
            width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        /* Text Content Styling */
        .about-content .sub-title {
            color: #d63384; /* Soft Parlor Pink/Rose Color */
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 14px;
            display: block;
            margin-bottom: 10px;
        }

        .about-content h2 {
            font-size: 36px;
            color: #2c231e;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .about-content p {
            color: #666;
            margin-bottom: 20px;
        }

        /* Features Block */
        .features {
            margin: 30px 0;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .feature-item i {
            font-size: 24px;
            color: #d63384;
            background: #ffeef5;
            padding: 12px;
            border-radius: 50px;
        }

        .feature-item h4 {
            font-size: 18px;
            color: #2c231e;
            margin-bottom: 5px;
        }

        .feature-item p {
            font-size: 14px;
            color: #777;
            margin-bottom: 0;
        }

        /* Appointment Button */
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #d63384;
            color: #fff;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(214, 51, 132, 0.3);
        }

        .btn:hover {
            background-color: #b8236c;
            transform: translateY(-2px);
        }

        /* Responsive Grid for Tablets & Mobile Devices */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
                padding: 15px 5%;
            }
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
            nav ul li {
                margin: 5px;
            }
            .about-grid {
                grid-template-columns: 1fr; /* Stack layout on top of each other */
                gap: 30px;
            }
            .about-content h2 {
                font-size: 28px;
            }
        }

        footer {
            background-color: #222;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    
    <header>
        <div class="logo">Glow & Grace</div>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="gallary.php">Gallary</a></li>
                <li><a href="teampage.php">Team</a></li>
                <li><a href="beautician profile.php">Beautician Profile</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <!-- Left Side: Image -->
                <div class="about-image">
                    <img src="parlor.jpg" alt="Beauty Parlor Interior">
                </div>
                
                <!-- Right Side: Text Content -->
                <div class="about-content">
                    <span class="sub-title">About Our Parlor</span>
                    <h2>Redefining Beauty & Wellness For You</h2>
                    <p>Welcome to Glow & Glamour, your ultimate destination for premium beauty treatments and effortless pampering. For over 5 years, we have been dedicated to enhancing your natural beauty with top-tier salon services tailored to your unique style.</p>
                    
                    <p>We value your time, which is why we created this online web application—making it easier than ever to book appointments, choose your favorite stylists, and avoid long waiting hours.</p>

                    <!-- Features List -->
                    <div class="features">
                        <div class="feature-item">
                            <i class="fas fa-magic"></i>
                            <div>
                                <h4>Premium Products</h4>
                                <p>We use 100% safe, certified, and top-branded cosmetics for all treatments.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-calendar-check"></i>
                            <div>
                                <h4>Easy Online Booking</h4>
                                <p>Select your desired services, dates, and beauty experts in just a few clicks.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Glow & Grace Beauty Parlor. All Rights Reserved.</p>
    </footer>

</body>
</html>