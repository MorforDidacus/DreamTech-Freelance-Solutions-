<?php
// Set header to allow CORS and accept JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

// Get raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!empty($data['name']) && !empty($data['phone'])) {
    $name = htmlspecialchars($data['name']);
    $phone = htmlspecialchars($data['phone']);

    // Path to save file
    $file = 'users.json';

    // Load existing data
    $existing = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    // Append new user
    $existing[] = ['name' => $name, 'phone' => $phone, 'timestamp' => date('Y-m-d H:i:s')];

    // Save back to file
    if (file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT))) {
        echo json_encode(['status' => 'success', 'message' => 'User saved']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>