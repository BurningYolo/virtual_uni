<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $query = "DELETE FROM tbl_events WHERE event_id = :event_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':event_id', $event_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Event deleted successfully."]);
    } else {
        echo json_encode(["message" => "Failed to delete event."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
