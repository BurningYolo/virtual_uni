<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

$query = "SELECT * FROM tbl_events";
$result = $pdo->query($query);

$events = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($events);
?>
