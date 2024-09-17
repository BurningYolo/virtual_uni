<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['role_id']) && isset($_POST['role_name']) && isset($_POST['permissions'])) {
    $role_id = $_POST['role_id'];
    $role_name = $_POST['role_name'];
    $permissions = $_POST['permissions']; // Assuming JSON is passed as a string

    $query = "UPDATE tbl_user_roles SET 
                role_name = :role_name, 
                permissions = :permissions 
              WHERE role_id = :role_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':role_name', $role_name);
    $stmt->bindParam(':permissions', $permissions);
    $stmt->bindParam(':role_id', $role_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "User role updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update user role."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
