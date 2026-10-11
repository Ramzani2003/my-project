<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow & Grace | Bridal Makeup Packages</title>
    <style>
        /* Reset & General Styles based on your screen layout */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #cbd2c1; /* Exact greenish-grey background tone from your photo */
            color: #333;
        }

        /* Top Header Navigation (Matches your image header background) */
        header {
            background-color: #e3e7da; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 8%;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #9c4174; /* Parlor theme pink color from text */
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        nav ul li a {
            text-decoration: none;
            color: #5d6653; /* Soft dark olive text tint */
            font-weight: 600;
            font-size: 15px;
            transition: 0.3s;
        }

        /* Highlighting active page */
        nav ul li a.active, nav ul li a:hover {
            color: #9c4174;
        }

        /* Main Dashboard Wrapper Card */
        .main-wrapper {
            max-width: 1100px;
            margin: 40px auto;
            padding: 40px 30px;
            background-color: #e8ebd7; /* Slightly lighter inner background wrapper */
            border-radius: 16px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            color: #2b3024;
            font-size: 34px;
            text-align: center;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .section-subtitle {
            text-align: center;
            color: #636b59;
            font-size: 16px;
            margin-bottom: 45px;
        }

        /* Content Grid Setup */
        .packages-grid {
            display: flex;
            justify-content: space-between;
            gap: 25px;
            flex-wrap: wrap;
        }

        /* Inner Sub-cards (Matches the White rounded boxes on screen) */
        .package-card {
            background: #ffffff;
            flex: 1;
            min-width: 290px;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .package-card h3 {
            color: #9c4174; /* Matching the category font color exactly */
            font-size: 22px;
            margin-bottom: 15px;
        }

        .package-card p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 25px;
            height: 70px; /* Keeps text box levels perfectly aligned */
        }

        /* Sri Lankan LKR Pricing tag */
        .price-tag {
            font-size: 20px;
            font-weight: bold;
            color: #2b3024;
            margin-bottom: 20px;
            display: block;
        }

        /* Premium Booking Button */
        .book-now-btn {
            display: inline-block;
            background-color: #9c4174;
            color: #ffffff;
            padding: 10px 28px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .book-now-btn:hover {
            background-color: #7d305a;
            transform: scale(1.02);
        }

        /* Bottom Footer matching the exact line color on desktop template */
        footer {
            text-align: center;
            padding: 25px;
            background-color: #2b3024; /* Dark gray-olive shade */
            color: #a4ab9b;
            font-size: 13px;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">Glow & Grace</div>
        <nav>
            <ul>
               <li><a href="homepage.php">Home</a></li>
                <li><a href="bridal makeup.php" class="active">Bridal Makeup</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-wrapper">
        <h2 class="section-title">Bridal Makeup</h2>
        <p class="section-subtitle">Professional makeup artists to make your special day perfect.</p>

        <div class="packages-grid">
            
            <div class="package-card">
                <h3>Traditional Muhurtham</h3>
                <p>Classic silk-finish look tailored flawlessly for traditional wedding rituals. Long-lasting, high-definition (HD), and sweat-proof under heavy stage lighting.</p>
                <span class="price-tag">LKR 45,000</span>
                <a href="register.php?package=traditional" class="book-now-btn">Book Package</a>
            </div>

            <div class="package-card">
                <h3>Glam Reception Look</h3>
                <p>Stunning modern airbrush or soft glow makeup option. Highly optimized for elegant evening outdoor photography, high-definition videos, and parties.</p>
                <span class="price-tag">LKR 35,000</span>
                <a href="register.php?package=reception" class="book-now-btn">Book Package</a>
            </div>

            <div class="package-card">
                <h3>Pre-Bridal Package</h3>
                <p>Essential skin-prep treatment before the big day. Includes organic clean-ups, refreshing golden facials, root care, and full detan scrub therapies.</p>
                <span class="price-tag">LKR 15,000</span>
                <a href="register.php?package=pre_bridal" class="book-now-btn">Book Package</a>
            </div>

        </div>
    </div>

    <footer>
        &copy; 2026 Glow & Grace Beauty Parlor. All Rights Reserved.
    </footer>

</body>
</html>