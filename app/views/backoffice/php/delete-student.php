<?php
require_once("../../../controller/add.php");

// Check if ID is provided and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Initialize the controller to manage user operations
    $userController = new UserController();

    // Try deleting the user by calling the delete method
    if ($userController->delete($id)) {
        // If deletion is successful, redirect to the teacher's page
        header("Location: students.php");
        exit();  // Stop further script execution after the redirect
    } else {
        // If there was an error, show a message
        echo "Error deleting the user.";
    }
} else {
    echo "Invalid or missing ID.";
}
?>
