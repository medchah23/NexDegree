<?php
require_once("../../../controller/add.php");
require_once("../../../Model/session.php");
require_once("debug.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo "Error: Method not allowed.";
    exit();
}

$email = $_POST['loginEmail'] ?? null;
$password = $_POST['loginPassword'] ?? null;

if (!$email || !$password) {
    echo "Error: Missing email or password.";
    exit();
}
Debugger::log("Login attempt", ["email" => $email]);

try {
    $connexion = new UserController();
    $session = new Session();
    $role = $connexion->connexion($email, $password);
    Debugger::log("User role retrieved", ["role" => $role]);
    if ($role === "admin" || $role === "enseignant" || $role === "etudiant") {
        Debugger::log("Fetching user ID for email", ["email" => $email]);
        $userId = $connexion->getUserIdByEmail($email);
        Debugger::log("User ID retrieved", ["userId" => $userId]);
        if ($userId == -1) {
            Debugger::log("User ID not found", ["email" => $email]);
            echo "Error: User ID not found.";
            exit();
        }
        $userStatus = $connexion->getUserStatusById($userId);
        Debugger::log("User status retrieved", ["status" => $userStatus]);

        if ($userStatus !== 'active') {

            if ($userStatus === 'locked') {
                header("Location: status_error.html?status=locked");
            } elseif ($userStatus === 'banned') {
                header("Location: status_error.html?status=banned");
            } elseif ($userStatus === 'inactive') {
                header("Location: status_error.html?status=inactive");
            }
            exit();
        }
        else{
        $sessionToken = $session->create_session($userId);
        echo $sessionToken."<br>";
        Debugger::log("Session token creation", ["sessionToken" => $sessionToken]);

        if ($sessionToken) {
            session_start();
            $_SESSION['user_role'] = $role;
            $_SESSION['user_token'] = $sessionToken;
            $_SESSION['user_id'] = $userId;
            if ($role === "admin") {
                header('Location: /admin_dashboard.php');
            } elseif ($role === "enseignant") {
                header('Location: /teacher_dashboard.php');
            } else {
                header('Location: ../index.php');
            }
        } else {
            Debugger::log("Session creation failed", ["userId" => $userId]);
            echo "Error: $sessionToken";
            exit();
        }}
    } else {
        Debugger::log("Invalid email/password", ["email" => $email]);
        echo "Error: $role";
        exit();
    }
} catch (Exception $e) {
    error_log("Error encountered: " . $e->getMessage());
    echo "Error: " . htmlspecialchars($e->getMessage());
    http_response_code(400);
    exit();
} finally {

}
?>
