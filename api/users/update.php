<?php
require_once '../../config/connection.php'; // Include your database connection

header('Content-Type: application/json');

if (isset($_POST['user_id']) && isset($_POST['username']) && isset($_POST['email'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password_hash = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
    $email = $_POST['email'];
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;
    $profile_picture = isset($_POST['profile_picture']) ? $_POST['profile_picture'] : null;
    $bio = isset($_POST['bio']) ? $_POST['bio'] : null;

    $query = "UPDATE tbl_users SET 
                username = :username, 
                email = :email, 
                first_name = :first_name, 
                last_name = :last_name, 
                role = :role, 
                profile_picture = :profile_picture, 
                bio = :bio, 
                updated_at = CURRENT_TIMESTAMP ";
                
    if ($password_hash) {
        $query .= ", password_hash = :password_hash ";
    }
    
    $query .= "WHERE user_id = :user_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':profile_picture', $profile_picture);
    $stmt->bindParam(':bio', $bio);
    $stmt->bindParam(':user_id', $user_id);
    
    if ($password_hash) {
        $stmt->bindParam(':password_hash', $password_hash);
    }
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "User updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update user."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
