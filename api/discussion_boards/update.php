<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['board_id']) && isset($_POST['board_name'])) {
    $board_id = $_POST['board_id'];
    $board_name = $_POST['board_name'];
    $description = isset($_POST['description']) ? $_POST['description'] : null;

    $query = "UPDATE tbl_discussion_boards SET 
                board_name = :board_name, 
                description = :description, 
                updated_at = CURRENT_TIMESTAMP 
              WHERE board_id = :board_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':board_name', $board_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':board_id', $board_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Discussion board updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update discussion board."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
