<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

// Function to generate a random 8-character key (capital letters and numbers)
function generateKey() {
    return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
}

if (isset($_POST['classroom_name']) && isset($_POST['subject'])) {
    $classroom_name = $_POST['classroom_name'];
    $subject = $_POST['subject'];
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $key = generateKey();

    $query = "INSERT INTO tbl_virtual_classrooms (classroom_name, description, `key`, subject) 
              VALUES (:classroom_name, :description, :key, :subject)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':classroom_name', $classroom_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':key', $key);
    $stmt->bindParam(':subject', $subject);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Virtual classroom created successfully.", "key" => $key]);
    } else {
        echo json_encode(["message" => "Failed to create virtual classroom."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
