<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_GET['board_id'])) {
    $board_id = $_GET['board_id'];

    $query = "DELETE FROM tbl_discussion_boards WHERE board_id = :board_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':board_id', $board_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Discussion board deleted successfully."]);
    } else {
        echo json_encode(["message" => "Failed to delete discussion board."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
