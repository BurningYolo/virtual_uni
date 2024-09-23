<?php
// library_handler.php
    // Validate required POST variables
// Validate required POST variables
if (isset($_POST['title']) && isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Gather and sanitize input data
    $title = trim($_POST['title']);
    $author = isset($_POST['author']) ? trim($_POST['author']) : null;
    $type = isset($_POST['type']) ? trim($_POST['type']) : null;

    // Properly handle metadata input
    $metadata = isset($_POST['metadata']) ? $_POST['metadata'] : "{}"; 

    // Handle file upload
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $timeSuffix = time();
    $uploadFileDir = '../books/'; // Directory to store the book
    
    // Get the file extension
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    
    // Construct the file path for the database with the correct extension
    $filePathForDB = './books/' . basename($fileName, $fileExtension) . '_' . $timeSuffix . '.' . $fileExtension;
    
    // Move the uploaded file to the desired location
    if (move_uploaded_file($fileTmpPath, $uploadFileDir . basename($fileName, $fileExtension) . '_' . $timeSuffix . '.' . $fileExtension)) {
        
        // Prepare data for API request
        $apiUrl = 'http://localhost/virtual_uni/api/virtual_library/create.php/'; // Replace with your actual API endpoint
        $data = [
            'title' => $title,
            'author' => $author,
            'type' => $type,
            'file_path' => $filePathForDB, // Store path for the database
            'metadata' => $metadata // Metadata should already be a JSON string
        ];

        // Initialize cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Execute cURL request and get response
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo $response;
        exit;

    } 
}


























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
