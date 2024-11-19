<?php
require_once('../../controller/add.php');           // Path to add.php in controller
require_once('../../Model/Enseignant.php');         // Path to Enseignant.php in Model
require_once('../../Model/etudient.php');           // Path to etudient.php in Model
require_once('../../Model/utilisateur.php');        // Path to utilisateur.php in Model
require_once('../../configdb.php');                 // Path to configdb.php

include_once 'debug.php'; // Include debugging utility

$response = ['success' => false, 'message' => 'Unknown error'];

try {
    Debugger::log("Processing request.", $_POST); // Log POST data

    // Retrieve and sanitize input
    $firstName = trim($_POST['firstName']);
    $secondName = trim($_POST['secondName']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $niveau = isset($_POST['niveau']) ? trim($_POST['niveau']) : null;
    $password = $_POST['password'];
    $matier = isset($_POST['matier']) ? trim($_POST['matier']) : null;

    // Validate required inputs
    if (empty($firstName) || empty($secondName) || empty($email) || empty($role) || empty($password)) {
        throw new Exception("Missing required fields.");
    }

    Debugger::log("Inputs validated successfully.");

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email address.");
    }

    // Validate and hash password
    if (strlen($password) < 8) {
        throw new Exception("Password must be at least 8 characters long.");
    }
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Combine first and last names
    $nom = $firstName . ' ' . $secondName;

    // Process file uploads (if applicable)
    if ($role == 'etudient') {
        Debugger::log("Processing student-specific fields.");
        if (!isset($_FILES['student_image'])) {
            throw new Exception("Student image is required.");
        }
        $img = $_FILES['student_image'];
        if (!file_exists($img['tmp_name']) || !getimagesize($img['tmp_name'])) {
            throw new Exception("Invalid student image.");
        }
        $imgData = file_get_contents($img['tmp_name']);
    } elseif ($role == 'enseignant') {
        Debugger::log("Processing teacher-specific fields.");
        if (!isset($_FILES['cv'])) {
            throw new Exception("CV is required.");
        }
        $cvType = mime_content_type($_FILES['cv']['tmp_name']);
        if ($cvType !== 'application/pdf') {
            throw new Exception("CV must be a PDF file.");
        }
        $pdfData = file_get_contents($_FILES['cv']['tmp_name']);
    }
    $controller = new usercontroller();

    if ($role == 'etudient') {
        $etudiant = new Etudiant($nom, $email, $hashedPassword, $role, 'active', $niveau, $imgData);
        $result = $controller->add($etudiant);
        Debugger::log("Etudiant add result:", $result);
        if ($result !== false) {
            $response['success'] = true;
            $response['message'] = 'Etudiant added successfully!';
        } else {
            throw new Exception("Failed to add Etudiant.");
        }
    } elseif ($role == 'enseignant') {
        $enseignant = new Enseignant($nom, $email, $hashedPassword, $role, 'active', $matier, $pdfData);
        $result = $controller->add($enseignant);
        Debugger::log("Enseignant add result:", $result);
        if ($result !== false) {
            $response['success'] = true;
            $response['message'] = 'Enseignant added successfully!';
        } else {
            throw new Exception("Failed to add Enseignant.");
        }
    } else {
        throw new Exception("Invalid role specified.");
    }
} catch (Exception $e) {
    Debugger::log("Error encountered:", $e->getMessage());
    $response['message'] = $e->getMessage();
}
Debugger::log("Final response sent:", $response);
echo $response['message'];
?>
