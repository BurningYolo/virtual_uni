<?php
// events_handler.php

// Define the API endpoint
$apiUrl = 'http://localhost/virtual_uni/api/discussion_boards/';

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
