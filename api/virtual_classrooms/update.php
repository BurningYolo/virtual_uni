<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['classroom_id']) && isset($_POST['classroom_name'])) {
    $classroom_id = $_POST['classroom_id'];
    $classroom_name = $_POST['classroom_name'];
    $description = isset($_POST['description']) ? $_POST['description'] : null;

    $query = "UPDATE tbl_virtual_classrooms SET 
                classroom_name = :classroom_name, 
                description = :description, 
                updated_at = CURRENT_TIMESTAMP 
              WHERE classroom_id = :classroom_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':classroom_name', $classroom_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':classroom_id', $classroom_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Virtual classroom updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update virtual classroom."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
