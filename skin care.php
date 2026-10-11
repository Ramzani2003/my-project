<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow & Grace | Skin Care Services</title>
    <style>
        /* General Page Setup based on IMG_20260605_140500_2.jpg */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #d1d5cb; /* Matches the greyish-olive background tone */
            color: #333;
        }

        /* Top Header Navigation */
        header {
            background-color: #e2e5d9; /* Light beige header background from image */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #802a2a; /* Deep maroon-red logo accent */
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin-left: 25px;
        }

        nav ul li a {
            text-decoration: none;
            color: #4a5240; /* Dark olive menu text color */
            font-weight: 600;
            font-size: 15px;
            transition: 0.3s;
        }

        /* Active styling for Skin Care page */
        nav ul li a.active, nav ul li a:hover {
            color: #802a2a;
            border-bottom: 2px solid #802a2a;
            padding-bottom: 4px;
        }

        /* Main Dashboard Content Card */
        .container {
            max-width: 1050px;
            margin: 40px auto;
            padding: 35px;
            background-color: #e9ebd3; /* Inner content area template color */
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .page-title {
            color: #802a2a;
            font-size: 32px;
            text-align: center;
            margin-bottom: 10px;
        }

        .page-subtitle {
            text-align: center;
            color: #555;
            font-size: 16px;
            margin-bottom: 40px;
            font-style: italic;
        }

        /* Grid Layout for Skin Care Sub-Services */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        /* Sub-Service Individual Card Design */
        .service-card {
            background-color: #f4f6ec; /* Card wrapper matching the template boxes */
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .service-card h3 {
            color: #802a2a;
            font-size: 22px;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .service-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            height: 70px; /* Aligns description alignment uniformly */
            margin-bottom: 15px;
        }

        .price-tag {
            display: inline-block;
            font-weight: bold;
            color: #802a2a;
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* Action Button */
        .book-btn {
            display: inline-block;
            background-color: #802a2a;
            color: #fff;
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .book-btn:hover {
            background-color: #591d1d;
        }

        /* Footer matching the exact layout row */
        footer {
            text-align: center;
            padding: 25px;
            background-color: #1e2417; /* Dark footer area */
            color: #a3a89c;
            font-size: 13px;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <!-- Header / Navigation -->
    <header>
        <div class="logo">Glow & Grace</div>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="skin care.php" class="active">Skin Care</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Book Now</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content Block -->
    <div class="container">
        <h2 class="page-title">Skin Care Services</h2>
        <p class="page-subtitle">Refreshing facials and premium clean-ups tailored specifically for your unique skin type.</p>

        <!-- Services Sub-Categories Grid -->
        <div class="services-grid">
            
            <!-- Service 1 -->
            <div class="service-card">
                <h3>Refreshing Facials</h3>
                <p>Revitalize your skin with our organic fruit and herbal facials. Perfect for instantly removing tan and restoring natural glow.</p>
                <div class="price-tag">LKR 3,500</div>
                <br>
                <a href="register.php?service=facial" class="book-btn">Book Appointment</a>
            </div>

            <!-- Service 2 -->
            <div class="service-card">
                <h3>Deep Cleansing</h3>
                <p>An advanced clinical clean-up targeting blackheads, dirt, and excess oil sebum. Leaves your pores fully detoxified and fresh.</p>
                <div class="price-tag">LKR 2,800</div>
                <br>
                <a href="register.php?service=cleansing" class="book-btn">Book Appointment</a>
            </div>

            <!-- Service 3 -->
            <div class="service-card">
                <h3>Skin Brightening Glow</h3>
                <p>Premium vitamin-C and gold mask therapies designed to even out skin complexion tones and reduce dark pigmentation blemishes.</p>
                <div class="price-tag">LKR 4,800</div>
                <br>
                <a href="register.php?service=brightening" class="book-btn">Book Appointment</a>
            </div>

        </div>
    </div>

    <!-- Footer Row -->
    <footer>
        &copy; 2026 Glow & Grace Beauty Parlor. All Rights Reserved.
    </footer>

</body>
</html>