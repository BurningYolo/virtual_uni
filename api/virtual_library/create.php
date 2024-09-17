<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['title']) && isset($_POST['file_path'])) {
    $title = $_POST['title'];
    $author = isset($_POST['author']) ? $_POST['author'] : null;
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $file_path = $_POST['file_path'];
    $metadata = isset($_POST['metadata']) ? $_POST['metadata'] : null; // Assuming JSON is passed as a string

    $query = "INSERT INTO tbl_virtual_library (title, author, type, file_path, metadata) 
              VALUES (:title, :author, :type, :file_path, :metadata)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':file_path', $file_path);
    $stmt->bindParam(':metadata', $metadata);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Resource created successfully."]);
    } else {
        echo json_encode(["message" => "Failed to create resource."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
