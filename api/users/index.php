<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

$query = "SELECT * FROM tbl_users";
$result = $pdo->query($query);

$users = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($users);
?>
