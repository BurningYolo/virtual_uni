<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

// Query to get all access keys
$query = "SELECT * FROM tbl_access_keys";
$result = $pdo->query($query);

$access_keys = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($access_keys);
?>
