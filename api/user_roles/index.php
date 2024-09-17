<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

$query = "SELECT * FROM tbl_user_roles";
$result = $pdo->query($query);

$roles = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($roles);
?>
