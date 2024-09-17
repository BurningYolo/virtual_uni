<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

if (isset($_POST['event_name'])) {
    $event_name = $_POST['event_name'];
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : null;
    $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : null;
    $location = isset($_POST['location']) ? $_POST['location'] : null;

    $query = "INSERT INTO tbl_events (event_name, description, start_time, end_time, location) 
              VALUES (:event_name, :description, :start_time, :end_time, :location)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':event_name', $event_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':location', $location);
    
    if ($stmt->execute()) {
        echo json_encode(["message" => "Event created successfully."]);
    } else {
        echo json_encode(["message" => "Failed to create event."]);
    }
} else {
    echo json_encode(["message" => "Invalid input."]);
}
?>
