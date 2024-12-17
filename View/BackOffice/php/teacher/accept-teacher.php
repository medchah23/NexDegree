<?php
require_once("../../../../controller/TeacherController.php");
require_once("../../../../controller/EmailHandler.php");
require_once("../../../../vendor/autoload.php");
require_once("../../../../config.php");
require_once("../debug.php"); // Assuming this includes the Debugger class

$id = $_GET["id"];
$controller = new teacherController();

try {
    $result = $controller->updateTeacherStatus($id, "active");
    $result2 = $controller->getTeacherById($id );
    if ($result['success']) {
        $teacherDetails = $result['data'];
        $email = $result2['email'];
        $name = $result2['nom'];

        // Prepare email content
        // Prepare email content
        $subject = "🎉 Welcome to NexDegree: Your Application is Accepted!";
        $body = "<div style='font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
            <h1 style='color: #4CAF50; text-align: center;'>Welcome to NexDegree!</h1>
            <p style='font-size: 16px; line-height: 1.6;'>Dear <strong>{$name}</strong>,</p>
            <p style='font-size: 16px; line-height: 1.6;'>🎉 Congratulations! We are thrilled to inform you that your application to join the NexDegree family as a teacher has been <strong>accepted</strong>.</p>
            <p style='font-size: 16px; line-height: 1.6;'>Your expertise and passion for education will make a tremendous impact on our students. We can’t wait for you to explore your personalized dashboard and start creating meaningful learning experiences.</p>
            <p style='font-size: 16px; line-height: 1.6; color: #555;'>Here’s to a journey of inspiring minds and making a difference together!</p>
            <p style='font-size: 16px; line-height: 1.6;'>If you have any questions or need assistance, feel free to reach out to us at any time.</p>
            <p style='font-size: 16px; line-height: 1.6; text-align: center;'><strong>Welcome aboard!</strong></p>
            <hr style='border: 0; height: 1px; background: #ddd; margin: 20px 0;'>
            <p style='font-size: 14px; line-height: 1.6; text-align: center; color: #888;'>Best regards,<br><strong>The NexDegree Team</strong></p>
        </div>";


        // Send email
        $emailResult = EmailHandler::sendEmail($email, $subject, $body);

        // Debug email status
        if ($emailResult['success']) {
            Debugger::log("Email sent successfully to {$email}. Subject: {$subject}");
            echo "Teacher accepted, and email notification sent successfully.";
        } else {
            Debugger::log("Email sending failed to {$email}. Error: " . $emailResult['message'], "ERROR");
            echo "Teacher accepted, but email could not be sent: " . htmlspecialchars($emailResult['message']);
        }

        // Redirect to teachers page
        header("Location: teachers.php");
        exit;
    } else {
        // Log and display error if teacher update fails
        Debugger::log("Error accepting teacher with ID {$id}: " . $result['message'], "ERROR");
        echo "Error accepting teacher: " . htmlspecialchars($result['message']);
    }
} catch (Exception $e) {
    // Catch and log any unexpected exceptions
    Debugger::log("Exception in accept.php: " . $e->getMessage(), "EXCEPTION");
    error_log("Error in accept.php: " . $e->getMessage());
    echo "An error occurred: " . htmlspecialchars($e->getMessage());
}
