<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Glow & Grace Beauty Parlor</title>
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

        /* Header Section */
        .contact-header {
            text-align: center;
            padding: 60px 20px 40px 20px;
        }

        .contact-header h1 {
            color: #d63384;
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .contact-header p {
            color: #6c757d;
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Main Container: Flexible Split Grid */
        .contact-wrapper {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
        }

        /* Left Column: Info Details Block */
        .contact-info-panel {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .contact-info-panel h2 {
            color: #2d3748;
            font-size: 22px;
            margin-bottom: 25px;
            border-left: 4px solid #d63384;
            padding-left: 10px;
        }

        .info-item {
            margin-bottom: 25px;
        }

        .info-item h4 {
            color: #d63384;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-item p {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.6;
        }

        /* Right Column: Interactive Form Box */
        .contact-form-panel {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .contact-form-panel h2 {
            color: #2d3748;
            font-size: 22px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-size: 14px;
            font-weight: 600;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group textarea {
            resize: none;
            height: 120px;
        }

        .form-group input:focus, .form-group textarea:focus {
            border-color: #d63384;
            box-shadow: 0 0 0 3px rgba(214, 51, 132, 0.15);
        }

        /* Submit Message Button */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background-color: #d63384;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #b8266f;
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
                <li><a href="gallary.php">Gallery</a></li>
                <li><a href="teampage.php">Team</a></li>
                <li><a href="beautician profile.php">Beautician Profile</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Header Section -->
    <section class="contact-header">
        <h1>Get In Touch</h1>
        <p>Have questions about our bridal packages, specialized treatments, or pricing details? Contact us or drop a message below.</p>
    </section>

    <!-- Main Content Layout Section -->
    <main class="contact-wrapper">
        
        <!-- Left Side: Contact Information Panel -->
        <section class="contact-info-panel">
            <h2>Our Contact Details</h2>
            
            <div class="info-item">
                <h4>Find Us At (Address)</h4>
                <p>211 A/3,<br>Munthiriyadi Road,<br>Sainthamaruthu-12.</p>
            </div>

            <div class="info-item">
                <h4>Call & Bookings</h4>
                <p>+94 754543878<br>+94 770094618</p>
            </div>

            <div class="info-item">
                <h4>Support Email</h4>
                <p>appointments@glowandgrace.com<br>info@glowandgrace.com</p>
            </div>

            <div class="info-item">
                <h4>Salon Operating Hours</h4>
                <p>Monday - Saturday: 09:00 AM - 08:00 PM<br>Sunday: 10:00 AM - 04:00 PM</p>
            </div>
        </section>

        <!-- Right Side: Interaction Contact Form -->
        <section class="contact-form-panel">
            <h2>Send A Message</h2>
            
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="contact-name">Your Full Name</label>
                    <input type="text" id="contact-name" name="name" placeholder="" required>
                </div>

                <div class="form-group">
                    <label for="contact-email">Email Address</label>
                    <input type="email" id="contact-email" name="email" placeholder="" required>
                </div>

                <div class="form-group">
                    <label for="contact-subject">Inquiry Subject</label>
                    <input type="text" id="contact-subject" name="subject" placeholder="" required>
                </div>

                <div class="form-group">
                    <label for="contact-message">Type Your Message</label>
                    <textarea id="contact-message" name="message" placeholder="" required></textarea>
                </div>

                <button type="submit" class="btn-submit">Send Message</button>
            </form>
        </section>

    </main>

</body>
</html>