<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_GET['classroom_id']) && isset($_GET['key'])) {
    $classroom_id = $_GET['classroom_id'];
    $key = $_GET['key'];

    $query = "SELECT * FROM tbl_virtual_classrooms WHERE classroom_id = :classroom_id AND `key` = :key";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':classroom_id', $classroom_id);
    $stmt->bindParam(':key', $key);

    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(["message" => "Token is valid."]);
    } else {
        echo json_encode(["message" => "Invalid token or classroom ID."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
