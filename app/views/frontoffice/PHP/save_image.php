<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageData = $_POST['image'];
    $imageData = base64_decode($imageData);
    $filePath = 'uploads/captured_image_' . time() . '.png'; // Change the path as needed
    if (file_put_contents($filePath, $imageData)) {
        echo json_encode(['success' => true, 'message' => 'Image saved successfully.']);
    } else {
        // Return an error response
        echo json_encode(['success' => false, 'message' => 'Failed to save image.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>