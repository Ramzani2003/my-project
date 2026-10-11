<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | Glow & Grace Beauty Parlor</title>
    <style>
        /* CSS Reset and Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #fcf8f9;
            color: #333;
            padding-bottom: 60px;
        }

        /* ─── NAVBAR PERFECT STRAIGHT LINE FIX ─── */
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

        /* Header Section */
        .gallery-header {
            text-align: center;
            padding: 60px 20px 40px 20px;
        }

        .gallery-header h1 {
            color: #d63384;
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .gallery-header p {
            color: #6c757d;
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Gallery Grid Container */
        .gallery-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        /* Gallery Item Card */
        .gallery-item {
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(214, 51, 132, 0.15);
        }

        /* Image Wrapper for Zoom Effect */
        .img-container {
            width: 100%;
            height: 250px;
            overflow: hidden;
            position: relative;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover .img-container img {
            transform: scale(1.1);
        }

        /* Category Tag Style overlayed on image */
        .category-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: rgba(214, 51, 132, 0.9);
            color: #ffffff;
            padding: 5px 12px;
            font-size: 12px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Text details under the image */
        .item-info {
            padding: 20px;
        }

        .item-info h3 {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .item-info p {
            color: #718096;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Responsive Settings for Mobile Devices */
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
        }
    </style>
</head>
<body>

    <!-- Balanced Header Element Layout -->
    <header>
        <a href="homepage.php" class="logo">Glow & Grace</a>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="gallary.php" class="active">Gallery</a></li>
                <li><a href="teampage.php">Team</a></li>
                <li><a href="beautician profile.php">Beautician Profile</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Header Section -->
    <section class="gallery-header">
        <h1>Our Masterpieces</h1>
        <p>Explore our stunning transformations. From elegant bridal makeovers to trendy hairstyles, we bring out the best look in you.</p>
    </section>

    <!-- Main Content Grid Layout -->
    <main class="gallery-container">
        
        <div class="gallery-item">
            <div class="img-container">
                <span class="category-tag">Bridal</span>
                <img src="bridal.jpg" alt="Bridal Makeover">
            </div>
            <div class="item-info">
                <h3>Royal Bridal Makeover</h3>
                <p>A classic, glowing, long-lasting look designed carefully for the special big day.</p>
            </div>
        </div>

        <div class="gallery-item">
            <div class="img-container">
                <span class="category-tag">Hair</span>
                <img src="soft curls.jpg" alt="Hair Styling">
            </div>
            <div class="item-info">
                <h3>Trendy Soft Curls</h3>
                <p>Perfect bouncy curls paired with professional hair nourishing treatment.</p>
            </div>
        </div>

        <div class="gallery-item">
            <div class="img-container">
                <span class="category-tag">Nails</span>
                <img src="art.jpg" alt="Nail Art">
            </div>
            <div class="item-info">
                <h3>Luxury Gel Nail Art</h3>
                <p>Custom pastel shades and glossy finish extensions tailored to match client requests.</p>
            </div>
        </div>

        <div class="gallery-item">
            <div class="img-container">
                <span class="category-tag">Skincare</span>
                <img src="skin.jpg" alt="Facial Skincare">
            </div>
            <div class="item-info">
                <h3>Gold Glow Facial</h3>
                <p>Refreshing multi-step facial to restore skin moisture and natural glowing skin.</p>
            </div>
        </div>

        <div class="gallery-item">
            <div class="img-container">
                <span class="category-tag">Makeup</span>
                <img src="party.jpg" alt="Party Makeup">
            </div>
            <div class="item-info">
                <h3>Glam Evening Makeup</h3>
                <p>Elegant smokey eyes and bold lips layout made for night parties and occasions.</p>
            </div>
        </div>

        <div class="gallery-item">
            <div class="img-container">
                <span class="category-tag">Hair Color</span>
                <img src="hair color.jpg" alt="Hair Coloring">
            </div>
            <div class="item-info">
                <h3>Premium Highlights</h3>
                <p>Damage-free hair coloring and soft balayage blending to match modern trends.</p>
            </div>
        </div>

    </main>

</body>
</html>