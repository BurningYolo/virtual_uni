<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

$query = "SELECT * FROM tbl_virtual_classrooms";
$result = $pdo->query($query);

$classrooms = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($classrooms);
?>
