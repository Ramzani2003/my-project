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


// Fetch active or on leave professionals to showcase to customers
$query = "SELECT * FROM stylists WHERE status != 'Inactive'";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team | Glow & Grace Parlor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background-color: #fdfaf7;
        color: #2c231e;
    }

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

    .team-section {
        padding: 80px 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .team-header {
        text-align: center;
        max-width: 600px;
        margin: 0 auto 60px auto;
    }

    .team-header .sub-title {
        color: #d63384;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 14px;
        display: block;
        margin-bottom: 10px;
    }

    .team-header h2 {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .team-header p {
        color: #666;
        font-size: 15px;
        line-height: 1.6;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); 
        gap: 30px;
    }

    .team-card {
        background: #ffffff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
        border: 1px solid #f1f1f1;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(214, 51, 132, 0.1);
    }

    .member-img-box {
        position: relative;
        height: 280px;
        overflow: hidden;
        background-color: #f1f1f1;
    }

    .member-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .team-card:hover .member-img-box img {
        transform: scale(1.05);
    }

    .social-links {
        position: absolute;
        bottom: -50px;
        left: 0;
        width: 100%;
        background: rgba(214, 51, 132, 0.85); 
        padding: 12px 0;
        display: flex;
        justify-content: center;
        gap: 15px;
        transition: bottom 0.3s ease;
    }

    .team-card:hover .social-links {
        bottom: 0;
    }

    .social-links a {
        color: #ffffff;
        font-size: 16px;
        transition: 0.3s;
    }

    .social-links a:hover {
        color: #2c231e;
    }

    .member-info {
        padding: 25px 20px;
    }

    .member-info h3 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .member-info .role {
        color: #d63384;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 12px;
    }

    .member-info .rating {
        font-size: 13px;
        color: #666;
        margin-bottom: 20px;
    }

    .member-info .rating i {
        color: #f1c40f;
    }

    .view-profile-btn {
        display: inline-block;
        padding: 10px 20px;
        border: 1px solid #d63384;
        color: #d63384;
        text-decoration: none;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .view-profile-btn:hover {
        background-color: #d63384;
        color: #ffffff;
    }

    @media (max-width: 992px) {
        .team-grid {
            grid-template-columns: repeat(2, 1fr); 
        }
    }

    @media (max-width: 768px) {
        .navbar {
            flex-direction: column;
            gap: 15px;
        }
        .nav-links li {
            margin: 0 10px;
        }
        .team-grid {
            grid-template-columns: 1fr; 
        }
    }
</style>
<body>

    <header class="navbar">
        <div class="logo">Glow & Grace</div>
        <nav>
            <ul class="nav-links">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="gallary.php">Gallery</a></li>
                <li><a href="teampage.php" class="active">Team</a></li>
                <li><a href="beautician profile.php">Beautician Profile</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="team-section">
        <div class="container">
            <div class="team-header">
                <span class="sub-title">Meet Our Experts</span>
                <h2>Our Professional Beauticians</h2>
                <p>Our team of internationally certified experts is dedicated to providing you with premium, outstanding beauty care treatments.</p>
            </div>

            <div class="team-grid">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="team-card">
                            <div class="member-img-box">
                                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>">
                                <div class="social-links">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h3><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h3>
                                <p class="role"><?php echo htmlspecialchars($row['role_title']); ?></p>
                                <div class="rating">
                                    <i class="fas fa-star"></i> <?php echo isset($row['rating']) ? number_format($row['rating'], 1) : '5.0'; ?> (<?php echo isset($row['reviews_count']) ? $row['reviews_count'] : '20'; ?>+ Reviews)
                                </div>
                                <a href="beautician profile.php?id=<?php echo $row['id']; ?>" class="view-profile-btn">View Profile</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="grid-column: 1 / -1; text-align: center; color: #777;">No styling experts found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

</body>
</html>