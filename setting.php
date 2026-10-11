<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glow & Grace - General Settings</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    /* கூகுள் ஃபான்ட் */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f3f4f6;
    color: #1f2937;
}

.container {
    display: flex;
    min-height: 100vh;
}

/* SIDEBAR STYLES (Common) */
.sidebar {
    width: 260px;
    background-color: #111827;
    color: #ffffff;
    padding: 20px 0;
}

.logo h2 {
    color: #f43f5e;
    text-align: center;
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 40px;
}

.menu {
    display: flex;
    flex-direction: column;
}

.menu a {
    color: #9ca3af;
    text-decoration: none;
    padding: 14px 25px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: 0.3s;
}

.menu a:hover, .menu a.active {
    color: #ffffff;
    background-color: #f43f5e;
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
    margin-right: 15px;
}

/* MAIN CONTENT (Common) */
.main-content {
    flex: 1;
    padding: 30px;
}

.main-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.title-area h1 {
    font-size: 26px;
    color: #111827;
}

.title-area p {
    color: #6b7280;
    font-size: 13px;
    margin-top: 5px;
}

.admin-profile {
    display: flex;
    align-items: center;
    gap: 20px;
}

.notification-icon {
    font-size: 20px;
    color: #6b7280;
}

.admin-info h4 { font-size: 14px; color: #111827; }
.admin-info span { font-size: 12px; color: #9ca3af; }


/* SETTINGS SPECIFIC STYLES */
.settings-container {
    display: flex;
    gap: 30px;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

/* Left Vertical Tabs */
.settings-tabs {
    width: 220px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    border-right: 1px solid #e5e7eb;
    padding-right: 20px;
}

.tab-btn {
    background: none;
    border: none;
    padding: 12px 15px;
    text-align: left;
    font-size: 14px;
    color: #4b5563;
    cursor: pointer;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.2s;
}

.tab-btn:hover {
    background-color: #f3f4f6;
    color: #111827;
}

.tab-btn.active {
    background-color: #fef1f2;
    color: #f43f5e;
    font-weight: 500;
}

/* Right Form Box */
.settings-form-box {
    flex: 1;
}

.form-title {
    font-size: 18px;
    color: #111827;
    margin-bottom: 20px;
}

/* Profile Photo Upload Layout */
.profile-upload-area {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
}

.avatar-preview {
    width: 70px;
    height: 70px;
    background-color: #f3f4f6;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    color: #9ca3af;
    border: 1px solid #e5e7eb;
}

.upload-text p {
    font-size: 12px;
    color: #9ca3af;
    margin-top: 5px;
}

.upload-btn {
    padding: 6px 12px;
    font-size: 12px;
    border: 1px solid #e5e7eb;
    background: #fff;
    border-radius: 6px;
    cursor: pointer;
}

/* Form Input Elements */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-size: 13px;
    font-weight: 500;
    color: #374151;
}

.form-group input, .form-group select {
    padding: 10px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    color: #111827;
    transition: 0.2s;
}

.form-group input:focus, .form-group select:focus {
    border-color: #f43f5e;
    box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.1);
}

.disabled-input {
    background-color: #f3f4f6;
    cursor: not-allowed;
    color: #9ca3af !important;
}

.form-divider {
    border: 0;
    border-top: 1px solid #e5e7eb;
    margin: 30px 0;
}

/* Bottom Actions Panel */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 30px;
}

.btn {
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 8px;
    cursor: pointer;
    border: none;
}

.cancel-btn {
    background-color: #f3f4f6;
    color: #4b5563;
}

.cancel-btn:hover { background-color: #e5e7eb; }

.save-btn {
    background-color: #f43f5e;
    color: white;
}

.save-btn:hover { background-color: #e11d48; }

/* Responsive Grid adjustment */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    .settings-container {
        flex-direction: column;
    }
    .settings-tabs {
        width: 100%;
        border-right: none;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 15px;
        flex-direction: row;
        overflow-x: auto;
    }
}
</style>
<body>

    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <h2>Glow & Grace</h2>
            </div>
            <nav class="menu">
                <a href="admindashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                <a href="admin appointment.php"><i class="fa-solid fa-appointment"></i> Appointments</a>
                <a href="service Management.php"><i class="fa-solid fa-scissors"></i> Service Management</a>
                <a href="stylist Management.php"><i class="fa-solid fa-users-gear"></i> Stylist Management</a>
                <a href="master calenter.php"><i class="fa-solid fa-calendar-days"></i> Master Calendar</a>
                <a href="customers.php"><i class="fa-solid fa-user-group"></i> Customers (CRM)</a>
                <a href="payment invoicing.php"><i class="fa-solid fa-file-invoice-dollar"></i> Payments & Invoices</a>
                <a href="setting.php" class="active"><i class="fa-solid fa-gear"></i> General Settings</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="title-area">
                    <h1>General Settings</h1>
                    <p>Update your salon configuration, profile, and security preferences.</p>
                </div>
                <div class="admin-profile">
                    <i class="fa-solid fa-bell notification-icon"></i>
                    <div class="admin-info" a href="profile.jpg">
                        <h4>Admin Manager</h4>
                        <span>Super Admin</span>
                    </div>
                </div>
            </header>

            <div class="settings-container">
                
                <div class="settings-tabs">
                    <button class="tab-btn active"><i class="fa-regular fa-user"></i> Profile Info</button>
                    <button class="tab-btn"><i class="fa-solid fa-shop"></i> Salon Details</button>
                    <button class="tab-btn"><i class="fa-solid fa-lock"></i> Security & Password</button>
                    <button class="tab-btn"><i class="fa-regular fa-bell"></i> Notifications</button>
                </div>

                <div class="settings-form-box">
                    <form>
                        <h3 class="form-title">Profile Information</h3>
                        
                        <div class="profile-upload-area">
                            <div class="avatar-preview">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <div class="upload-text">
                                <button type="button" class="btn upload-btn">Change Photo</button>
                                <p>JPG or PNG. Max size of 800K</p>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="username">Full Name</label>
                                <input type="text" id="username" value="Admin Manager">
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" value="admin@glowandgrace.com">
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" id="phone" value="+94 771234567">
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <input type="text" id="role" value="Super Admin" disabled class="disabled-input">
                            </div>
                        </div>

                        <hr class="form-divider">

                        <h3 class="form-title">Business Settings</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select id="currency">
                                    <option value="LKR">LKR (Rs)</option>
                                    <option value="USD">USD ($)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="timezone">Time Zone</label>
                                <select id="timezone">
                                    <option>Colombo (GMT+5:30)</option>
                                    <option>London (GMT+0)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn cancel-btn">Cancel</button>
                            <button type="submit" class="btn save-btn">Save Changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

</body>
</html>