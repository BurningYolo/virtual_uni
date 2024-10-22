<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {



    $user_id = $_POST['user_id'];
    $feedback_text = $_POST['feedback_text']; // Use the comments field from your form
    $ratings = $_POST['ratings']; // Get the ratings

    // Prepare data for API
    $apiUrl = 'http://localhost/virtual_uni/api/feedback/create.php'; // Update with actual API URL

    // Prepare data for cURL
    $data = [
        'user_id' => $user_id,
        'feedback_text' => $feedback_text,
        'ratings' => $ratings
    ];

    // Initialize cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Send data as a URL-encoded query string
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded'
    ));

    // Execute cURL request and get response
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Return response
    if ($httpCode === 200) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $response]);
    }
}
?>
