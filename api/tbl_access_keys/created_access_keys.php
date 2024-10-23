<?php
// Include database connection
require_once '../../config/connection.php';
header('Content-Type: application/json');

// Check if user_id is provided
if (!isset($_GET['user_id'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Bad Request. User ID is required.']);
    exit();
}

// Get the user ID from the query parameter
$userId = $_GET['user_id'];

// Prepare the SQL query to fetch access keys created by the user and the username from tbl_users
$query = "
    SELECT ak.*, u.username AS used_by_username 
    FROM tbl_access_keys ak
    LEFT JOIN tbl_users u ON ak.used_by = u.user_id
    WHERE ak.created_by = :user_id
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

// Execute the query
if ($stmt->execute()) {
    $accessKeys = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the result as JSON
    echo json_encode($accessKeys);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error fetching access keys.']);
}
?>
