<?php
include_once "../../../controller/add.php";
require_once "../../../controller/EmailHandler.php";

$id = $_GET["id"];
$controller = new UserController();

try {

    $result = $controller->accept($id);

    if ($result['success']) {

        $teacherDetails = $result['data'];
        $email = $teacherDetails['email'];
        $name = $teacherDetails['nom'];

        $subject = "Application Accepted";
        $body = "<p>Dear {$name},</p>
                 <p>Congratulations! Your application to become a teacher at NexDegree has been accepted.</p>
                 <p>You can now log in and start exploring your dashboard.</p>
                 <p>Best regards,<br>NexDegree Team</p>";
        $emailResult = EmailHandler::sendEmail($email, $subject, $body);

        if ($emailResult['success']) {
            echo "Teacher accepted, and email notification sent successfully.";
            header("Location: teachers.php");
        } else {
            echo "Teacher accepted, but email could not be sent: " . htmlspecialchars($emailResult['message']);
            header("Location: teachers.php");
        }
    } else {
        echo "Error accepting teacher: " . htmlspecialchars($result['message']);
    }
} catch (Exception $e) {
    error_log("Error in accept.php: " . $e->getMessage());
    echo "An error occurred: " . htmlspecialchars($e->getMessage());
}
?>
