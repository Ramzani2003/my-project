<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow & Grace | Threading & Waxing Packages</title>
    <style>
        /* Base Reset & Fonts */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f7f9fa;
            color: #333;
        }

        /* Navbar Layout */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 8%;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        .nav-links a {
            text-decoration: none;
            color: #555;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover, .nav-links a.active {
            color: #b3598a;
        }

        /* Main Section Background Wrapper */
        .main-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 40px;
            background-color: #e5ecf4; /* Gray-blue background matching your theme */
            border-radius: 20px;
        }

        /* Header Elements */
        .header-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .header-section h1 {
            font-size: 36px;
            color: #1a1a1a;
            text-transform: capitalize;
            margin-bottom: 10px;
        }

        .header-section p {
            color: #666;
            font-size: 16px;
        }

        /* Responsive Packages Grid */
        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            justify-content: center;
        }

        /* Individual Card Item */
        .package-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 35px 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease;
        }

        .package-card:hover {
            transform: translateY(-5px);
        }

        /* Card Content Styling */
        .package-title {
            color: #5c1d5c; /* Custom maroon/purple tone from your image */
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .package-desc {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
            min-height: 80px;
        }

        .package-price {
            font-size: 20px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 20px;
        }

        /* Action Button */
        .book-btn {
            background-color: #83437a;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .book-btn:hover {
            background-color: #66305e;
        }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <header class="navbar">
        <div class="logo">Glow & Grace</div>
        <ul class="nav-links">
             <li><a href="homepage.php">Home</a></li>
                <li><a href="threading waxing.php">Threading Waxing</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
        </ul>
    </header>

    <!-- Main Content Container -->
    <main class="main-container">
        
        <div class="header-section">
            <h1>Threading & Waxing</h1>
            <p>Flawless eyebrow shaping and gentle full-body waxing for smooth, clean skin.</p>
        </div>

        <!-- 3 Packages Layout Structure -->
        <div class="packages-grid">
            
            <!-- Package 1 -->
            <div class="package-card">
                <div>
                    <h2 class="package-title">Basic Defining Combo</h2>
                    <p class="package-desc">Perfect eyebrow shaping via standard threading technique, paired with upper lip and chin threading for a flawless facial finish.</p>
                </div>
                <div>
                    <div class="package-price">LKR 2,500</div>
                    <a href="register.php" class="book-btn">Book Package</a>
                </div>
            </div>

            <!-- Package 2 -->
            <div class="package-card">
                <div>
                    <h2 class="package-title">Sleek Arms & Legs</h2>
                    <p class="package-desc">Gentle honey-based wax treatment for full arms and half legs. Removes dead skin cells and provides silky smooth skin texture.</p>
                </div>
                <div>
                    <div class="package-price">LKR 8,500</div>
                    <a href="register.php" class="book-btn">Book Package</a>
                </div>
            </div>

            <!-- Package 3 -->
            <div class="package-card">
                <div>
                    <h2 class="package-title">Full Body Glow Silk</h2>
                    <p class="package-desc">Premium full-body waxing package using advanced chocolate or ricas wax. Includes eyebrow shaping, face threading, and post-wax soothing massage.</p>
                </div>
                <div>
                    <div class="package-price">LKR 18,500</div>
                    <a href="register.php" class="book-btn">Book Package</a>
                </div>
            </div>

        </div>
    </main>

</body>
</html>