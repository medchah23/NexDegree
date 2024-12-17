<?php
include "../../../controller/UserController.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../../frontoffice/html/sign_in.html");
    exit();
}

$controller = new userController();
$user1 = $controller->getUserById($_SESSION["user_id"]);
$image_src = ($user1['image'] && file_exists("../../../uploads/images/" . basename($user1['image'])))
    ? "../../../uploads/images/" . basename($user1['image'])
    : "https://via.placeholder.com/50";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f9;
        }
        .profile-container {
            max-width: 400px;
            width: 100%;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .profile-card {
            padding: 20px;
            text-align: center;
        }
        .profile-header {
            position: relative;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid #3498db;
        }
        .edit-pic-btn {
            margin-top: 10px;
            background: #3498db;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-pic-btn:hover {
            background: #217dbb;
        }
        .profile-details h1 {
            margin: 10px 0;
            font-size: 24px;
        }
        .profile-details p {
            color: #666;
        }
        .edit-btn {
            margin-top: 15px;
            background: #2ecc71;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-btn:hover {
            background: #27ae60;
        }
        .edit-form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .hidden {
            display: none;
        }
        .edit-form input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .edit-form button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-form button:first-of-type {
            background: #3498db;
            color: white;
        }
        .edit-form button:last-of-type {
            background: #e74c3c;
            color: white;
        }
        .edit-form button:first-of-type:hover {
            background: #217dbb;
        }
        .edit-form button:last-of-type:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <img src="<?php echo $image_src; ?>"
                 alt="Profile Picture"
                 class="profile-pic"
                 id="profilePic">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*" onchange="previewPhoto()">
                <button type="button" class="edit-pic-btn" onclick="document.getElementById('photoInput').click()">Change Picture</button>
            </form>
        </div>
        <div class="profile-details">
            <h1 id="fullName"><?php echo htmlspecialchars($user1["nom"]); ?></h1>
            <p id="email"><?php echo htmlspecialchars($user1["email"]); ?></p>
            <p id="phone"><?php echo htmlspecialchars($user1["numero_telephone"]); ?></p>
            <button class="edit-btn" onclick="enableEditing()">Edit Profile</button>
        </div>
        <form id="editForm" class="edit-form hidden">
            <input type="text" id="nameInput" placeholder="Full Name" value="<?php echo htmlspecialchars($user1["nom"]); ?>">
            <input type="email" id="emailInput" placeholder="Email" value="<?php echo htmlspecialchars($user1["email"]); ?>">
            <input type="tel" id="phoneInput" placeholder="Phone" value="<?php echo htmlspecialchars($user1["numero_telephone"]); ?>">
            <button type="button" onclick="saveChanges()">Save</button>
            <button type="button" onclick="cancelEditing()">Cancel</button>
        </form>
    </div>
</div>
<script>
    function enableEditing() {
        document.querySelector('.profile-details').classList.add('hidden');
        document.querySelector('#editForm').classList.remove('hidden');
    }

    function cancelEditing() {
        document.querySelector('.profile-details').classList.remove('hidden');
        document.querySelector('#editForm').classList.add('hidden');
    }

    function saveChanges() {
        const nameInput = document.getElementById('nameInput').value.trim();
        const emailInput = document.getElementById('emailInput').value.trim();
        const phoneInput = document.getElementById('phoneInput').value.trim();

        if (!nameInput || !emailInput || !phoneInput) {
            alert('Please fill out all fields.');
            return;
        }

        if (!/\S+@\S+\.\S+/.test(emailInput)) {
            alert('Please enter a valid email address.');
            return;
        }

        document.getElementById('fullName').textContent = nameInput;
        document.getElementById('email').textContent = emailInput;
        document.getElementById('phone').textContent = phoneInput;
        cancelEditing();
    }

    function previewPhoto() {
        const input = document.getElementById('photoInput');
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profilePic').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
</body>
</html>
