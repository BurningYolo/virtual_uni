<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

// Generate a random 10-character access key with digits and uppercase letters
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$access_key = '';
for ($i = 0; $i < 10; $i++) {
    $access_key .= $characters[random_int(0, strlen($characters) - 1)];
}

// Get data from POST request
$created_by = isset($_POST['created_by']) ? $_POST['created_by'] : null;
$for_role = isset($_POST['for_role']) ? $_POST['for_role'] : null;
$used = isset($_POST['used']) ? $_POST['used'] : 0; // Default to 0 if not provided





// Ensure that required fields are provided
if ($created_by && $for_role) {
    $query = "INSERT INTO tbl_access_keys (access_key, created_by, for_role, used, created_at) 
              VALUES (:access_key, :created_by, :for_role, :used, NOW())";
    $stmt = $pdo->prepare($query);

    $params = [
        'access_key' => $access_key,
        'created_by' => $created_by,
        'for_role' => $for_role,
        'used' => $used
    ];

    if ($stmt->execute($params)) {
        echo json_encode(['message' => 'Access key created successfully', 'access_key' => $access_key]);
    } else {
        echo json_encode(['message' => 'Failed to create access key']);
    }
} else {
    echo json_encode(['message' => 'Missing required fields']);
}
?>
