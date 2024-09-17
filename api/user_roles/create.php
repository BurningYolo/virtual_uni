<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['role_name']) && isset($_POST['permissions'])) {
    $role_name = $_POST['role_name'];
    $permissions = $_POST['permissions']; // Assuming JSON is passed as a string

    $query = "INSERT INTO tbl_user_roles (role_name, permissions) 
              VALUES (:role_name, :permissions)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':role_name', $role_name);
    $stmt->bindParam(':permissions', $permissions);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "User role created successfully."]);
    } else {
        echo json_encode(["message" => "Failed to create user role."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
