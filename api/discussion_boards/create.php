<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['board_name'])) {
    $board_name = $_POST['board_name'];
    $description = isset($_POST['description']) ? $_POST['description'] : null;

    $query = "INSERT INTO tbl_discussion_boards (board_name, description) 
              VALUES (:board_name, :description)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':board_name', $board_name);
    $stmt->bindParam(':description', $description);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Discussion board created successfully."]);
    } else {
        echo json_encode(["message" => "Failed to create discussion board."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
