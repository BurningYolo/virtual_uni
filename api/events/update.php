<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['event_id']) && isset($_POST['event_name'])) {
    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : null;
    $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : null;
    $location = isset($_POST['location']) ? $_POST['location'] : null;

    $query = "UPDATE tbl_events SET 
                event_name = :event_name, 
                description = :description, 
                start_time = :start_time, 
                end_time = :end_time, 
                location = :location, 
                updated_at = CURRENT_TIMESTAMP 
              WHERE event_id = :event_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':event_name', $event_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':event_id', $event_id);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Event updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update event."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
