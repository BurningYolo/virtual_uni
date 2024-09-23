<?php
// Include your database connection file
require_once '../../config/connection.php';

header('Content-Type: application/json');
$board_id = $_GET['board_id'] ?? '';
if (empty($board_id)) {
    echo json_encode(['error' => 'Board ID is required']);
    exit;
}

try {
    // Create the query to fetch posts and user info
    $query = "
        SELECT p.post_id, p.content, p.created_at, u.username, u.profile_picture 
        FROM tbl_posts p
        JOIN tbl_users u ON p.user_id = u.user_id
        WHERE p.board_id = :board_id
        ORDER BY p.created_at DESC
    ";

    // Prepare the query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':board_id', $board_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch all the posts with user information
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($posts) {
        // Return the posts as JSON
        echo json_encode($posts);
    } else {
        echo json_encode(['error' => 'No posts found']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error fetching posts: ' . $e->getMessage()]);
}
?>