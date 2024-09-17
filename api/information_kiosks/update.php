<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['kiosk_id']) && isset($_POST['location_name'])) {
    $kiosk_id = $_POST['kiosk_id'];
    $location_name = $_POST['location_name'];
    $content = isset($_POST['content']) ? $_POST['content'] : null;

    $query = "UPDATE tbl_information_kiosks SET 
                location_name = :location_name, 
                content = :content, 
                updated_at = CURRENT_TIMESTAMP 
              WHERE kiosk_id = :kiosk_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':location_name', $location_name);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':kiosk_id', $kiosk_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Information kiosk updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update information kiosk."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
