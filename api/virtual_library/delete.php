<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_GET['resource_id'])) {
    $resource_id = $_GET['resource_id'];

    $query = "DELETE FROM tbl_virtual_library WHERE resource_id = :resource_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':resource_id', $resource_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Resource deleted successfully."]);
    } else {
        echo json_encode(["message" => "Failed to delete resource."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
