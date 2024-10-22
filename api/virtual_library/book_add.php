<?php

require_once '../../config/connection.php'; // Include your database connection

header('Content-Type: application/json');

$response = []; // Initialize the response array

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

    // Check if the temporary file exists
    if (file_exists($fileTmpPath)) {

        if (!is_dir($uploadFileDir) || !is_writable($uploadFileDir)) {
            $response = [
                "status" => "error",
                "message" => "Upload directory does not exist or is not writable.",
                "data" => [
                    "upload_directory" => realpath($uploadFileDir) ?: 'Not found',
                    "permissions" => substr(sprintf('%o', fileperms($uploadFileDir)), -4)
                ]
            ];
            echo json_encode($response);
            exit; // Stop execution if the directory is not writable
        }
        if (move_uploaded_file($fileTmpPath, $uploadFileDir . basename($fileName, $fileExtension) . '_' . $timeSuffix . '.' . $fileExtension)) {
            
            // Prepare the SQL query for inserting data into the database
            $query = "INSERT INTO tbl_virtual_library (title, author, type, file_path, metadata) 
                      VALUES (:title, :author, :type, :file_path, :metadata)";
            
            // Prepare the statement
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':file_path', $filePathForDB); // Use the file path created earlier
            $stmt->bindParam(':metadata', $metadata); // Metadata is already a JSON string
            
            // Execute the statement and check if the insertion was successful
            if ($stmt->execute()) {
                $response = [
                    "status" => "success",
                    "message" => "Resource created successfully.",
                    "data" => [
                        "title" => $title,
                        "author" => $author,
                        "type" => $type,
                        "file_path" => $filePathForDB,
                        "metadata" => $metadata
                    ]
                ];
            } else {
                $response = [
                    "status" => "error",
                    "message" => "Failed to create resource.",
                    "data" => [
                        "title" => $title,
                        "author" => $author,
                        "type" => $type,
                        "file_path" => $filePathForDB,
                        "metadata" => $metadata
                    ]
                ];
            }
        } else {
            error_log("File upload error: " . print_r($_FILES['file']['error'], true));
            $response = [
                "status" => "error",
                "message" => "File upload failed.",
                "data" => [
                    "title" => $title,
                    "author" => $author,
                    "type" => $type,
                    "metadata" => $metadata,
                    "file_error" => $_FILES['file']['error']
                ]
            ];
        }
    } else {
        $response = [
            "status" => "error",
            "message" => "Temporary file does not exist.",
            "data" => [
                "title" => $title,
                "author" => $author,
                "type" => $type,
                "metadata" => $metadata
            ]
        ];
    }
} else {
    $response = [
        "status" => "error",
        "message" => "Invalid input.",
        "data" => [
            "received_post_data" => $_POST,
            "received_file_data" => $_FILES
        ]
    ];
    error_log("POST Data: " . print_r($_POST, true));
    error_log("File Data: " . print_r($_FILES, true));
}

// Send the response
echo json_encode($response);
?>
