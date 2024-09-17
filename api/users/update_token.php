<?php
require_once '../../config/connection.php'; // Include your database connection

header('Content-Type: application/json');

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email exists
    $checkQuery = "SELECT COUNT(*) FROM tbl_users WHERE email = :email";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindParam(':email', $email);
    $checkStmt->execute();
    $emailCount = $checkStmt->fetchColumn();

    if ($emailCount > 0) {
        // Email exists, generate a new 5-digit random token
        $newToken = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

        // Update the token in the database
        $updateQuery = "UPDATE tbl_users SET token = :newToken, updated_at = CURRENT_TIMESTAMP WHERE email = :email";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':newToken', $newToken);
        $updateStmt->bindParam(':email', $email);

        if ($updateStmt->execute()) {
            echo json_encode(["message" => "Token updated successfully.", "new_token" => $newToken]);
        } else {
            echo json_encode(["message" => "Failed to update token."]);
        }
    } else {
        // Email does not exist
        echo json_encode(["message" => "Email does not exist."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>