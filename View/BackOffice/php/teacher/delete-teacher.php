<?php
require_once("../../../../controller/TeacherController.php");
require_once("../../../../config.php");
require_once("../debug.php");
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $userController = new teacherController();
    if ($userController->deleteTeacher($id)) {
        header("Location: teachers.php");
        exit();
    } else {
        echo "Error deleting the user.";
    }
} else {
    echo "Invalid or missing ID.";
}
?>