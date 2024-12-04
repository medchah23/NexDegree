<?php
include_once "../../../controller/add.php";
require_once "../../../controller/EmailHandler.php";

$id = $_GET["id"];
$controller = new UserController();

try {

    $result = $controller->reject($id);

    if ($result['success']) {
        // Prepare email details
        $teacherDetails = $result['data'];
        $email = $teacherDetails['email'];
        $name = $teacherDetails['nom'];

        $subject = "Application Rejected";
        $body = "<p>Dear {$name},</p>
                 <p>We regret to inform you that your application to become a teacher has been rejected.</p>
                 <p>Thank you for your interest in NexDegree.</p>
                 <p>Best regards,<br>NexDegree Team</p>";

        // Send the email
        $emailResult = EmailHandler::sendEmail($email, $subject, $body);

        if ($emailResult['success']) {
            echo "Teacher rejected, and email notification sent successfully.";
            header("Location: teachers.php");
        } else {
            echo "Teacher rejected, but email could not be sent: " . htmlspecialchars($emailResult['message']);
            header("Location: teachers.php");
        }
    } else {
        echo "Error rejecting teacher: " . htmlspecialchars($result['message']);
    }
} catch (Exception $e) {
    error_log("Error in reject.php: " . $e->getMessage());
    echo "An error occurred: " . htmlspecialchars($e->getMessage());
}
?>
