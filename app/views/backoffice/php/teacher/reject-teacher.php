<?php
require_once("../../../../controller/TeacherController.php");
require_once("../../../../controller/EmailHandler.php");
require_once("../../../../../vendor/autoload.php");
require_once("../../../../configdb.php");
require_once("../debug.php"); // Assuming this includes the Debugger class

$id = $_GET["id"];
$controller = new teacherController();

try {
    $result = $controller->updateTeacherStatus($id, "rejected");
    $result2 = $controller->getTeacherById($id);
    if ($result['success']) {
        $teacherDetails = $result['data'];
        $email = $result2['email'];
        $name = $result2['nom'];

        // Prepare the email subject and body
        $subject = "Application Rejected - NexDegree";

        $body = "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                }
                .container {
                    width: 80%;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #f9f9f9;
                    border-radius: 8px;
                    border: 1px solid #ddd;
                }
                h2 {
                    color: #2C3E50;
                }
                p {
                    font-size: 16px;
                    color: #555;
                }
                .footer {
                    margin-top: 30px;
                    font-size: 14px;
                    color: #777;
                }
                .footer a {
                    color: #3498db;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Dear {$name},</h2>
                <p>Thank you for your interest in the position of [Position Title]. After careful consideration, we regret to inform you that we have decided not to proceed with your application at this time.</p>
                <p>This decision was not easy to make, as we received a large number of applications from highly qualified candidates. Unfortunately, we are unable to offer you the position on this occasion.</p>
                <p>We genuinely appreciate the time and effort you invested in the application process. Please don’t hesitate to apply again for future opportunities that may align with your skills and experience.</p>
                <p>We wish you the best of luck with your job search and future endeavors.</p>

                <p class='footer'>
                    Kind regards,<br>
                    mohamed chahbani<br>
                    Human ressourses<br>
                    NexdDegree<br>
                </p>
            </div>
        </body>
        </html>
        ";

        // Send email
        $emailResult = EmailHandler::sendEmail($email, $subject, $body);

        // Debug email status
        if ($emailResult['success']) {
            Debugger::log("Email sent successfully to {$email}. Subject: {$subject}");
            echo "Teacher rejected, and email notification sent successfully.";
        } else {
            Debugger::log("Email sending failed to {$email}. Error: " . $emailResult['message'], "ERROR");
            echo "Teacher rejected, but email could not be sent: " . htmlspecialchars($emailResult['message']);
        }

        $controller->deleteTeacher($id);
        header("Location: teachers.php");
        exit;
    } else {
        Debugger::log("Error rejecting teacher with ID {$id}: " . $result['message'], "ERROR");
        echo "Error rejecting teacher: " . htmlspecialchars($result['message']);
    }
} catch (Exception $e) {
    // Catch and log any unexpected exceptions
    Debugger::log("Exception in accept.php: " . $e->getMessage(), "EXCEPTION");
    error_log("Error in accept.php: " . $e->getMessage());
    echo "An error occurred: " . htmlspecialchars($e->getMessage());
}
?>
