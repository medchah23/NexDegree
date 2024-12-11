<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHandler
{
    public static function sendEmail($to, $subject, $body, $imagePath)
    {
        // First, process face recognition
        $faceRecognitionResult = self::performFaceRecognition($imagePath);

        // Append the face recognition result to the email body
        $body .= "<br><br><strong>Face Recognition Result:</strong><br>";
        if (isset($faceRecognitionResult['error'])) {
            $body .= "Error: " . $faceRecognitionResult['error'];
        } else {
            $body .= "Gender: " . $faceRecognitionResult['gender'] . "<br>";
            $body .= "Age: " . $faceRecognitionResult['age'] . "<br>";
            $body .= "Race: " . $faceRecognitionResult['dominant_race'] . "<br>";
            $body .= "Emotion: " . $faceRecognitionResult['dominant_emotion'] . "<br>";
        }

        // Now, send the email
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
    public static function performFaceRecognition($imagePath)
    {
        $command = "python3 face_recognition.py " . escapeshellarg($imagePath);
        $output = shell_exec($command);
        $result = json_decode($output, true);

        return $result;
    }
}
?>
