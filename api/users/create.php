<?php
require_once '../../config/connection.php'; // Include your database connection

header('Content-Type: application/json');

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    $username = $_POST['username'];
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;
    $profile_picture = isset($_POST['profile_picture']) ? $_POST['profile_picture'] : null;
    $bio = isset($_POST['bio']) ? $_POST['bio'] : null;

    // Generate a 5-digit random token
    $token = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

    // Check if the email already exists
    $checkQuery = "SELECT COUNT(*) FROM tbl_users WHERE email = :email";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':email', $email);
    $checkStmt->execute();
    $emailCount = $checkStmt->fetchColumn();

    if ($emailCount > 0) {
        // Email already exists
        echo json_encode(["message" => "Email already exists."]);
    } else {
        // Email does not exist, proceed to insert the new user
        $query = "INSERT INTO tbl_users (username, password_hash, email, first_name, last_name, role, profile_picture, bio, token) 
                  VALUES (:username, :password_hash, :email, :first_name, :last_name, :role, :profile_picture, :bio, :token)";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':profile_picture', $profile_picture);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':token', $token);
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "User created successfully."]);
        } else {
            echo json_encode(["message" => "Failed to create user."]);
        }
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
