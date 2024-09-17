<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['classroom_name'])) {
    $classroom_name = $_POST['classroom_name'];
    $description = isset($_POST['description']) ? $_POST['description'] : null;

    $query = "INSERT INTO tbl_virtual_classrooms (classroom_name, description) 
              VALUES (:classroom_name, :description)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':classroom_name', $classroom_name);
    $stmt->bindParam(':description', $description);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Virtual classroom created successfully."]);
    } else {
        echo json_encode(["message" => "Failed to create virtual classroom."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
