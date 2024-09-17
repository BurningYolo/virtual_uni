<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $query = "DELETE FROM tbl_posts WHERE post_id = :post_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':post_id', $post_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Post deleted successfully."]);
    } else {
        echo json_encode(["message" => "Failed to delete post."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
