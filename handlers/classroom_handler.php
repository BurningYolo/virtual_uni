<?php
// classrooms_handler.php

// Check if all required POST variables are set
if (isset($_POST['classroom_name'], $_POST['description'], $_POST['subject'])) {
    $classroom_name = $_POST['classroom_name'];
    $description = $_POST['description'];
    $subject = $_POST['subject'];

    // API endpoint URL
    $apiUrl = 'http://localhost/virtual_uni/api/virtual_classrooms/create.php'; // Update with your actual API URL

    // Prepare data to send
    $data = [
        'classroom_name' => $classroom_name,
        'description' => $description,
        'subject' => $subject
    ];

    // Initialize cURL
    $ch = curl_init($apiUrl);

    // Set options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Close cURL
    curl_close($ch);

    // Handle response
    if ($httpCode === 200) {
        // Assuming the API returns a JSON response
        $responseData = json_decode($response, true);
        echo json_encode(['message' => $responseData['message'] ?? 'Classroom created successfully.']);
        exit; 
    } else {
        echo json_encode(['message' => 'Failed to create classroom.']);
        exit; 
    }
}
?>

<?php
// Fetch classrooms using the API
$apiUrl = 'http://localhost/virtual_uni/api/virtual_classrooms/';

// Initialize cURL
$curl = curl_init($apiUrl);

// Set cURL options
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($curl);

// Check for errors
if ($response === false) {
    die('Error fetching classrooms: ' . curl_error($curl));
}

// Close the cURL session
curl_close($curl);

// Decode the JSON response
$classrooms = json_decode($response, true);

// Check if classroom data was retrieved
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON response.');
}
?>
