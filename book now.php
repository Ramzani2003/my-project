<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book An Appointment | Glow & Glamour Parlor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* CSS Reset and Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Booking Section Styling */
        .booking-section {
            padding: 80px 0;
            background-color: #fdfaf7;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .booking-grid {
            display: grid;
            grid-template-columns: 4fr 6fr; 
            gap: 60px;
            align-items: start;
        }

        /* Info Column details */
        .booking-info .sub-title {
            color: #d63384;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 14px;
            display: block;
            margin-bottom: 10px;
        }

        .booking-info h2 {
            font-size: 36px;
            color: #2c231e;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .booking-info p {
            color: #666;
            margin-bottom: 40px;
        }

        .info-list .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-item i {
            font-size: 20px;
            color: #d63384;
            background: #ffeef5;
            padding: 15px;
            border-radius: 50%;
        }

        .info-item h4 {
            color: #2c231e;
            font-size: 16px;
            font-weight: 600;
        }

        .info-item p {
            color: #777;
            margin-bottom: 0;
            font-size: 14px;
        }

        /* Form Container Card Layout */
        .booking-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f1f1;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .booking-form label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2c231e;
            margin-bottom: 8px;
        }

        /* Icon integrated Form inputs fields */
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            color: #aaa;
            font-size: 16px;
            pointer-events: none;
        }

        .input-wrapper input,
        .input-wrapper select,
        .booking-form textarea {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #e2d9d5;
            background-color: #fff;
            color: #333;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .booking-form textarea {
            padding: 15px; 
            resize: vertical;
        }

        .input-wrapper input:focus,
        .input-wrapper select:focus,
        .booking-form textarea:focus {
            border-color: #d63384;
            box-shadow: 0 0 0 3px rgba(214, 51, 132, 0.1);
        }

        /* Action Submit Trigger Button */
        .submit-btn {
            width: 100%;
            padding: 15px;
            background-color: #d63384;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(214, 51, 132, 0.25);
        }

        .submit-btn:hover {
            background-color: #b8236c;
            transform: translateY(-2px);
        }

        /* Mobile Compatibility Adaptation rules */
        @media (max-width: 992px) {
            .booking-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }

        @media (max-width: 576px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .booking-card {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>

    <section class="booking-section">
        <div class="container">
            <div class="booking-grid">
                
                <div class="booking-info">
                    <span class="sub-title">Quick Booking</span>
                    <h2>Reserve Your Spot Today</h2>
                    <p>Please fill out the form to schedule your premium treatment. Our team will review your preferred date and contact you immediately via email or phone to confirm.</p>
                    
                    <div class="info-list">
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h4>Working Hours</h4>
                                <p>Mon - Sun: 9:00 AM - 8:00 PM</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <h4>Need Urgent Booking?</h4>
                                <p>Call us: +94 11 234 5678</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="booking-card">
                    
                    <form action="process_booking.php" method="POST" class="booking-form">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fullname">Full Name</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-user"></i>
                                    <input type="text" id="fullname" name="fullname" placeholder="Enter your name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-phone"></i>
                                    <input type="tel" id="phone" name="phone" placeholder="07XXXXXXXX" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" placeholder="email" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="service">Select Service</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-spa"></i>
                                    <select id="service" name="service" required>
                                        <option value="" disabled selected>Choose a service</option>
                                        <option value="Hair Styling & Cut">Hair Styling & Cut</option>
                                        <option value="Bridal Makeover">Bridal Makeover</option>
                                        <option value="Facials & Skincare">Facials & Skincare</option>
                                        <option value="Mani & Pedi">Mani & Pedi</option>
                                        <option value="Aromatherapy Massage">Aromatherapy Massage</option>
                                        <option value="Threading & Waxing">Threading & Waxing</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="stylist">Choose Stylist (Optional)</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-user-sparkles"></i>
                                    <select id="stylist" name="stylist">
                                         <option value="Any Available Expert">Any Available Expert</option>
                                         <option value="Sarah (Hair Expert)">Sarah (Hair Expert)</option>
                                         <option value="Elena (Makeup Specialist)">Elena (Makeup Specialist)</option>
                                         <option value="Priya (Skincare Therapist)">Priya (Skincare Therapist)</option>
                                         <option value="Divya (Aromatherapy Specialist)">Divya (Aromatherapy Specialist)</option>
                                         <option value="Malini (Mani & Pedi)">Malini (Mani & Pedi)</option>
                                         <option value="Janani (Threading Waxing)">Janani (Threading Waxing)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="date">Preferred Date</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-calendar-alt"></i>
                                    <input type="date" id="date" name="booking_date" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="time">Preferred Time</label>
                                <div class="input-wrapper">
                                    <i class="fas fa-clock"></i>
                                    <select id="time" name="booking_time" required>
                                        <option value="" disabled selected>Select time slot</option>
                                        <option value="09:00 AM">09:00 AM</option>
                                        <option value="11:00 AM">11:00 AM</option>
                                        <option value="01:00 PM">01:00 PM</option>
                                        <option value="03:00 PM">03:00 PM</option>
                                        <option value="05:00 PM">05:00 PM</option>
                                        <option value="07:00 PM">07:00 PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Special Requirements / Notes</label>
                            <textarea id="notes" name="notes" rows="3" placeholder="Any specific instructions, allergies, or choices..."></textarea>
                        </div>

                        <button type="submit" class="submit-btn">Confirm Appointment Booking</button>
                    </form>
                </div>

            </div>
        </div>
    </section>

   <script>
        
        document.getElementById('date').min = new Date().toISOString().split('T')[0];
    </script>
</body>
</html>