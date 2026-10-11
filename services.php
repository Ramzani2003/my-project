<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | Glow & Glamour Parlor</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
    /* Global settings assumed from previous file (Poppins font, reset etc.) */

/* Services Section Layout */
.services-section {
    padding: 80px 0;
    background-color: #fdfaf7;
}

.services-header {
    text-align: center;
    max-width: 600px;
    margin: 0 auto 60px auto;
}

.services-header .sub-title {
    color: #d63384;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-size: 14px;
    display: block;
    margin-bottom: 10px;
}

.services-header h2 {
    font-size: 36px;
    color: #2c231e;
    margin-bottom: 15px;
    font-weight: 700;
}

.services-header p {
    color: #666;
}

    header {
    background-color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 10%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    color: #d44179; /* Parlor Pink Theme */
}

nav ul {
    list-style: none;
    display: flex;
}

nav ul li {
    margin-left: 20px;
}

nav ul li a {
    text-decoration: none;
    color: #555;
    font-weight: 600;
    transition: 0.3s;
}

nav ul li a:hover, nav ul li a.active {
    color: #d44179;
}

/* Services Grid Layout */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

/* Individual Service Card Styling */
.service-card {
    background: #ffffff;
    padding: 40px 30px;
    border-radius: 20px;
    border: 1px solid #f1f1f1;
    text-align: center;
    position: relative;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(214, 51, 132, 0.08);
    border-color: #ffeef5;
}

/* Featured / Popular Card Styling */
.service-card.highlighted {
    border: 2px solid #d63384;
    background: #fffcfd;
}

.service-card .badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #d63384;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
    text-transform: uppercase;
}

/* Icons */
.service-icon {
    width: 70px;
    height: 70px;
    background: #ffeef5;
    color: #d63384;
    font-size: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 auto 25px auto;
    transition: all 0.3s ease;
}

.service-card:hover .service-icon {
    background: #d63384;
    color: #fff;
}

.service-card h3 {
    font-size: 22px;
    color: #2c231e;
    margin-bottom: 15px;
    font-weight: 600;
}

.service-card p {
    color: #777;
    font-size: 14px;
    margin-bottom: 25px;
    height: 66px; /* Keeps text alignment identical across cards */
    overflow: hidden;
}

/* Metadata (Price & Duration) */
.service-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #f5f5f5;
    padding-top: 15px;
    margin-bottom: 25px;
}

.service-meta .price {
    font-size: 20px;
    font-weight: 700;
    color: #d63384;
}

.service-meta .duration {
    font-size: 13px;
    color: #888;
}

.service-meta .duration i {
    margin-right: 4px;
}

/* Card Button */
.book-btn {
    display: block;
    width: 100%;
    padding: 12px;
    background: #fdfaf7;
    color: #2c231e;
    text-decoration: none;
    font-weight: 600;
    border-radius: 10px;
    border: 1px solid #e2d9d5;
    transition: all 0.3s ease;
}

.service-card:hover .book-btn {
    background: #d63384;
    color: #fff;
    border-color: #d63384;
    box-shadow: 0 5px 15px rgba(214, 51, 132, 0.2);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .services-header h2 {
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
<body>
    <header>
        <div class="logo">Glow & Grace</div>
        <nav>
            <ul>
                <li><a href="index.html" class="active">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="booking.html">Book Now</a></li>
                <li><a href="login.html">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="services-header">
                <span class="sub-title">What We Offer</span>
                <h2>Our Premium Beauty Services</h2>
                <p>Explore our range of specialized treatments designed to make you glow. Book your preferred slot instantly.</p>
            </div>

            <!-- Services Grid -->
            <div class="services-grid">
                
                <!-- Service 1: Hair Styling -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-cut"></i>
                    </div>
                    <h3>Hair Styling & Cut</h3>
                    <p>Trendy haircuts, standard styling, and professional coloring tailored to your face shape.</p>
                    <div class="service-meta">
                        <span class="price">Rs. 2,500+</span>
                        <span class="duration"><i class="far fa-clock"></i> 45 mins</span>
                    </div>
                    <a href="booking.html?service=hair" class="book-btn">Book Appointment</a>
                </div>

                <!-- Service 2: Bridal Makeup -->
                <div class="service-card highlighted">
                    <div class="badge">Popular</div>
                    <div class="service-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Bridal Makeover</h3>
                    <p>Complete HD bridal makeup, hairstyling, and saree draping for your special day.</p>
                    <div class="service-meta">
                        <span class="price">Rs. 25,000+</span>
                        <span class="duration"><i class="far fa-clock"></i> 3 hours</span>
                    </div>
                    <a href="booking.html?service=bridal" class="book-btn">Book Appointment</a>
                </div>

                <!-- Service 3: Facials & Skincare -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <h3>Facials & Skincare</h3>
                    <p>Deep cleansing, herbal facials, and skin glowing treatments using top premium brands.</p>
                    <div class="service-meta">
                        <span class="price">Rs. 3,500+</span>
                        <span class="duration"><i class="far fa-clock"></i> 60 mins</span>
                    </div>
                    <a href="booking.html?service=facial" class="book-btn">Book Appointment</a>
                </div>
                <br>
                <br>

                <!-- Service 4: Manicure & Pedicure -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-hands"></i>
                    </div>
                    <h3>Mani & Pedi</h3>
                    <p>Relaxing hand and foot spas including nail shaping, cuticle care, and gel polishing.</p>
                    <div class="service-meta">
                        <span class="price">Rs. 3,000+</span>
                        <span class="duration"><i class="far fa-clock"></i> 50 mins</span>
                    </div>
                    <a href="booking.html?service=manipedi" class="book-btn">Book Appointment</a>
                </div>

                <!-- Service 5: Body Massage -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-hot-stone"></i>
                    </div>
                    <h3>Aromatherapy Massage</h3>
                    <p>De-stress your mind and body with our soothing essential oil massage therapies.</p>
                    <div class="service-meta">
                        <span class="price">Rs. 5,000+</span>
                        <span class="duration"><i class="far fa-clock"></i> 90 mins</span>
                    </div>
                    <a href="booking.html?service=massage" class="book-btn">Book Appointment</a>
                </div>

                <!-- Service 6: Waxing & Threading -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Threading & Waxing</h3>
                    <p>Flawless eyebrow shaping and gentle full-body waxing for smooth, clean skin.</p>
                    <div class="service-meta">
                        <span class="price">Rs. 500+</span>
                        <span class="duration"><i class="far fa-clock"></i> 20 mins</span>
                    </div>
                    <a href="booking.html?service=waxing" class="book-btn">Book Appointment</a>
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