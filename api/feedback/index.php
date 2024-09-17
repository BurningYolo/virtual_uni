<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

$query = "SELECT * FROM tbl_feedback";
$result = $pdo->query($query);

$feedbacks = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($feedbacks);
?>
