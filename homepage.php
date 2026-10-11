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

/* ─── OPTIONAL DATA AUTO-SAVE GUARD ───
  Oruvelai ungal tbl_services table vettumaiyaaga (Blank) irundhal, 
  intha keelae ulla code automatic-ah ungal 6 main categories-ai DB-il save seithu vidum!
*/
$check_empty = "SELECT COUNT(*) as total FROM tbl_services";
$check_result = $conn->query($check_empty);
$row_count = $check_result->fetch_assoc();

if ($row_count['total'] == 0) {
    $default_services = [
        ['Hair Care', 'haircare.jpg', 'Hair care.php', 'Trending haircuts, styling, and organic coloring treatments.'],
        ['Skin Care', 'skincare.jpg', 'skin care.php', 'Refreshing facials and clean-ups tailored for your skin type.'],
        ['Bridal Makeup', 'makeup.jpg', 'bridal makeup.php', 'Professional makeup artists to make your special day perfect.'],
        ['Mani & Pedi', 'mani pedi.jpg', 'mani pedi.php', 'Relaxing hand and foot spas including nail shaping, cutical care, and gel polishing.'],
        ['Aromatheraphy Massage', 'aromatherophy.jpg', 'aromatherophy massage.php', 'De-stress your mind and body with our soothing essential oil Massage thrapies.'],
        ['Threading Waxing', 'threading waxing.jpg', 'threading waxing.php', 'Flawless eyebrow shaping and gentle full-body waxing for smooth, clean skin.']
    ];

    $stmt = $conn->prepare("INSERT INTO tbl_services (service_name, service_image, service_link, description) VALUES (?, ?, ?, ?)");
    foreach ($default_services as $service) {
        $stmt->bind_param("ssss", $service[0], $service[1], $service[2], $service[3]);
        $stmt->execute();
    }
    $stmt->close();
}

// Fetch categories from Database to display dynamically
$sql = "SELECT * FROM tbl_services";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow & Grace | Online Beauty Parlor</title>
    <style>
        /* Reset Basic Elements */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #fcf8f8;
            color: #333;
        }

        /* NAVBAR STRAIGHT LINE FIXED */
        header {
            background-color: #ffffff;
            display: flex;
            justify-content: space-between; 
            align-items: center;            
            padding: 15px 10%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #d44179; 
            text-decoration: none;
            display: inline-block;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav ul {
            list-style: none;
            display: flex;                  
            align-items: center;            
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin-left: 15px;             
        }

        nav ul li a {
            text-decoration: none;
            color: #555;
            font-weight: 600;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 20px;            
            border: 2px solid transparent;
            transition: all 0.3s ease;
            display: inline-block;
            white-space: nowrap;            
        }

        nav ul li a:hover, nav ul li a.active {
            color: #ffffff;
            background-color: #d44179;
            border-color: #d44179;
            box-shadow: 0 4px 10px rgba(212, 65, 121, 0.2);
        }

        /* Hero Banner Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('beauty.jpg') no-repeat center center/cover;
            height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
        }

        .hero-content h1 {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .hero-content p {
            font-size: 20px; /* Text overlap fix */
            margin-bottom: 15px;
        }

        /* Features / Categories Section */
        .features {
            padding: 60px 10%;
            text-align: center;
        }

        .features h2 {
            font-size: 32px;
            margin-bottom: 40px;
            color: #333;
        }

        .feature-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); 
            gap: 20px; 
        }

        .feature-box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .feature-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .feature-box img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .feature-box h3 {
            margin-bottom: 10px;
            color: #d44179;
        }

        .feature-box p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }

        footer {
            background-color: #222;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            margin-top: 40px;
        }

        @media (max-width: 900px) {
            .feature-container { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 600px) {
            .feature-container { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">Glow & Grace</div>
        <nav>
            <ul>
                <li><a href="homepage.php" class="active">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="gallary.php">Gallary</a></li>
                <li><a href="teampage.php">Team</a></li>
                <li><a href="beautician profile.php">Beautician Profile</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Reveal Your True Beauty</h1>
            <p>Book your favorite beauty and hair care services online instantly.</p>
        </div>
    </section>

    <section class="features">
        <h2>Our Main Categories</h2>
        <div class="feature-container">
            
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="feature-box">
                        <a href="<?php echo htmlspecialchars($row['service_link']); ?>" class="feature-link">
                            <img src="<?php echo htmlspecialchars($row['service_image']); ?>" alt="<?php echo htmlspecialchars($row['service_name']); ?>">
                            <h3><?php echo htmlspecialchars($row['service_name']); ?></h3>
                        </a>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                    </div>
                    <?php
                }
            } else {
                echo "<p style='grid-column: 1/-1; color:#777;'>No categories found in tbl_services.</p>";
            }
            ?>

        </div>
    </section>

    <footer>
        <p>&copy; 2026 Glow & Grace Beauty Parlor. All Rights Reserved.</p>
    </footer>

</body>
</html>
<?php $conn->close(); ?>