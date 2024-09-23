<?php
// Get the board_id passed to the handler
$board_id = $_GET['board'] ?? '';

if (empty($board_id)) {
    echo "Board ID is required";
    exit;
}

// API URL for fetching posts
$api_url = 'http://localhost/virtual_uni/api/posts/get_posts.php?board_id=' . $board_id;

try {
    // Fetch the data from the API
    $response = file_get_contents($api_url);
    $posts = json_decode($response, true);

    if (isset($posts['error'])) {
        // Handle the error response
        $posts = [];
        $error = $posts['error'];
    }

} catch (Exception $e) {
    echo "Error fetching posts: " . $e->getMessage();
}
?>
