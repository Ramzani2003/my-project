<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow & Grace | Hair Care Services</title>
    <style>
        /* General Page Setup based on IMG_20260605_140500.jpg */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #d1d5cb; /* Matches the greyish-olive background tone of the layout */
            color: #333;
        }

        /* Top Header Styling */
        .header {
            background-color: #e2e5d9; /* Light cream/beige header background from image */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .header-logo h1 {
            color: #802a2a; /* Deep reddish-maroon logo color */
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .header-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 25px;
        }

        .header-nav ul li a {
            text-decoration: none;
            color: #4a5240; /* Dark olive-grey tint for menu links */
            font-weight: 600;
            font-size: 15px;
            transition: color 0.3s;
        }

        /* Active highlight for current page */
        .header-nav ul li a.active, .header-nav ul li a:hover {
            color: #802a2a;
            border-bottom: 2px solid #802a2a;
            padding-bottom: 4px;
        }

        /* Main Dashboard Content Card */
        .container {
            max-width: 1050px;
            margin: 40px auto;
            padding: 35px;
            background-color: #e9ebd3; /* Inner dashboard background color template */
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

        /* Grid Layout for Hair Care Sub-Services */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        /* Individual Card Design */
        .service-card {
            background-color: #f4f6ec; /* Matches inner category cards wrapper */
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
            height: 70px; /* Keeps card descriptions perfectly aligned */
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

        /* Footer Alignment matching the image */
        .footer {
            text-align: center;
            padding: 25px;
            background-color: #1e2417; /* Dark footer row background */
            color: #a3a89c;
            font-size: 13px;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <!-- Header Navigation Bar -->
    <div class="header">
        <div class="header-logo">
            <h1>Glow & Grace</h1>
        </div>
        <div class="header-nav">
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="hair care.php" class="active">Hair Care</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Book Now</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Dynamic Content Block -->
    <div class="container">
        <h2 class="page-title">Hair Care Services</h2>
        <p class="page-subtitle">Trending haircuts, professional styling, and organic coloring treatments.</p>

        <!-- Hair Care Sub Categories Grid -->
        <div class="services-grid">
            
            <!-- Service 1 -->
            <div class="service-card">
                <h3>Trending Haircuts</h3>
                <p>Get a complete transformation with our expert stylists. Includes personalized consultation, hair wash, and blow-dry setting.</p>
                <div class="price-tag">LKR 2,500</div>
                <br>
                <a href="register.php?service=haircut" class="book-btn">Book Appointment</a>
            </div>

            <!-- Service 2 -->
            <div class="service-card">
                <h3>Professional Styling</h3>
                <p>Perfect hair settings, straightening, curling, or creative updos tailored beautifully for parties, corporate profiles, and events.</p>
                <div class="price-tag">LKR 3,500</div>
                <br>
                <a href="register.php?service=styling" class="book-btn">Book Appointment</a>
            </div>

            <!-- Service 3 -->
            <div class="service-card">
                <h3>Organic Coloring</h3>
                <p>100% safe, chemical-free premium organic coloring and hair tinting treatments to protect your scalp strength and root shine.</p>
                <div class="price-tag">LKR 5,800</div>
                <br>
                <a href="register.php?service=coloring" class="book-btn">Book Appointment</a>
            </div>

        </div>
    </div>

    <!-- Footer Copyright Block -->
    <div class="footer">
        © 2026 Glow & Grace Beauty Parlor. All Rights Reserved.
    </div>

</body>
</html>