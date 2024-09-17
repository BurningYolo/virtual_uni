<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

$query = "SELECT * FROM tbl_discussion_boards";
$result = $pdo->query($query);

$boards = $result->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($boards);
?>
