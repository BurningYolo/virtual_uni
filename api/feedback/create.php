<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['user_id']) && isset($_POST['feedback_text']) && isset($_POST['rating'])) {
    $user_id = $_POST['user_id'];
    $feedback_text = $_POST['feedback_text'];
    $rating = $_POST['rating'];

    if ($rating < 1 || $rating > 5) {
        echo json_encode(["message" => "Rating must be between 1 and 5."]);
        exit;
    }

    $query = "INSERT INTO tbl_feedback (user_id, feedback_text, rating) 
              VALUES (:user_id, :feedback_text, :rating)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':feedback_text', $feedback_text);
    $stmt->bindParam(':rating', $rating);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Feedback created successfully."]);
    } else {
        echo json_encode(["message" => "Failed to create feedback."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
