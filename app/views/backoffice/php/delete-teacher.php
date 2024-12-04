<?php
require_once("../../../controller/add.php");
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $userController = new UserController();
    if ($userController->deletee($id)) {
        header("Location: teachers.php");
        exit();
    } else {
        echo "Error deleting the user.";
    }
} else {
    echo "Invalid or missing ID.";
}
?>