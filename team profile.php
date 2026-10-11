<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team Profiles</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* General Setup */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
}

/* Cards Layout */
.team-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.card {
    background: white;
    padding: 30px 20px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    text-align: center;
    width: 250px;
    border: 1px solid #eee;
}

.card h3 {
    margin: 10px 0 5px 0;
    color: #333;
}

.role {
    color: #a04462; 

    font-weight: 600;
    font-size: 14px;
    margin-bottom: 5px;
}

.rating {
    font-size: 13px;
    color: #666;
    margin-bottom: 20px;
}


.view-btn {
    display: inline-block;
    text-decoration: none;
    color: #a04462;
    border: 1px solid #a04462;
    padding: 8px 25px;
    border-radius: 20px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.view-btn:hover {
    background-color: #a04462;
    color: white;
}



.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); 
    display: none; 
    justify-content: center;
    align-items: center;
    z-index: 1000;
}


.modal-overlay:target {
    display: flex;
}

.modal-box {
    background: white;
    padding: 30px;
    border-radius: 12px;
    width: 400px;
    max-width: 90%;
    position: relative;
    text-align: left;
    box-shadow: 0 5px 25px rgba(0,0,0,0.2);
    animation: fadeIn 0.3s ease-in-out;
}

.modal-role {
    color: #a04462;
    font-weight: bold;
    margin-top: -5px;
}

/* Close (X) Button */
.close-btn {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 28px;
    text-decoration: none;
    color: #999;
}

.close-btn:hover {
    color: #333;
}

/* Simple animation for smooth appearance */
@keyframes fadeIn {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
</style>
<body>

    <h2 style="text-align:center; margin-top:30px; font-family: Arial, sans-serif;">Our Team</h2>

    <div class="team-container">
        
        <div class="card">
            <h3>Sarah John</h3>
            <p class="role">Hair Styling Expert</p>
            <p class="rating">⭐ 4.8 (95+ Reviews)</p>
            <a href="#profile-sarah" class="view-btn">View Profile</a>
        </div>

        <div class="card">
            <h3>Elena Rose</h3>
            <p class="role">Advanced Makeup Artist</p>
            <p class="rating">⭐ 4.9 (110+ Reviews)</p>
            <a href="#profile-elena" class="view-btn">View Profile</a>
        </div>

    </div>

    <div id="profile-sarah" class="modal-overlay">
        <div class="modal-box">
            <a href="#" class="close-btn">&times;</a>
            <h2>Sarah John</h2>
            <p class="modal-role">Hair Styling Expert</p>
            <hr>
            <p><strong>Experience:</strong> 5+ Years in professional hair styling.</p>
            <p><strong>Specialties:</strong> Bridal hair design, modern cuts, and coloring.</p>
            <p>Sarah is dedicated to bringing out the best look for your special days.</p>
        </div>
    </div>

    <div id="profile-elena" class="modal-overlay">
        <div class="modal-box">
            <a href="#" class="close-btn">&times;</a>
            <h2>Elena Rose</h2>
            <p class="modal-role">Advanced Makeup Artist</p>
            <hr>
            <p><strong>Experience:</strong> 7+ Years in HD & Airbrush makeup.</p>
            <p><strong>Specialties:</strong> Celebrity styling and cinematic makeup.</p>
            <p>Elena ensures a flawless, long-lasting glow for every skin type.</p>
        </div>
    </div>

</body>
</html>