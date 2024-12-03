<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../../../controller/add.php");
    require_once("../../../Model/Etudient.php");
    require_once("../../../Model/Enseignant.php");
    require_once 'debug.php';

    ini_set('log_errors', 1);
    ini_set('error_log', 'debug.log'); // Set appropriate log path
    error_reporting(E_ALL);

    $response = ['success' => false, 'message' => 'An unknown error occurred'];

    try {
        Debugger::log("Processing request.", $_POST);

        // Input sanitization
        $firstName = htmlspecialchars(trim($_POST['firstName'] ?? ''));
        $secondName = htmlspecialchars(trim($_POST['secondName'] ?? ''));
        $phoneNumber = htmlspecialchars(trim($_POST['phoneNumber'] ?? ''));
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $role = trim($_POST['role'] ?? '');
        $password = $_POST['password'] ?? '';
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $nom = $firstName . ' ' . $secondName;

        // Validate role
        if (!in_array($role, ['etudiant', 'enseignant'])) {
            throw new Exception("Invalid role provided.");
        }

        // File upload directories
        $uploadDir = __DIR__ . '/../../../uploads/';
        $imageDir = $uploadDir . 'images/';
        $cvDir = $uploadDir . 'cvs/';
        if (!is_dir($imageDir)) mkdir($imageDir, 0755, true);
        if (!is_dir($cvDir)) mkdir($cvDir, 0755, true);

        // Initialize variables
        $imagePath = null;
        $cvPath = null;
        $niveau = $_POST['niveau'] ?? '';
        $matier = $_POST['matier'] ?? '';

        // Handle student image upload
        if ($role === 'etudiant' && isset($_FILES['student_image']) && $_FILES['student_image']['error'] === UPLOAD_ERR_OK) {
            $allowedFormats = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($_FILES['student_image']['tmp_name']);
            if (in_array($fileType, $allowedFormats)) {
                $imageName = uniqid('student_') . '.' . pathinfo($_FILES['student_image']['name'], PATHINFO_EXTENSION);
                $imagePath = $imageDir . $imageName;

                if (!move_uploaded_file($_FILES['student_image']['tmp_name'], $imagePath)) {
                    throw new Exception("Failed to upload student image.");
                }
                $imagePath = 'uploads/images/' . $imageName; // Relative path for database
            } else {
                throw new Exception("Invalid image format for student.");
            }
        } else {
            Debugger::log("Student image upload failed or not provided.", $_FILES['student_image']);
        }

        // Handle teacher CV and image upload
        if ($role === 'enseignant') {
            // Upload CV
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $allowedFormats = ['application/pdf'];
                $fileType = mime_content_type($_FILES['cv']['tmp_name']);
                if (in_array($fileType, $allowedFormats)) {
                    $cvName = uniqid('cv_') . '.' . pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
                    $cvPath = $cvDir . $cvName;

                    if (!move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath)) {
                        throw new Exception("Failed to upload teacher CV.");
                    }
                    $cvPath = 'uploads/cvs/' . $cvName; // Relative path for database
                } else {
                    throw new Exception("Invalid CV format. Only PDF allowed.");
                }
            } else {
                Debugger::log("Teacher CV upload failed or not provided.", $_FILES['cv']);
            }

            // Upload image
            if (isset($_FILES['ens_image']) && $_FILES['ens_image']['error'] === UPLOAD_ERR_OK) {
                $allowedFormats = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($_FILES['ens_image']['tmp_name']);
                if (in_array($fileType, $allowedFormats)) {
                    $imageName = uniqid('teacher_') . '.' . pathinfo($_FILES['ens_image']['name'], PATHINFO_EXTENSION);
                    $imagePath = $imageDir . $imageName;

                    if (!move_uploaded_file($_FILES['ens_image']['tmp_name'], $imagePath)) {
                        throw new Exception("Failed to upload teacher image.");
                    }
                    $imagePath = 'uploads/images/' . $imageName;
                } else {
                    throw new Exception("Invalid image format for teacher.");
                }
            } else {
                Debugger::log("Teacher image upload failed or not provided.", $_FILES['ens_image']);
            }
        }
        Debugger::log("Image Path for User: ", $imagePath);
        $controller = new UserController();
        if ($role === 'etudiant') {
            $etudiant = new Etudiant($nom, $email, $phoneNumber, $hashedPassword, "etudiant", 'active', $niveau, $imagePath);
            $result = $controller->add($etudiant);
        } elseif ($role === 'enseignant') {
            $enseignant = new Enseignant($nom, $email, $phoneNumber, $hashedPassword, "enseignant", 'inactive', $matier, $cvPath, $imagePath);
            $result = $controller->add($enseignant);
        }

        if (!empty($result['success']) && $result['success']) {
            $response['success'] = true;
            $response['message'] = $result['message'];
            $response['data'] = $result['data'] ?? null;
        } else {
            throw new Exception($result['message'] ?? "Failed to add user.");
        }
        http_response_code(200);
    } catch (Exception $e) {
        error_log("Error encountered: " . $e->getMessage());
        $response['message'] = $e->getMessage();
        http_response_code(400);
    } finally {
        header('Content-Type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}