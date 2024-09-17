<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['board_id']) && isset($_POST['user_id']) && isset($_POST['content'])) {
    $board_id = $_POST['board_id'];
    $user_id = $_POST['user_id'];
    $content = $_POST['content'];

    $query = "INSERT INTO tbl_posts (board_id, user_id, content) 
              VALUES (:board_id, :user_id, :content)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':board_id', $board_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':content', $content);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Post created successfully."]);
    } else {
        echo json_encode(["message" => "Failed to create post."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
