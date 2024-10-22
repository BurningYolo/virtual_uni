<?php
// Include database connection
require_once '../../config/connection.php';

// Set header for JSON response
header('Content-Type: application/json');


// Extract feedback data
$user_id = $_POST['user_id'];
$feedback_text = $_POST['feedback_text'];
$ratings = $_POST['ratings'];
$created_at = date('Y-m-d H:i:s'); // Current timestamp

try {
    // Check if the user has already submitted feedback
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_feedback WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $feedbackCount = $stmt->fetchColumn();

    // If feedback already exists for this user, return a message
    if ($feedbackCount > 0) {
        http_response_code(200); // OK
        echo json_encode(['success' => false, 'message' => 'Feedback already submitted.']);
        exit;
    }

    // Begin transaction
    $pdo->beginTransaction();

    // Insert feedback text into tbl_feedback
    $stmt = $pdo->prepare("INSERT INTO tbl_feedback (user_id, feedback_text, created_at) VALUES (:user_id, :feedback_text, :created_at)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':feedback_text', $feedback_text);
    $stmt->bindParam(':created_at', $created_at);
    $stmt->execute();

    // Get the last inserted feedback ID
    $feedback_id = $pdo->lastInsertId();

    // Insert each rating into tbl_feedback_ratings
    foreach ($ratings as $question_id => $rating_value) {
        $stmt = $pdo->prepare("INSERT INTO tbl_feedback_ratings (feedback_id, question_id, rating) VALUES (:feedback_id, :question_id, :rating)");
        $stmt->bindParam(':feedback_id', $feedback_id);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->bindParam(':rating', $rating_value);
        $stmt->execute();
    }

    // Commit transaction
    $pdo->commit();

    // Return success response
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully.']);
} catch (PDOException $e) {
    // Rollback in case of error
    $pdo->rollBack();
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
