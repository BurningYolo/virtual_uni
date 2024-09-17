<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['post_id']) && isset($_POST['content'])) {
    $post_id = $_POST['post_id'];
    $content = $_POST['content'];

    $query = "UPDATE tbl_posts SET 
                content = :content, 
                updated_at = CURRENT_TIMESTAMP 
              WHERE post_id = :post_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':post_id', $post_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Post updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update post."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
