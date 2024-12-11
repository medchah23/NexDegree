<?php
require_once("../../../controller/UserController.php");
require_once("../../../Model/session.php");
require_once("debug.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "message" => "Method not allowed."]);
    exit();
}

$email = filter_var($_POST['loginEmail'] ?? null, FILTER_SANITIZE_EMAIL);
$password = $_POST['loginPassword'] ?? null;
Debugger::log("Login attempt", ["email" => $email]);

try {
    $connexion = new UserController();
    $session = new Session();
    $role = $connexion->connexion($email, $password);
    Debugger::log("User  role retrieved", ["role" => $role]);

    if (in_array($role, ["admin", "enseignant", "etudiant"])) {
        Debugger::log("Fetching user ID for email", ["email" => $email]);
        $userId = $connexion->getUserIdByEmail($email);
        Debugger::log("User  ID retrieved", ["userId" => $userId]);

        if ($userId === -1) {
            Debugger::log("User  ID not found", ["email" => $email]);
            echo json_encode(["success" => false, "message" => "User  ID not found."]);
            exit();
        }

        // Check user status
        $userStatus = $connexion->getUserStatusById($userId);
        Debugger::log("User  status retrieved", ["status" => $userStatus]);

        if ($userStatus !== 'active') {
            echo json_encode([
                "success" => false,
                "message" => "User  account is " . htmlspecialchars($userStatus) . "."
            ]);
            exit();
        }
        $sessionToken = $session->create_session($userId);
        Debugger::log("Session token creation", ["sessionToken" => $sessionToken]);

        if ($sessionToken) {
            // Start session and set session variables
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['user_role'] = $role;
            $_SESSION['user_token'] = $sessionToken;
            $_SESSION['user_id'] = $userId;

            // Return a success response with redirect URL
            $redirectUrls = [
                "admin" => "/admin_dashboard.php",
                "enseignant" => "/teacher_dashboard.php",
                "etudiant" => "../index.php"
            ];
            echo json_encode([
                "success" => true,
                "message" => "Login successful.",
                "redirect_url" => $redirectUrls[$role]
            ]);
            exit();
        } else {
            Debugger::log("Session creation failed", ["userId" => $userId]);
            echo json_encode(["success" => false, "message" => "Failed to create session."]);
            exit();
        }
    } else {
        Debugger::log("Invalid email/password", ["email" => $email]);
        echo json_encode(["success" => false, "message" => "Invalid email or password."]);
        exit();
    }
} catch (Exception $e) {
    error_log("Error encountered: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => htmlspecialchars($e->getMessage())]);
    http_response_code(400);
    exit();
}
?>