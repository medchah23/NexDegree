<?php
require_once("../../../../controller/TeacherController.php");
require_once("../../../../Model/Enseignant.php");
require_once("../../../../configdb.php");
require_once("../debug.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $numero_telephone = filter_input(INPUT_POST, 'numero_telephone', FILTER_SANITIZE_STRING);
    $mot_de_passe = filter_input(INPUT_POST, 'mot_de_passe', FILTER_SANITIZE_STRING);
    $qualifications = filter_input(INPUT_POST, 'qualifications', FILTER_SANITIZE_STRING);
    $profilePic = $_FILES['profile_pic'] ?? null;
    Debugger::dump($id, 'Teacher ID');
    Debugger::dump($nom, 'Name');
    Debugger::dump($numero_telephone, 'Phone Number');
    Debugger::dump($mot_de_passe, 'Password');
    Debugger::dump($qualifications, 'Qualifications');
    Debugger::dump($profilePic, 'Profile Picture');
    $profilePicPath = null;
    if ($profilePic && $profilePic['error'] == 0) {
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($profilePic['tmp_name']);
        if (in_array($fileType, $allowedMimeTypes)) {
            $uploadDir = "../../../../uploads/images/";
            $uniqueFileName = md5(uniqid(rand(), true)) . '.' . pathinfo($profilePic['name'], PATHINFO_EXTENSION);
            $profilePicPath = $uploadDir . $uniqueFileName;
            if (move_uploaded_file($profilePic['tmp_name'], $profilePicPath)) {
                Debugger::log("File uploaded to: {$profilePicPath}");
            } else {
                throw new Exception("Failed to upload the profile picture.");
            }
        } else {
            throw new Exception("Invalid file type. Please upload a valid image.");
        }
    }


    try {
        $teacherController = new TeacherController();
        $hashedPassword = !empty($mot_de_passe) ? password_hash($mot_de_passe, PASSWORD_DEFAULT) : null;
        Debugger::dump($hashedPassword, 'Hashed Password');
        $updated = $teacherController->updateTeacher($id, $nom, $numero_telephone, $hashedPassword, $qualifications, $profilePicPath);
        Debugger::log("Update response: " . ($updated ? 'Success' : 'Failure'));
        if ($updated) {
            header("Location: teachers.php?success=1");
            exit;
        } else {
            throw new Exception("Failed to update teacher. Please try again.");
        }
    } catch (Exception $e) {
        // Debugging: Output the error message
        Debugger::log("Error: " . $e->getMessage());
        $error = $e->getMessage();
    }
}
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    Debugger::log("Invalid teacher ID.");
    die("Invalid teacher ID.");
}

$teacherController = new TeacherController();
$teacher = $teacherController->getTeacherById($id);
if (!$teacher) {
    Debugger::log("Teacher not found.");
    die("Teacher not found.");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="form-container">
        <h2>Modify Teacher</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" id="modifyTeacherForm">
            <div class="mb-3">
                <label for="nom" class="form-label">Name</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($teacher['nom'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($teacher['email'] ?? '') ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="numero_telephone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="numero_telephone" name="numero_telephone" value="<?= htmlspecialchars($teacher['numero_telephone'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Password</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
            </div>

            <div class="mb-3">
                <label for="qualifications" class="form-label">Qualifications</label>
                <textarea class="form-control" id="qualifications" name="qualifications"><?= htmlspecialchars($teacher['qualifications'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="profile_pic" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*">
                <?php if (!empty($teacher['profile_pic'])): ?>
                    <div class="mt-2">
                        <img src="<?= htmlspecialchars($teacher['profile_pic']) ?>" alt="Profile Picture" width="100">
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Teacher</button>
        </form>

    </div>
</div>

<script>
    // Real-time validation
    const form = document.getElementById('modifyTeacherForm');
    const nameInput = document.getElementById('nom');
    const phoneInput = document.getElementById('numero_telephone');
    const passwordInput = document.getElementById('mot_de_passe');

    form.addEventListener('submit', function (e) {
        let isValid = true;

        // Name validation
        if (nameInput.value.trim().length < 2) {
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else {
            nameInput.classList.remove('is-invalid');
        }

        // Phone number validation
        const phoneRegex = /^[0-9]{8}$/;
        if (!phoneRegex.test(phoneInput.value)) {
            phoneInput.classList.add('is-invalid');
            isValid = false;
        } else {
            phoneInput.classList.remove('is-invalid');
        }

        // Password validation
        if (passwordInput.value && passwordInput.value.length < 6) {
            passwordInput.classList.add('is-invalid');
            isValid = false;
        } else {
            passwordInput.classList.remove('is-invalid');
        }

        // Prevent form submission if not valid
        if (!isValid) e.preventDefault();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
