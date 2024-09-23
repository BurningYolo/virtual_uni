<?php
// Get the board_id passed to the handler


if (isset($_POST['board_id']) && isset($_POST['user_id']) && isset($_POST['content'])) {
    $board_id = $_POST['board_id'];
    $user_id = $_POST['user_id'];
    $content = $_POST['content'];

    // API URL to call
    $api_url = 'http://localhost/virtual_uni/api/posts/create.php';

    // Initialize cURL session
    $ch = curl_init($api_url);
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'board_id' => $board_id,
        'user_id' => $user_id,
        'content' => $content
    ]));

    // Execute the cURL session
    $response = curl_exec($ch);
    curl_close($ch);

    // Return the response to the client (in JSON format)
    echo $response;
    exit;
}
  







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
