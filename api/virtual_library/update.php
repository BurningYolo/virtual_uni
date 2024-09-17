<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['resource_id']) && isset($_POST['title']) && isset($_POST['file_path'])) {
    $resource_id = $_POST['resource_id'];
    $title = $_POST['title'];
    $author = isset($_POST['author']) ? $_POST['author'] : null;
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $file_path = $_POST['file_path'];
    $metadata = isset($_POST['metadata']) ? $_POST['metadata'] : null; // Assuming JSON is passed as a string

    $query = "UPDATE tbl_virtual_library SET 
                title = :title, 
                author = :author, 
                type = :type, 
                file_path = :file_path, 
                metadata = :metadata, 
                updated_at = CURRENT_TIMESTAMP 
              WHERE resource_id = :resource_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':file_path', $file_path);
    $stmt->bindParam(':metadata', $metadata);
    $stmt->bindParam(':resource_id', $resource_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Resource updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update resource."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
