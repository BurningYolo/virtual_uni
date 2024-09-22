<?php
require_once '../../config/connection.php'; // Include your database connection

header('Content-Type: application/json');

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Initialize an array to hold the updates and an array for binding parameters
    $updates = [];
    $params = [];

    // Check for each field and add it to the updates array if set
    if (isset($_POST['username'])) {
        $updates[] = "username = :username";
        $params[':username'] = $_POST['username'];
    }
    
    if (isset($_POST['email'])) {
        $updates[] = "email = :email";
        $params[':email'] = $_POST['email'];
    }
    
    if (isset($_POST['password'])) {
        $updates[] = "password_hash = :password_hash";
        $params[':password_hash'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
    }
    
    if (isset($_POST['first_name'])) {
        $updates[] = "first_name = :first_name";
        $params[':first_name'] = $_POST['first_name'];
    }
    
    if (isset($_POST['last_name'])) {
        $updates[] = "last_name = :last_name";
        $params[':last_name'] = $_POST['last_name'];
    }
    
    if (isset($_POST['role'])) {
        $updates[] = "role = :role";
        $params[':role'] = $_POST['role'];
    }
    
    if (isset($_POST['profile_picture']) && !empty($_POST['profile_picture'])) {
        $updates[] = "profile_picture = :profile_picture";
        $params[':profile_picture'] = $_POST['profile_picture'];
    }
    if (isset($_POST['bio'])) {
        $updates[] = "bio = :bio";
        $params[':bio'] = $_POST['bio'];
    }

    // If no fields to update, return an error
    if (empty($updates)) {
        echo json_encode(["message" => "No fields to update."]);
        exit;
    }

    // Build the query
    $query = "UPDATE tbl_users SET " . implode(", ", $updates) . ", updated_at = CURRENT_TIMESTAMP WHERE user_id = :user_id";
    
    // Add user_id to the parameters
    $params[':user_id'] = $user_id;

    // Prepare and execute the statement
    $stmt = $pdo->prepare($query);
    foreach ($params as $key => &$value) {
        $stmt->bindParam($key, $value);
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
