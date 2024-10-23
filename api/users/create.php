<?php
require_once '../../config/connection.php'; // Include your database connection

header('Content-Type: application/json');

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    $username = $_POST['username'];
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : "student";
    $profile_picture = isset($_POST['profile_picture']) ? $_POST['profile_picture'] : null;
    $bio = isset($_POST['bio']) ? $_POST['bio'] : null;
    $access_key = isset($_POST['access_key']) ? $_POST['access_key'] : null;

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
        http_response_code(400);
        echo json_encode(["message" => "Email already exists."]);
    } else {
        // If the role is student or teacher, verify the access key
        if ($role === 'student' || $role === 'teacher') {
            if ($access_key) {
                $accessKeyQuery = "SELECT id, used FROM tbl_access_keys WHERE access_key = :access_key AND for_role = :role AND used = 0";
                $accessKeyStmt = $pdo->prepare($accessKeyQuery);
                $accessKeyStmt->bindParam(':access_key', $access_key);
                $accessKeyStmt->bindParam(':role', $role);
                $accessKeyStmt->execute();
                $accessKeyData = $accessKeyStmt->fetch(PDO::FETCH_ASSOC);

                if ($accessKeyData) {
                    // Proceed with user creation if the access key is valid
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
                        // POST the last inserted user ID
                        $user_id = $pdo->lastInsertId();

                        // Mark the access key as used and associate it with the new user
                        $updateKeyQuery = "UPDATE tbl_access_keys SET used = 1, used_by = :user_id WHERE access_key = :access_key";
                        $updateKeyStmt = $pdo->prepare($updateKeyQuery);
                        $updateKeyStmt->bindParam(':user_id', $user_id);
                        $updateKeyStmt->bindParam(':access_key', $access_key);
                        $updateKeyStmt->execute();

                        http_response_code(201);
                        echo json_encode(["message" => "User created successfully."]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["message" => "Failed to create user."]);
                    }
                } else {
                    // Invalid or used access key
                    http_response_code(400);
                    echo json_encode(["message" => "Invalid or used access key."]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Access key is required for this role."]);
            }
        } else {
            // If role is not student or teacher, proceed without access key validation
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
                http_response_code(201);
                echo json_encode(["message" => "User created successfully."]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Failed to create user."]);
            }
        }
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Invalid input."]);
}
?>
