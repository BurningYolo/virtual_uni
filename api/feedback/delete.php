<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_GET['feedback_id'])) {
    $feedback_id = $_GET['feedback_id'];

    $query = "DELETE FROM tbl_feedback WHERE feedback_id = :feedback_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':feedback_id', $feedback_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Feedback deleted successfully."]);
    } else {
        echo json_encode(["message" => "Failed to delete feedback."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
