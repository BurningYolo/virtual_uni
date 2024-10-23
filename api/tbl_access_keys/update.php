<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

// Get data from POST request
$id = isset($_POST['id']) ? $_POST['id'] : null;
$for_role = isset($_POST['for_role']) ? $_POST['for_role'] : null;
$used = isset($_POST['used']) ? $_POST['used'] : null;

if ($id && ($for_role || $used !== null)) {
    // Create an array to hold the fields that are to be updated
    $updateFields = [];
    $params = ['id' => $id];

    if ($for_role) {
        $updateFields[] = "for_role = :for_role";
        $params['for_role'] = $for_role;
    }
    if ($used !== null) {
        $updateFields[] = "used = :used";
        $params['used'] = $used;
    }

    $query = "UPDATE tbl_access_keys SET " . implode(", ", $updateFields) . " WHERE id = :id";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute($params)) {
        echo json_encode(['message' => 'Access key updated successfully']);
    } else {
        echo json_encode(['message' => 'Failed to update access key']);
    }
} else {
    echo json_encode(['message' => 'Missing required fields']);
}
?>
