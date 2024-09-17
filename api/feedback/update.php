<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['feedback_id']) && isset($_POST['feedback_text']) && isset($_POST['rating'])) {
    $feedback_id = $_POST['feedback_id'];
    $feedback_text = $_POST['feedback_text'];
    $rating = $_POST['rating'];

    if ($rating < 1 || $rating > 5) {
        echo json_encode(["message" => "Rating must be between 1 and 5."]);
        exit;
    }

    $query = "UPDATE tbl_feedback SET 
                feedback_text = :feedback_text, 
                rating = :rating, 
                created_at = CURRENT_TIMESTAMP 
              WHERE feedback_id = :feedback_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':feedback_text', $feedback_text);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':feedback_id', $feedback_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Feedback updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update feedback."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
