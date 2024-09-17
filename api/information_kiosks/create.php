<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['location_name'])) {
    $location_name = $_POST['location_name'];
    $content = isset($_POST['content']) ? $_POST['content'] : null;

    $query = "INSERT INTO tbl_information_kiosks (location_name, content) 
              VALUES (:location_name, :content)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':location_name', $location_name);
    $stmt->bindParam(':content', $content);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Information kiosk created successfully."]);
    } else {
        echo json_encode(["message" => "Failed to create information kiosk."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
