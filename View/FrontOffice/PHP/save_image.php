<?php

require_once "../../../Model/face.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        if (!isset($_POST['image']) || empty($_POST['image'])) {
            throw new Exception('No image data provided.');
        }
        $face = new Face();
        $imageData = $_POST['image'];
        $imageData = base64_decode($imageData);
        if ($imageData === false) {
            throw new Exception('Failed to decode image data.');
        }
        $uploadDir = 'uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filePath = $uploadDir . '/captured_image_' . time() . '.png';
        if (file_put_contents($filePath, $imageData)) {
            $face->insertFaceId( $filePath);

            echo json_encode(['success' => true, 'message' => 'Image saved successfully.', 'path' => $filePath]);
        } else {
            throw new Exception('Failed to save image.');
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
