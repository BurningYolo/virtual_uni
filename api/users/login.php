<?php 
require_once '../../config/connection.php'; 
header('Content-Type: application/json');
// Initialize variables to hold the response message and debug information
$responseMessage = '';
$debugInfo = [];

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : "student"; // Default role is student if not provided

    // Prepare SQL query to check if email and role exist
    $query = "SELECT * FROM tbl_users WHERE email = :email AND role = :role";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Store debug info
        $debugInfo = [
            "email_sent" => $email,
            "role_sent" => $role,
            "password_sent" => $password,
            "password_hash_from_db" => $user['password_hash'],
            "password_verification_result" => password_verify($password, $user['password_hash'])
        ];

        // Check if password matches
        if (password_verify($password, $user['password_hash'])) {
            $responseMessage = "Login successful.";
        } else {
            $responseMessage = "Incorrect password.";
        }
    } else {
        $responseMessage = "Email and role combination not found.";
    }
} else {
    $responseMessage = "Invalid input.";
}

// Echo the response for JSON format
echo json_encode([
    "message" => $responseMessage,
    "debug" => $debugInfo
]);

?>
