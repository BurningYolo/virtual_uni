<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

// Function to generate a random 8-character key (capital letters and numbers)
function generateKey() {
    return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
}

if (isset($_POST['classroom_id'])) {
    $classroom_id = $_POST['classroom_id'];
    $new_key = generateKey();

    $query = "UPDATE tbl_virtual_classrooms SET `key` = :new_key, updated_at = CURRENT_TIMESTAMP WHERE classroom_id = :classroom_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':new_key', $new_key);
    $stmt->bindParam(':classroom_id', $classroom_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Key updated successfully.", "new_key" => $new_key]);
    } else {
        echo json_encode(["message" => "Failed to update token."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
