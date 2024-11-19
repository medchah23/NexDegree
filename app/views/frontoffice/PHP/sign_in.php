<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../../../controller/add.php");
    require_once("../../../Model/etudient.php");
    require_once("../../../Model/Enseignant.php");
    require_once 'debug.php';

    $response = ['success' => false, 'message' => 'An unknown error occurred'];

    try {
        Debugger::log("Processing request.", $_POST);

        // Trim and sanitize inputs
        $firstName = filter_var(trim($_POST['firstName'] ?? ''), FILTER_SANITIZE_STRING);
        $secondName = filter_var(trim($_POST['secondName'] ?? ''), FILTER_SANITIZE_STRING);
        $phoneNumber = filter_var(trim($_POST['phoneNumber'] ?? ''), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $role = filter_var(trim($_POST['role'] ?? ''), FILTER_SANITIZE_STRING);
        $password = $_POST['password'] ?? '';

        // Validate required fields
        if (!$firstName || !$secondName || !$phoneNumber || !$email || !$role || !$password) {
            throw new Exception("All fields are required.");
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $nom = $firstName . ' ' . $secondName;

        // Role-specific validations
        $imgData = null;
        $pdfData = null;
        $niveau = null;
        $matier = null;

        if ($role === 'etudient') {
            $niveau = filter_var(trim($_POST['niveau'] ?? ''), FILTER_SANITIZE_STRING);
            if (!$niveau) throw new Exception("Niveau is required for students.");

            // Handle image upload for students
            if (isset($_FILES['student_image']) && $_FILES['student_image']['error'] === UPLOAD_ERR_OK) {
                $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['student_image']['type'], $allowedImageTypes)) {
                    $imgData = base64_encode(file_get_contents($_FILES['student_image']['tmp_name']));
                } else {
                    throw new Exception("Invalid file type for student image. Allowed: JPEG, PNG, GIF.");
                }
            }
        } elseif ($role === 'prof') {
            $matier = filter_var(trim($_POST['matier'] ?? ''), FILTER_SANITIZE_STRING);
            if (!$matier) throw new Exception("Matier is required for professors.");

            // Handle CV upload for professors
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $allowedCvTypes = ['application/pdf'];
                if (in_array($_FILES['cv']['type'], $allowedCvTypes)) {
                    $pdfData = base64_encode(file_get_contents($_FILES['cv']['tmp_name']));
                } else {
                    throw new Exception("Invalid file type for CV. Allowed: PDF.");
                }
            }
        } else {
            throw new Exception("Invalid role specified.");
        }

        // Create user object and add to the database
        $controller = new usercontroller();
        $result = false;

        if ($role === 'etudient') {
            $etudiant = new Etudiant($nom, $email, $phoneNumber, $hashedPassword, $role, 'active', $niveau, $imgData);
            Debugger::log("Attempting to add Etudiant.");
            $result = $controller->add($etudiant);
        } elseif ($role === 'prof') {
            $enseignant = new Enseignant($nom, $email, $phoneNumber, $hashedPassword, $role, 'active', $matier, $pdfData);
            Debugger::log("Attempting to add Enseignant.");
            $result = $controller->add($enseignant);
        }

        // Handle result
        if ($result['success']) {
            Debugger::log("Add operation successful.", $result['message']);
            $response['success'] = true;
            $response['message'] = $result['message'];
            $response['data'] = $result['data'] ?? null;
        } else {
            throw new Exception($result['message'] ?? "Failed to add " . ($role === 'etudient' ? 'student' : 'teacher') . ".");
        }
    } catch (Exception $e) {
        Debugger::log("Error encountered:", $e->getMessage());
        $response['message'] = $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
?>
