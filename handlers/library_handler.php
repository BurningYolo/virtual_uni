<?php
// library_handler.php

// Define the API endpoint
$apiUrl = 'http://localhost/virtual_uni/api/virtual_library/';

// Initialize cURL
$curl = curl_init($apiUrl);

// Set cURL options
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($curl);

// Check for errors
if ($response === false) {
    die('Error fetching library resources: ' . curl_error($curl));
}

// Close the cURL session
curl_close($curl);

// Decode the JSON response
$libraryResources = json_decode($response, true);

// Check if the JSON response was valid
if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON response.');
}
?>
