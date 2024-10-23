<?php
// Assuming session_start() is already called in a separate included file

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate incoming POST data
    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $userRole = isset($_POST['user_role']) ? $_POST['user_role'] : '';

    // Validate user role
    if ($userRole === "teacher") {
        $forRole = "student"; 
    } elseif ($userRole === "university") { // Fixed typo from "universsity"
        $forRole = "teacher"; 
    } else {
        echo json_encode(['message' => 'Invalid user role.']);
        exit; // Stop further execution
    }

    // Ensure userId and forRole are not empty
    if (empty($userId) || empty($forRole)) {
        echo json_encode(['message' => 'User ID and role must not be empty.']);
        exit; // Stop further execution
    }

    // Prepare API URL to create the access key
    $apiUrl = "http://localhost/virtual_uni/api/tbl_access_keys/create.php";

    // Prepare data for the API request
    $postData = [
        'created_by' => $userId,
        'for_role' => $forRole,
        'used' => 0
    ];

    // Initialize cURL
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));

    // Execute the cURL request
    $response = curl_exec($curl);

    // Check for cURL errors
    if ($response === false) {
        echo json_encode(['message' => 'Error creating access key: ' . curl_error($curl)]);
        exit; // Stop further execution
    }

    // Close the cURL session
    curl_close($curl);

    // Decode the JSON response from the API
    $apiResponse = json_decode($response, true);

    // Check the API response for success
    if (isset($apiResponse['message']) && $apiResponse['message'] === 'Access key created successfully') {
        echo json_encode(['message' => 'Access key created successfully.']);
    } else {
        echo json_encode(['message' => 'Failed to create access key: ' . ($apiResponse['message'] ?? 'Unknown error.')]);
    }
    exit; // Ensure to stop further execution
}

// Fetch access keys created by the specified user
$userId = $_SESSION['user_id']; // Ensure session variable is available
$apiUrl = "http://localhost/virtual_uni/api/tbl_access_keys/created_access_keys.php?user_id=" . urlencode($userId);

// Initialize cURL
$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($curl);

// Check for errors
if ($response === false) {
    die('Error fetching access keys: ' . curl_error($curl));
}

// Close the cURL session
curl_close($curl);

// Decode the JSON response
$accessKeys = json_decode($response, true);
?>
