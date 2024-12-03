<?php
require_once("../../../controller/add.php");
require_once("../../../Model/session.php");

// Ensure this script is executed as a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

// Get email and password from POST request
$email = $_POST["email"] ?? null;
$password = $_POST["password"] ?? null;

// Validate inputs
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit();
}

try {
    $connexion = new UserController();
    $session = new Session();
    $role = $connexion->connexion($email, $password);
    $response = [];

    if ($role === "admin" || $role === "enseignant" || $role === "etudiant") {
        $userId = $connexion->getUserIdByEmail($email);
        if ($userId==-1) {
            echo json_encode(['success' => false, 'message' => 'User ID not found.']);
            exit();
        }

        $sessionToken = $session->create_session($userId);

        if ($sessionToken) {
            session_start();
            $_SESSION['user_role'] = $role;
            $_SESSION['user_token'] = $sessionToken;
            $response['success'] = true;
            $response['message'] = 'Login successful';
            $response['role'] = $role;
            $response['redirect_url'] = ($role === "admin")
                ? '/admin_dashboard.php'
                : (($role === "enseignant") ? '/teacher_dashboard.php' : '/student_dashboard.php');
        } else {
            $response['success'] = false;
            $response['message'] = 'Error creating session.';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid email or password.';
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    $response = ['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()];
}
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
