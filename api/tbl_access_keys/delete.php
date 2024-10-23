<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

// Get the ID from the POST request
$id = isset($_POST['id']) ? $_POST['id'] : null;

if ($id) {
    $query = "DELETE FROM tbl_access_keys WHERE id = :id";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute(['id' => $id])) {
        echo json_encode(['message' => 'Access key deleted successfully']);
    } else {
        echo json_encode(['message' => 'Failed to delete access key']);
    }
} else {
    echo json_encode(['message' => 'Missing required fields']);
}
?>
