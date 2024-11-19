<?php
header('Content-Type: application/json');

$response = [
    'success' => true,
    'message' => 'Fetch request successful!'
];

echo json_encode($response);
?>
