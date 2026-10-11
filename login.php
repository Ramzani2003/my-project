<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Glow & Glamour Parlor</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
    /* Auth Centered Container Styles */
.auth-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fdfaf7;
    padding: 40px 20px;
}

.auth-container {
    width: 100%;
    max-width: 450px;
}

.auth-card {
    background: #ffffff;
    padding: 45px 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    border: 1px solid #f1f1f1;
}

.auth-header {
    text-align: center;
    margin-bottom: 35px;
}

.auth-header h2 {
    font-size: 30px;
    color: #2c231e;
    font-weight: 700;
    margin-bottom: 10px;
}

.auth-header p {
    color: #777;
    font-size: 14px;
}

/* Label Utilities */
.label-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.label-row label {
    margin-bottom: 0; /* Clear bottom spacing since row aligns it */
}

.forgot-link {
    font-size: 13px;
    color: #d63384;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.forgot-link:hover {
    color: #b8236c;
}

/* Form Helper Options Layout */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.remember-me {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 14px;
    color: #666;
    user-select: none;
}

.remember-me input {
    accent-color: #d63384; /* Styles checkbox color */
    width: 16px;
    height: 16px;
    cursor: pointer;
}

/* Eye Password Visibility Toggle styling overrides */
.input-wrapper .toggle-password {
    position: absolute;
    right: 15px;
    left: auto; /* Overrides the default left positioning rule */
    color: #aaa;
    cursor: pointer;
    pointer-events: auto; /* Enables clicks on the right-side eye icon */
    transition: color 0.3s ease;
}

.input-wrapper .toggle-password:hover {
    color: #d63384;
}

/* Card redirect adjustments */
.auth-footer {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #f5f5f5;
    font-size: 14px;
    color: #666;
}

.auth-footer a {
    color: #d63384;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.auth-footer a:hover {
    color: #b8236c;
}

/* Mobile Responsiveness View adjustments */
@media (max-width: 480px) {
    .auth-card {
        padding: 30px 20px;
    }
    .auth-header h2 {
        font-size: 26px;
    }
}
</style>
<body>

    <!-- Login Container Wrap -->
    <section class="auth-section">
        <div class="auth-container">
            <div class="auth-card">
                
                <!-- Branding Header -->
                <div class="auth-header">
                    <h2>Welcome Back</h2>
                    <p>Log in to manage your appointments and services</p>
                </div>

                <!-- Form Action targeted to validation script -->
                <form action="login-auth.php" method="POST" class="auth-form">
                    
                    <!-- Email Input Group -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="enter your email" required>
                        </div>
                    </div>

                    <!-- Password Input Group -->
                    <div class="form-group">
                        <div class="label-row">
                            <label for="password">Password</label>
                            <a href="forgot-password.html" class="forgot-link">Forgot?</a>
                        </div>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" placeholder="••••••••" required>
                            <!-- Password view toggle icon -->
                            <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
                        </div>
                    </div>

                    <!-- Remember Me Option -->
                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                    </div>

                    <!-- Submit Action Button -->
                    <button type="submit" class="submit-btn">Sign In</button>
                </form>

                <!-- Redirect Navigation Footer -->
                <div class="auth-footer">
                    <p>Don't have an account? <a href="signup.html">Create Account</a></p>
                </div>

            </div>
        </div>
    </section>

    <!-- JavaScript to Toggle Password Visibility -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the eye icon classes
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>