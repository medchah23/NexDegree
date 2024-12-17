<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHandler
{
    public static function sendEmail($to, $subject, $body)
    {

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'medchah605@gmail.com';
            $mail->Password = 'yuuy rlem xfsy cwfj';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('noreply@nexdegree.com', 'NexDegree');
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->send();
            return ["success" => true, "message" => "Email sent successfully."];
        } catch (Exception $e) {
            return ["success" => false, "message" => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"];
        }
    }
}
?>
