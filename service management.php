<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beauty_parlor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ─── 1. ACTION: ADD NEW SERVICE ───
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = trim($_POST['service_name']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $duration = intval($_POST['duration']);
    $desc = trim($_POST['description']);
    
    $image = "default.jpg"; 
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        // move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $link = strtolower(str_replace(' ', '_', $name)) . ".php";

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO tbl_services (service_name, category, service_image, service_link, description, price, duration) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssdi", $name, $category, $image, $link, $desc, $price, $duration);
        if ($stmt->execute()) {
            $_SESSION['toast_msg'] = "New service '$name' added successfully!";
        }
        $stmt->close();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// ─── 2. ACTION: UPDATE/EDIT SERVICE ───
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $service_id = intval($_POST['service_id']);
    $name = trim($_POST['service_name']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $duration = intval($_POST['duration']);
    $desc = trim($_POST['description']);
    
    // படம் மாற்றப்பட்டிருந்தால் மட்டும் புதுப்பிக்கும் லாஜிக்
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        // move_uploaded_file($_FILES['image']['tmp_name'], $image);
        $stmt = $conn->prepare("UPDATE tbl_services SET service_name=?, category=?, service_image=?, description=?, price=?, duration=? WHERE service_id=?");
        $stmt->bind_param("ssssdii", $name, $category, $image, $desc, $price, $duration, $service_id);
    } else {
        $stmt = $conn->prepare("UPDATE tbl_services SET service_name=?, category=?, description=?, price=?, duration=? WHERE service_id=?");
        $stmt->bind_param("sssdii", $name, $category, $desc, $price, $duration, $service_id);
    }
    
    if ($stmt->execute()) {
        $_SESSION['toast_msg'] = "Service details updated successfully!";
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// ─── 3. ACTION: DELETE SERVICE ───
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM tbl_services WHERE service_id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $_SESSION['toast_msg'] = "Service removed successfully!";
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch live items for the dashboard
$sql = "SELECT * FROM tbl_services ORDER BY service_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Management - Beauty Parlor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f7f9fc; color: #333; }
        .dashboard-container { display: flex; min-height: 100vh; }

        /* SIDEBAR LAYOUT */
        .sidebar { width: 260px; background-color: #1a1a2e; color: #fff; padding: 20px; display: flex; flex-direction: column; position: fixed; height: 100vh; }
        .sidebar .logo { padding: 15px 10px; margin-bottom: 30px; border-bottom: 1px solid #2e2e4f; }
        .sidebar .logo h2 { size: 1.3rem; color: #ff758f; }
        .nav-links a { color: #b0b0d0; text-decoration: none; padding: 12px 15px; border-radius: 8px; font-size: 0.95rem; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; transition: all 0.3s ease; }
        .nav-links a:hover, .nav-links a.active { background-color: #ff758f; color: #fff; }

        /* MAIN BODY CONTENT */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        .main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .main-header h1 { font-size: 1.8rem; font-weight: 600; color: #1a1a2e; }
        .subtitle { font-size: 0.9rem; color: #777; margin-top: 2px; }

        /* TOAST BOX */
        .toast-box { background-color: #2ecc71; color: white; padding: 12px 20px; border-radius: 8px; margin-bottom: 25px; font-size: 14px; display: flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(46,204,113,0.2); }

        /* TOOL BAR */
        .filter-bar { display: flex; justify-content: space-between; margin-bottom: 30px; gap: 20px; }
        .search-box { background-color: #fff; padding: 10px 15px; border-radius: 8px; display: flex; align-items: center; gap: 10px; width: 350px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .search-box input { border: none; outline: none; width: 100%; font-size: 0.9rem; }
        .filter-dropdowns select { padding: 10px 15px; border-radius: 8px; border: 1px solid #dddfeb; background-color: #fff; outline: none; color: #555; }

        .btn-primary { background-color: #ff758f; color: white; border: none; padding: 11px 22px; border-radius: 8px; cursor: pointer; font-weight: 500; display: flex; align-items: center; gap: 8px; transition: background 0.2s; }
        .btn-primary:hover { background-color: #e0536e; }

        /* SERVICES GRID SYSTEM */
        .services-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; }
        .service-card { background-color: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); display: flex; flex-direction: column; transition: transform 0.3s ease; }
        .service-card:hover { transform: translateY(-5px); }
        .service-img-wrapper { position: relative; height: 180px; width: 100%; background-color: #eaeaea; }
        .service-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        .category-badge { position: absolute; top: 12px; left: 12px; background-color: rgba(26, 26, 46, 0.85); color: #fff; padding: 4px 10px; font-size: 0.75rem; border-radius: 20px; font-weight: 500; }
        
        .service-info { padding: 20px; display: flex; flex-direction: column; flex: 1; }
        .service-info h3 { font-size: 1.1rem; color: #1a1a2e; margin-bottom: 8px; }
        .service-info .description { font-size: 0.85rem; color: #666; line-height: 1.5; margin-bottom: 15px; flex: 1; }
        .meta-details { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0f2f5; padding-top: 12px; margin-bottom: 15px; }
        .meta-details .price { font-size: 1.2rem; font-weight: 700; color: #ff758f; }
        .meta-details .duration { font-size: 0.85rem; color: #777; }

        .card-actions { display: flex; gap: 10px; }
        .card-actions a, .card-actions button { flex: 1; padding: 8px; border-radius: 6px; cursor: pointer; font-weight: 500; font-size: 0.85rem; border: none; display: flex; justify-content: center; align-items: center; gap: 6px; text-decoration: none; }
        .btn-edit { background-color: #f0f2f5; color: #495057; }
        .btn-edit:hover { background-color: #e2e5e9; }
        .btn-delete { background-color: #fff5f5; color: #e03131; }
        .btn-delete:hover { background-color: #ffe3e3; }

        /* FORM MODAL STYLING */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); display: none; justify-content: center; align-items: center; z-index: 1000; }
        .modal-box { background-color: #fff; border-radius: 12px; width: 500px; max-width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.1); animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { padding: 20px; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; }
        .modal-header h2 { font-size: 1.25rem; color: #1a1a2e; }
        .close-modal-btn { background: none; border: none; font-size: 1.8rem; cursor: pointer; color: #aaa; }
        .modal-form { padding: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 500; color: #444; margin-bottom: 5px; }
        
        .form-group input[type="text"], .form-group input[type="number"], .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #dddfeb; border-radius: 6px; outline: none; font-size: 0.9rem; }
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
        .form-buttons { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-secondary { background-color: #f0f2f5; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; color: #555; }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="logo">
                <h2><i class="fa-solid fa-wand-magic-sparkles"></i> GlowAdmin</h2>
            </div>
            <nav class="nav-links">
                <a href="admindashboard.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                <a href="admin appointment.php"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
                <a href="service management.php" class="active"><i class="fa-solid fa-scissors"></i> Service Management</a>
                <a href="stylist management.php"><i class="fa-solid fa-users"></i> Stylist Management</a>
                <a href="master calendar.php"><i class="fa-solid fa-calendar-days"></i> Master Calendar</a>
                <a href="customers.php"><i class="fa-solid fa-address-book"></i> Customers (CRM)</a>
                <a href="payment invoicing.php"><i class="fa-solid fa-file-invoice-dollar"></i> Payments & Invoices</a>
                <a href="setting.php"><i class="fa-solid fa-sliders"></i> General Settings</a>
            </nav>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <main class="main-content">
            <header class="main-header">
                <div>
                    <h1>Service Management</h1>
                    <p class="subtitle">Manage your beauty treatments, pricing, and timing profiles dynamically</p>
                </div>
                <button class="btn-primary" onclick="openAddModal()">
                    <i class="fa-solid fa-plus"></i> Add New Service
                </button>
            </header>

            <!-- Notification Messages -->
            <?php if (isset($_SESSION['toast_msg'])): ?>
                <div class="toast-box" id="toastBox">
                    <i class="fa-solid fa-circle-check"></i> <?php echo $_SESSION['toast_msg']; ?>
                </div>
                <?php unset($_SESSION['toast_msg']); ?>
            <?php endif; ?>

            <!-- Search and Filter Tools -->
            <section class="filter-bar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Search services..." onkeyup="searchServices()">
                </div>
                <div class="filter-dropdowns">
                    <select id="categoryFilter" onchange="filterCategory()">
                        <option value="">All Categories</option>
                        <option value="Hair Care">Hair Care</option>
                        <option value="Makeup & Bridal">Makeup & Bridal</option>
                        <option value="Skin & Facial">Skin & Facial</option>
                        <option value="Mani & Pedi">Mani & Pedi</option>
                        <option value="Aromatheraphy Massage">Aromatheraphy Massage</option>
                        <option value="Threading Waxing">Threading Waxing</option>
                    </select>
                </div>
            </section>

            <!-- SERVICES LIVE GRID SYSTEM -->
            <section class="services-grid" id="servicesGrid">
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $card_cat = !empty($row['category']) ? htmlspecialchars($row['category']) : 'General';
                        
                        // டேட்டாபேஸில் உள்ள அசல் மதிப்பை எடுக்கிறோம்
                        $raw_price = !empty($row['price']) ? floatval($row['price']) : 0.00;
                        $card_price = number_format($raw_price, 2);
                        
                        $card_duration = !empty($row['duration']) ? intval($row['duration']) : '30';
                        $service_desc = !empty($row['description']) ? htmlspecialchars($row['description']) : '';
                        $service_name = htmlspecialchars($row['service_name']);
                        ?>
                        <div class="service-card" data-category="<?php echo $card_cat; ?>">
                            <div class="service-img-wrapper">
                                <img src="<?php echo htmlspecialchars($row['service_image']); ?>" alt="Service Pic">
                                <span class="category-badge"><?php echo $card_cat; ?></span>
                            </div>
                            <div class="service-info">
                                <h3><?php echo $service_name; ?></h3>
                                <p class="description"><?php echo $service_desc; ?></p>
                                <div class="meta-details">
                                    <span class="price">Rs. <?php echo $card_price; ?></span>
                                    <span class="duration"><i class="fa-regular fa-clock"></i> <?php echo $card_duration; ?> mins</span>
                                </div>
                                <div class="card-actions">
                                    <!-- Edit செய்ய தேவையான விபரங்கள் தரவுகளாக (data-attributes) அனுப்பப்படுகிறது -->
                                    <button class="btn-edit" 
                                            onclick="openEditModal(<?php echo $row['service_id']; ?>, '<?php echo addslashes($service_name); ?>', '<?php echo $raw_price; ?>', <?php echo $card_duration; ?>, '<?php echo addslashes($card_cat); ?>', '<?php echo addslashes($service_desc); ?>')">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </button>
                                    <a href="service management.php?delete_id=<?php echo $row['service_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this service card?')">
                                        <i class="fa-solid fa-trash-can"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p style='grid-column: 1/-1; text-align:center; color:#888; padding:30px;'>No active services found in database grid.</p>";
                }
                ?>
            </section>
        </main>
    </div>

    <!-- DYNAMIC FORM MODAL (ADD & EDIT இரண்டிற்கும் இதுவே பயன்படும்) -->
    <div class="modal-overlay" id="serviceModal">
        <div class="modal-box">
            <div class="modal-header">
                <h2 id="modalTitle">Add New Service Offer</h2>
                <button class="close-modal-btn" onclick="closeModal()">&times;</button>
            </div>
            <form class="modal-form" action="service management.php" method="POST" enctype="multipart/form-data">
                <!-- Hidden inputs for identifying action types -->
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="service_id" id="serviceId">
                
                <div class="form-group">
                    <label for="serviceName">Service Name</label>
                    <input type="text" id="serviceName" name="service_name" placeholder="e.g., Gold Radiance Facial" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price (Rs)</label>
                        <input type="number" id="price" name="price" step="0.01" placeholder="50.00" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration (Minutes)</label>
                        <input type="number" id="duration" name="duration" placeholder="45" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="Hair Care">Hair Care</option>
                        <option value="Makeup & Bridal">Makeup & Bridal</option>
                        <option value="Skin & Facial">Skin & Facial</option>
                        <option value="Mani & Pedi">Mani & Pedi</option>
                        <option value="Aromatheraphy Massage">Aromatheraphy Massage</option>
                        <option value="Threading Waxing">Threading Waxing</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Short Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Describe the treatment benefits..."></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Upload Service Image</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>

                <div class="form-buttons">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-primary" id="submitBtn">Save Service</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript Functionalities -->
    <script>
        const modal = document.getElementById('serviceModal');

        // Add Service க்கான பாப்-அப் விண்டோ
        function openAddModal() {
            document.getElementById('modalTitle').innerText = "Add New Service Offer";
            document.getElementById('formAction').value = "add";
            document.getElementById('submitBtn').innerText = "Save Service";
            
            // பழைய தரவுகளை ஃபார்மில் இருந்து நீக்குதல்
            document.getElementById('serviceId').value = "";
            document.getElementById('serviceName').value = "";
            document.getElementById('price').value = "";
            document.getElementById('duration').value = "";
            document.getElementById('category').selectedIndex = 0;
            document.getElementById('description').value = "";
            
            modal.style.display = 'flex';
        }

        // Edit Service க்கான பாப்-அப் விண்டோ (தரவுகளுடன் திறக்கும்)
        function openEditModal(id, name, price, duration, category, description) {
            document.getElementById('modalTitle').innerText = "Edit Service Details";
            document.getElementById('formAction').value = "edit";
            document.getElementById('submitBtn').innerText = "Update Service";
            
            // தரவுகளை ஃபார்மில் நிரப்புதல்
            document.getElementById('serviceId').value = id;
            document.getElementById('serviceName').value = name;
            document.getElementById('price').value = price;
            document.getElementById('duration').value = duration;
            document.getElementById('category').value = category;
            document.getElementById('description').value = description;
            
            modal.style.display = 'flex';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        // Auto fade out Success alerts
        const alertBox = document.getElementById('toastBox');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.transition = "opacity 0.5s ease";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500);
            }, 3000);
        }

        // Live JavaScript Search Filter
        function searchServices() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let cards = document.getElementsByClassName('service-card');
            
            for (let i = 0; i < cards.length; i++) {
                let title = cards[i].getElementsByTagName('h3')[0].innerText.toLowerCase();
                let desc = cards[i].getElementsByClassName('description')[0].innerText.toLowerCase();
                if (title.includes(input) || desc.includes(input)) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }

        // Live JavaScript Category Filter
        function filterCategory() {
            let selected = document.getElementById('categoryFilter').value;
            let cards = document.getElementsByClassName('service-card');
            
            for (let i = 0; i < cards.length; i++) {
                let cardCat = cards[i].getAttribute('data-category');
                if (selected === "" || cardCat === selected) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>