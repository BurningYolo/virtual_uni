<?php
require_once '../../config/connection.php';; // Include your database connection

header('Content-Type: application/json');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $query = "DELETE FROM tbl_users WHERE user_id = :user_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "User deleted successfully."]);
    } else {
        echo json_encode(["message" => "Failed to delete user."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
