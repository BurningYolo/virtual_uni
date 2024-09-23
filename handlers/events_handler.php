<?php
// events_handler.php

    // Check if all required POST variables are set
    if (isset($_POST['event_name'], $_POST['description'], $_POST['start_time'], $_POST['end_time'], $_POST['location'])) {
        $event_name = $_POST['event_name'];
        $description = $_POST['description'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $location = $_POST['location'];

        // API endpoint URL
        $apiUrl = 'http://localhost/virtual_uni/api/events/create.php'; // Update with your actual API URL

        // Prepare data to send
        $data = [
            'event_name' => $event_name,
            'description' => $description,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'location' => $location
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
            echo json_encode(['message' => $responseData['message'] ?? 'Event created successfully.']);
            exit; 
        } else {
            echo json_encode(['message' => 'Failed to create event.']);
            exit; 
        }
    }
















// Define the API endpoint
$apiUrl = 'http://localhost/virtual_uni/api/events/';

// Initialize cURL
$curl = curl_init($apiUrl);

// Set cURL options
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($curl);

// Check for errors
if ($response === false) {
    die('Error fetching events: ' . curl_error($curl));
}

// Close the cURL session
curl_close($curl);

// Decode the JSON response
$events = json_decode($response, true);

// Check if events data was retrieved
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON response.');
}
?>
