<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_GET['kiosk_id'])) {
    $kiosk_id = $_GET['kiosk_id'];

    $query = "DELETE FROM tbl_information_kiosks WHERE kiosk_id = :kiosk_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':kiosk_id', $kiosk_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Information kiosk deleted successfully."]);
    } else {
        echo json_encode(["message" => "Failed to delete information kiosk."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
