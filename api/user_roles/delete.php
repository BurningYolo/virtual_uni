<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_GET['role_id'])) {
    $role_id = $_GET['role_id'];

    $query = "DELETE FROM tbl_user_roles WHERE role_id = :role_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':role_id', $role_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "User role deleted successfully."]);
    } else {
        echo json_encode(["message" => "Failed to delete user role."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
