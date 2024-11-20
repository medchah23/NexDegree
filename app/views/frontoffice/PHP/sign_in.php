<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("../../../controller/add.php");
    require_once("../../../Model/etudient.php");
    require_once("../../../Model/Enseignant.php");
    require_once 'debug.php';

    ini_set('log_errors', 1);
    ini_set('error_log', 'debug.log'); // Set appropriate log path
    error_reporting(E_ALL);

    $response = ['success' => false, 'message' => 'An unknown error occurred'];

    try {
        ob_start(); // Start output buffering

        Debugger::log("Processing request.", $_POST);

        // Input sanitization without validation
        $firstName = filter_var(trim($_POST['firstName'] ?? ''), FILTER_SANITIZE_STRING);
        $secondName = filter_var(trim($_POST['secondName'] ?? ''), FILTER_SANITIZE_STRING);
        $phoneNumber = trim($_POST['phoneNumber'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $password = $_POST['password'] ?? '';

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $nom = $firstName . ' ' . $secondName;

        // Role-specific processing without validation
        $imgData = null;
        $pdfData = null;
        $niveau = $_POST['niveau'] ?? '';
        $matier = $_POST['matier'] ?? '';

        if ($role === 'etudiant') {
            if (isset($_FILES['student_image']) && $_FILES['student_image']['error'] === UPLOAD_ERR_OK) {
                $imgData = base64_encode(file_get_contents($_FILES['student_image']['tmp_name']));
            }
        } elseif ($role === 'enseignant') {
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $pdfData = base64_encode(file_get_contents($_FILES['cv']['tmp_name']));
            }
        }

        // Database operation
        $controller = new usercontroller();
        if ($role === 'etudiant') {
            $etudiant = new Etudiant($nom, $email, $phoneNumber, $hashedPassword, "etudiant", 'active', $niveau, $imgData);
            $result = $controller->add($etudiant);
        } elseif ($role === 'enseignant') {
            $enseignant = new Enseignant($nom, $email, $phoneNumber, $hashedPassword, "enseignant", 'active', $matier, $pdfData);
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
        http_response_code(400); // Send an error status
    } finally {
        ob_end_clean(); // Clean the output buffer
        header('Content-Type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}