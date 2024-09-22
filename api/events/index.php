<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

try {
    // Query to fetch events
    $query = "SELECT * FROM tbl_events";
    $result = $pdo->query($query);

    // Fetch all events as an associative array
    $events = $result->fetchAll(PDO::FETCH_ASSOC);

    // Return the events as JSON
    echo json_encode($events);
} catch (PDOException $e) {
    // Return an error message if the query fails
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
