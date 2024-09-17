<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_GET['classroom_id'])) {
    $classroom_id = $_GET['classroom_id'];

    $query = "DELETE FROM tbl_virtual_classrooms WHERE classroom_id = :classroom_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':classroom_id', $classroom_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Virtual classroom deleted successfully."]);
    } else {
        echo json_encode(["message" => "Failed to delete virtual classroom."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
