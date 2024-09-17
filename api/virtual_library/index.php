<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

$query = "SELECT * FROM tbl_virtual_library";
$result = $pdo->query($query);

$resources = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($resources);
?>
